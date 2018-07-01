<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\HouseholdsRepository;
use Bishopm\Connexion\Repositories\GroupsRepository;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Models\Household;
use Bishopm\Connexion\Models\User;
use Bishopm\Connexion\Models\Individual;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreateHouseholdRequest;
use Bishopm\Connexion\Http\Requests\UpdateHouseholdRequest;
use Bishopm\Connexion\Models\Setting;
use Illuminate\Http\Request;
use Bishopm\Connexion\Libraries\Fpdf\Fpdf;

class HouseholdsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $household;
    private $groups;
    private $setting;

    public function __construct(HouseholdsRepository $household, GroupsRepository $groups, SettingsRepository $setting)
    {
        $this->household = $household;
        $this->groups = $groups;
        $this->setting = $setting;
    }

    public function index()
    {
        $households = $this->household->all();
        return view('connexion::households.index', compact('households'));
    }

    public function edit(Household $household)
    {
        $data['household']=$household;
        foreach ($household->individuals as $indiv) {
            if (strlen($indiv->cellphone)==10) {
                $data['cellphones'][$indiv->id]['name']=$indiv->firstname;
            }
        }
        return view('connexion::households.edit', $data);
    }

    public function create()
    {
        return view('connexion::households.create');
    }

    public function show(Household $household)
    {
        $pastoralgroup=$this->setting->getkey('pastoral_group');
        if ((isset($pastoralgroup)) and ($pastoralgroup<>'Pastoral group')) {
            $group=$this->groups->find($pastoralgroup);
            foreach ($group->individuals as $indiv) {
                $dum['id']=$indiv->id;
                $dum['firstname']=$indiv->firstname;
                $dum['surname']=$indiv->surname;
                $data['pastors'][]=$dum;
            }
        } else {
            $data['pastors']=array();
        }
        $data['groups']=$this->groups->all();
        $data['household']=$household;
        $data['tags']=Individual::allTags()->get();
        $data['logs']=array();
        foreach ($household->individuals as $indiv) {
            $activity=$indiv->activity->last();
            if ($activity) {
                if ($activity->causer_id) {
                    $user=User::find($activity->causer_id);
                    $thislog=ucfirst($activity['description']) . " by " .  $user->individual->firstname . " " . $user->individual->surname . " on " . date("d M Y", strtotime($activity['created_at']));
                } else {
                    $thislog=ucfirst($activity['description']) . " by System on " . date("d M Y", strtotime($activity['created_at']));
                }
                $data['logs'][$indiv->id]=$thislog;
            }
            if ($indiv->tags) {
                foreach ($indiv->tags as $itag) {
                    $data['itags'][$indiv->id][]=$itag->name;
                }
            }
            if ($indiv->groups) {
                foreach ($indiv->groups as $group) {
                    $data['igroups'][$indiv->id][]=$group->id;
                }
            }
        }
        return view('connexion::households.show', $data);
    }

    public function store(CreateHouseholdRequest $request)
    {
        $household=$this->household->create($request->all());

        return redirect()->route('admin.households.show', $household->id)
            ->withSuccess('New household added - now add an individual');
    }

    public function update(Household $household, UpdateHouseholdRequest $request)
    {
        $this->household->update($household, $request->all());
        if (null!==$request->input('latitude')) {
            return redirect()->route('admin.households.index')->withSuccess('Household has been updated');
        } else {
            return redirect()->route('mydetails')->withSuccess('Household has been updated');
        }
    }

    public function api_households(Request $request)
    {
        $q=$request->search;
        $individuals=Individual::with('household')->where('surname', 'like', '%' . $q . '%')->orwhere('firstname', 'like', '%' . $q . '%')->orderBy('surname')->orderBy('firstname')->get();
        return $individuals;
    }

    public function api_household($id)
    {
        return $this->household->findForApi($id);
    }

    public function destroy($id)
    {
        $household=$this->household->find($id);
        foreach ($household->individuals as $indiv) {
            $indiv->delete();
        }
        $household->delete();
        return redirect()->route('admin.households.index')->withSuccess('Household has been deleted');
    }

    public function report($id=0)
    {
        if ($id == 0) {
            $households = Household::with('individuals')->orderBy('sortsurname')->get();
        } else {
            $households = Household::with('individuals')->where('id', $id)->orderBy('sortsurname')->get();
        }
        $pdf = new Fpdf();
        $pdf->SetAutoPageBreak(true, 0);
        $logopath=base_path() . '/public/vendor/bishopm/images/mcsa.jpg';
        $pdf->SetFillColor(255, 255, 255);
        foreach ($households as $household) {
            $pdf->AddPage('P');
            $pdf->Image($logopath, 177, 6, 0, 21);
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->text(10, 11, $this->setting->getkey('site_name'));
            $pdf->SetFont('Arial', '', 14);
            $pdf->text(10, 23, utf8_decode($household->addressee));
            $pdf->RoundedRect(7, 5, 192, 22, 5, '1234', 'D');
            $pdf->SetFont('Arial', '', 12);
            $address = trim($household->addr1);
            if ($household->addr2) {
                $address.=", " . trim($household->addr2);
                if ($household->addr3) {
                    $address.=", " . trim($household->addr3);
                }
            }
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->text(10, 36, "Physical address");
            $pdf->SetFont('Arial', '', 12);
            $pdf->text(50, 36, utf8_decode($address));
            $pdf->RoundedRect(47, 30, 152, 9, 2, '1234', 'D');
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->text(10, 48, "Home phone");
            $pdf->SetFont('Arial', '', 12);
            $pdf->text(50, 48, utf8_decode($household->homephone));
            $pdf->RoundedRect(47, 42, 152, 9, 2, '1234', 'D');
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->text(10, 60, 'If we send an SMS to your household, who should it go to?');
            $pdf->SetFont('Arial', '', 12);
            $hc="";
            if ($household->householdcell) {
                $hhc=Individual::find($household->householdcell);
                if (count($hhc)) {
                    $hc=$hhc->firstname;
                }
            }
            $pdf->text(141, 60, utf8_decode($hc));
            $pdf->RoundedRect(137, 54, 62, 9, 2, '1234', 'D');
            // $pdf->cell($x_add, $y_add-6, date("j M", $sun['dt']), 0, 0, 'C');
            $y=68;
            foreach ($household->individuals as $indiv) {
                $this->indivblock($indiv, $y, $pdf);
                if ($y>220) {
                    $pdf->AddPage('P');
                    $y=10;
                } else {
                    $y=$y+45;
                }
            }
        }
        $pdf->Output();
        exit;
    }

    private function indivblock($indiv, $y, $pdf)
    {
        $pdf->RoundedRect(7, $y, 192, 41, 2, '1234', 'D');
        
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->text(10, $y+7, "First name");
        $pdf->RoundedRect(33, $y+1, 70, 9, 2, '1234', 'D');
        $pdf->SetFont('Arial', '', 12);
        $pdf->text(35, $y+7, utf8_decode($indiv->firstname));
        
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->text(10, $y+17, "Surname");
        $pdf->RoundedRect(33, $y+11, 70, 9, 2, '1234', 'D');
        $pdf->SetFont('Arial', '', 12);
        $pdf->text(35, $y+17, utf8_decode($indiv->surname));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->text(10, $y+27, "Email");
        $pdf->RoundedRect(33, $y+21, 70, 9, 2, '1234', 'D');
        $pdf->SetFont('Arial', '', 12);
        $pdf->text(35, $y+27, utf8_decode($indiv->email));

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->text(10, $y+37, "Cellphone");
        $pdf->RoundedRect(33, $y+31, 70, 9, 2, '1234', 'D');
        $pdf->SetFont('Arial', '', 12);
        $pdf->text(35, $y+37, $indiv->cellphone);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->text(105, $y+7, "Title");
        $pdf->RoundedRect(115, $y+1, 15, 9, 2, '1234', 'D');
        $pdf->SetFont('Arial', '', 12);
        $pdf->text(117, $y+7, $indiv->title);

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->text(135, $y+7, "Sex");
        $pdf->RoundedRect(145, $y+1, 15, 9, 2, '1234', 'D');
        $pdf->SetFont('Arial', '', 12);
        if ($indiv->sex) {
            $pdf->text(151, $y+7, strtoupper(substr($indiv->sex, 0, 1)));
        } else {
            $pdf->text(148, $y+7, 'M / F');
        }

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->text(105, $y+17, "Date of birth");
        $pdf->RoundedRect(132, $y+11, 66, 9, 2, '1234', 'D');
        $pdf->SetFont('Arial', '', 12);
        if ($indiv->birthdate<>'0000-00-00') {
            $pdf->text(134, $y+17, $indiv->birthdate);
        }

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->text(105, $y+27, "Membership");
        $pdf->SetFont('Arial', '', 12);
        $pdf->RoundedRect(133, $y+21, 9, 9, 2, '1234', 'D');
        $pdf->text(143, $y+27, 'Member');
        $pdf->RoundedRect(162, $y+21, 9, 9, 2, '1234', 'D');
        $pdf->text(172, $y+27, 'Non-member');
        $pdf->RoundedRect(133, $y+31, 9, 9, 2, '1234', 'D');
        $pdf->text(143, $y+37, 'Child');
        if (strtolower($indiv->memberstatus) == "member") {
            $pdf->text(136, $y+27, 'X');
        } elseif (strtolower($indiv->memberstatus) == "child") {
            $pdf->text(136, $y+37, 'X');
        } elseif (strtolower($indiv->memberstatus) == "non-member") {
            $pdf->text(165, $y+27, 'X');
        }
    }
}
