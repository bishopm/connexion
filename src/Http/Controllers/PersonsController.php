<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\PersonsRepository;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Repositories\SocietiesRepository;
use Bishopm\Connexion\Repositories\SettingsRepository;
use App\Http\Controllers\Controller;
use Bishopm\Connexion\Http\Requests\CreatePersonRequest;
use Bishopm\Connexion\Http\Requests\UpdatePersonRequest;
use Bishopm\Connexion\Libraries\Fpdf\Fpdf;

class PersonsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $person;
    private $individuals;
    private $societies;
    private $settings;

    public function __construct(PersonsRepository $person, IndividualsRepository $individuals, SocietiesRepository $societies, SettingsRepository $settings)
    {
        $this->person = $person;
        $this->individuals = $individuals;
        $this->societies = $societies;
        $this->settings = $settings;
    }

    public function index()
    {
        $persons = $this->person->all();
        if (($persons=="No valid url") or ($this->settings->getkey('circuit')=='')) {
            return redirect()->route('admin.settings.index')->with('notice', 'Please ensure that the circuit and API url are correctly specified');
        } else {
            return view('connexion::persons.index', compact('persons'));
        }
    }

    public function meeting($year)
    {
        $persons = $this->person->all();
        if ($persons=="No valid url") {
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
            foreach ($persons as $person) {
                if (($person->status=="Local person") or ($person->status=="On trial person") or ($person->status=="Emeritus person")) {
                    if ($person->status=="Emeritus person") {
                        $pdf->text(8, $y, '*');
                    }
                    $pdf->text(10, $y, $person->title . " " . utf8_decode($person->firstname) . " " . utf8_decode($person->surname) . " (" . $person->fullplan . ")");
                    $pdf->text(80, $y, $person->society->society);
                    $pdf->text(110, $y, $person->phone);
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
            $pdf->text(35, 17, $person->circuit->circuit);
            $pdf->text(35, 24, "LOCAL PREACHERS MEETINGS: " . $year);
            $pdf->Output();
            exit;
        }
    }

    public function edit($id)
    {
        $data['circuit'] = $this->settings->getkey('circuit');
        $data['societies'] = $this->societies->all();
        $persondata=$this->person->find($id);
        $data['person']=$persondata->person;
        $data['selpos']=array();
        foreach ($data['person']->positions as $pos) {
            $data['selpos'][]=$pos->id;
        }
        $data['positions']=$this->positions->all();
        return view('connexion::persons.edit', $data);
    }

    public function create()
    {
        $data['individuals'] = $this->individuals->all();
        $data['societies'] = $this->societies->all();
        $data['circuit'] = $this->settings->getkey('circuit');
        $data['positions']=$this->positions->all();
        if (count($data['societies'])) {
            return view('connexion::persons.create', $data);
        } else {
            return redirect()->route('admin.societies.create')->with('notice', 'At least one society must be added before adding a person');
        }
    }

    public function show($id)
    {
        $data['person']=$this->person->find($id);
        return view('connexion::persons.show', $data);
    }

    public function store(CreatePersonRequest $request)
    {
        $this->person->create($request->except('image', 'token'));
        return redirect()->route('admin.persons.index')
            ->withSuccess('New person added');
    }
    
    public function update($id, UpdatePersonRequest $request)
    {
        $this->person->update($id, $request->all());
        if ($request->deletion_type<>"") {
            $this->person->destroy($id);
            return redirect()->route('admin.persons.index')->withSuccess('Person has been deleted');
        } else {
            return redirect()->route('admin.persons.index')->withSuccess('Person has been updated');
        }
    }
}
