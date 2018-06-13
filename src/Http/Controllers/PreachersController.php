<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\PreachersRepository;
use Bishopm\Connexion\Repositories\PositionsRepository;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Repositories\SocietiesRepository;
use Bishopm\Connexion\Repositories\SettingsRepository;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreatePreacherRequest;
use Bishopm\Connexion\Http\Requests\UpdatePreacherRequest;
use Bishopm\Connexion\Libraries\Fpdf\Fpdf;

class PreachersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $preacher;
    private $individuals;
    private $societies;
    private $settings;
    private $positions;

    public function __construct(PreachersRepository $preacher, IndividualsRepository $individuals, SocietiesRepository $societies, SettingsRepository $settings, PositionsRepository $positions)
    {
        $this->preacher = $preacher;
        $this->individuals = $individuals;
        $this->societies = $societies;
        $this->settings = $settings;
        $this->positions = $positions;
    }

    public function index()
    {
        $preachers = $this->preacher->all();
        if (($preachers=="No valid url") or ($this->settings->getkey('circuit')=='')) {
            return redirect()->route('admin.settings.index')->with('notice', 'Please ensure that the circuit and API url are correctly specified');
        } else {
            return view('connexion::preachers.index', compact('preachers'));
        }
    }

    public function meeting($year)
    {
        $preachers = $this->preacher->all();
        if ($preachers=="No valid url") {
            return redirect()->route('admin.settings.index')->with('notice', 'Please ensure that the API url is correctly specified');
        } else {
            $pdf = new Fpdf();
            $pdf->AddPage('P');
            $logopath=base_path() . '/public/vendor/bishopm/images/mcsa.jpg';
            $pdf->SetAutoPageBreak(true, 0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Image($logopath, 10, 5, 0, 21);
            $pdf->SetFillColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 10);
            $pdf->line(10, 31, 199, 31);
            $y=45;
            foreach ($preachers as $preacher) {
                if (($preacher->status=="Local preacher") or ($preacher->status=="On trial preacher") or ($preacher->status=="Emeritus preacher")) {
                    if ($preacher->status=="Emeritus preacher") {
                        $pdf->text(8, $y, '*');
                    }
                    $pdf->text(10, $y, $preacher->title . " " . utf8_decode($preacher->firstname) . " " . utf8_decode($preacher->surname) . " (" . $preacher->fullplan . ")");
                    $pdf->text(80, $y, $preacher->society->society);
                    $pdf->text(110, $y, $preacher->phone);
                    $pdf->rect(145, $y-3, 12, 4);
                    $pdf->rect(159, $y-3, 12, 4);
                    $pdf->rect(173, $y-3, 12, 4);
                    $pdf->rect(187, $y-3, 12, 4);
                    $y=$y+5;
                }
            }
            $pdf->text(148, 40, "Jan");
            $pdf->text(162, 40, "Apr");
            $pdf->text(176, 40, "Jul");
            $pdf->text(190, 40, "Oct");
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->text(35, 10, "THE METHODIST CHURCH OF SOUTHERN AFRICA");
            $pdf->text(35, 17, $preacher->circuit->circuit);
            $pdf->text(35, 24, "LOCAL PREACHERS MEETINGS: " . $year);
            $pdf->Output();
            exit;
        }
    }

    public function edit($id)
    {
        $data['circuit'] = $this->settings->getkey('circuit');
        $data['societies'] = $this->societies->all();
        $data['preacher']=$this->preacher->find($id);
        $data['positions']=$this->positions->all();
        foreach ($data['preacher']->positions as $pos) {
            $data['pos'][]=$pos->id;
        }
        return view('connexion::preachers.edit', $data);
    }

    public function create()
    {
        $data['individuals'] = $this->individuals->all();
        $data['societies'] = $this->societies->all();
        $data['circuit'] = $this->settings->getkey('circuit');
        if (count($data['societies'])) {
            return view('connexion::preachers.create', $data);
        } else {
            return redirect()->route('admin.societies.create')->with('notice', 'At least one society must be added before adding a preacher');
        }
    }

    public function show($id)
    {
        $data['preacher']=$this->preacher->find($id);
        return view('connexion::preachers.show', $data);
    }

    public function store(CreatePreacherRequest $request)
    {
        $this->preacher->create($request->except('image', 'token'));

        return redirect()->route('admin.preachers.index')
            ->withSuccess('New preacher added');
    }
    
    public function update($id, UpdatePreacherRequest $request)
    {
        $this->preacher->update($id, $request->except('image', 'token'));
        if ($request->deletion_type<>"") {
            $this->preacher->destroy($id);
            return redirect()->route('admin.preachers.index')->withSuccess('Preacher has been deleted');
        } else {
            return redirect()->route('admin.preachers.index')->withSuccess('Preacher has been updated');
        }
    }
}
