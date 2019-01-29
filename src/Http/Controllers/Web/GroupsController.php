<?php

namespace Bishopm\Connexion\Http\Controllers\Web;

use Bishopm\Connexion\Repositories\GroupsRepository;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Repositories\SettingsRepository;
use Bishopm\Connexion\Models\Group;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Libraries\Fpdf\Fpdf;
use Bishopm\Connexion\Http\Requests\CreateGroupRequest;
use Bishopm\Connexion\Http\Requests\UpdateGroupRequest;
use DB;
use Illuminate\Http\Request;

class GroupsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $group;
    private $setting;

    public function __construct(GroupsRepository $group, IndividualsRepository $individuals, SettingsRepository $setting)
    {
        $this->group = $group;
        $this->individuals= $individuals;
        $this->setting = $setting;
    }

    public function index()
    {
        $groups = $this->group->all();
        return view('connexion::groups.index', compact('groups'));
    }
    
    public function api_groups()
    {
        return $this->group->nonadmin();
    }

    public function api_group($id)
    {
        return $this->group->find($id);
    }

    public function edit(Group $group)
    {
        $indivs=$this->individuals->all();
        return view('connexion::groups.edit', compact('group', 'indivs'));
    }

    public function report(Group $group)
    {
        $pg=1;
        $pdf = new Fpdf;
        $pdf->AddPage('P');
        $logopath=base_path() . '/public/vendor/bishopm/images/';
        $pdf->SetAutoPageBreak(true, 0);
        $pdf->SetFont('Helvetica', 'B', 14);
        $pdf->Image($logopath . 'logo.png', 20, 10, 40);
        $pdf->setxy(75, 14);
        $pdf->cell(120, 0, $group->groupname, 0, 0, 'R');
        $pdf->SetFont('Helvetica', 'I', 9);
        $pdf->setxy(75, 19);
        $pdf->cell(120, 0, date("j F Y"), 0, 0, 'R');
        $pdf->SetFont('Helvetica', '', 9);
        $pdf->setxy(75, 24);
        $pdf->cell(120, 0, 'Page: ' . $pg, 0, 0, 'R');
        $pdf->setxy(75, 28);
        $pdf->cell(120, 0, 'For corrections, email us: ' . $this->setting->getkey('church_email'), 0, 0, 'R');
        $pdf->line(20, 35, 193, 35);
        $pdf->SetFont('Helvetica', 'B', 10);
        $pdf->text(20, 40, "Name");
        $pdf->text(100, 40, "Phone");
        $pdf->text(165, 40, "Birthday");
        $pdf->line(20, 42, 193, 42);
        $y=48;
        foreach ($group->individuals as $indiv) {
            if ($y>=265) {
                $pg++;
                $pdf->AddPage('P');
                $pdf->SetFont('Helvetica', 'B', 14);
                $pdf->Image($logopath . 'logo.png', 20, 10, 40);
                $pdf->setxy(75, 14);
                $pdf->cell(120, 0, $group->groupname, 0, 0, 'R');
                $pdf->SetFont('Helvetica', 'I', 9);
                $pdf->setxy(75, 19);
                $pdf->cell(120, 0, date("j F Y"), 0, 0, 'R');
                $pdf->setxy(75, 24);
                $pdf->SetFont('Helvetica', '', 9);
                $pdf->cell(120, 0, 'Page: ' . $pg, 0, 0, 'R');
                $pdf->setxy(75, 28);
                $pdf->cell(120, 0, 'For corrections, email us: ' . $this->setting->getkey('church_email'), 0, 0, 'R');
                $pdf->line(20, 35, 193, 35);
                $pdf->SetFont('Helvetica', 'B', 10);
                $pdf->text(20, 40, "Name");
                $pdf->text(100, 40, "Phone");
                $pdf->text(165, 40, "Birthday");
                $pdf->line(20, 42, 193, 42);
                $y=48;
            }
            $pdf->SetFont('Helvetica', '', 10);
            $pdf->text(20, $y, $indiv->surname . ', ' . $indiv->firstname);
            if ($indiv->cellphone) {
                $pdf->text(100, $y, $indiv->cellphone);
            } elseif ($indiv->homephone) {
                $pdf->text(100, $y, $indiv->homephone);
            }
            $pdf->text(165, $y, date("j F", strtotime($indiv->birthdate)));
            $y=$y+6;
        }
        $pdf->line(20, 280, 195, 280);
        $pdf->setxy(20, 285);
        $pdf->SetFont('Helvetica', 'I', 10);
        $pdf->cell(185, 0, $this->setting->getkey('church_mission'), 0, 0, 'C');
        $pdf->Output();
        exit;
    }

    public function create()
    {
        $indivs=$this->individuals->all();
        return view('connexion::groups.create', compact('indivs'));
    }

    public function show(Group $group)
    {
        $data['individuals']=$this->individuals->all();
        $data['group']=$group;
        $data['leader']=$this->individuals->find($group->leader);
        return view('connexion::groups.show', $data);
    }

    public function store(CreateGroupRequest $request)
    {
        $group=$this->group->create($request->all());

        return redirect()->route('admin.groups.show', $group->id)
            ->withSuccess('New group added');
    }
    
    public function update(Group $group, UpdateGroupRequest $request)
    {
        if (!isset($request->publish)) {
            $request->request->add(['publish'=>0]);
            $this->group->update($group, $request->all());
            return redirect()->route('admin.groups.index')->withSuccess('Group has been updated');
        } elseif ($request->publish=="webedit") {
            $group=$this->group->update($group, $request->except('publish'));
            $group->publish=1;
            $group->save();
            return redirect()->route('webgroup', $group->slug)->withSuccess('Group has been updated');
        } else {
            $this->group->update($group, $request->all());
            return redirect()->route('admin.groups.index')->withSuccess('Group has been updated');
        }
    }

    public function addmember(Group $group, $memberid)
    {
        foreach ($group->pastmembers as $prev) {
            if ($prev->id==$memberid) {
                $group->individuals()->detach($memberid);
            }
        }
        if (!$group->individuals->contains($memberid)) {
            $group->individuals()->attach($memberid);
        }
    }

    public function removemember(Group $group, $memberid)
    {
        DB::table('group_individual')->where('group_id', $group->id)->where('individual_id', $memberid)->update(array('deleted_at' => DB::raw('NOW()')));
    }

    public function signup(Group $group, Request $request)
    {
        foreach ($request->input('individual_id') as $indiv) {
            $this->addmember($group, $indiv);
        }
        return redirect()->route('webcourses')->withSuccess('Sign-up complete :)');
    }

    public function destroy($id)
    {
        $group=$this->group->find($id);
        $group->delete();
        return redirect()->route('admin.groups.index')->withSuccess('Group has been deleted');
    }
}
