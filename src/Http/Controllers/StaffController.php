<?php

namespace Bishopm\Connexion\Http\Controllers;

use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Repositories\EmployeesRepository;
use Bishopm\Connexion\Models\Individual;
use Bishopm\Connexion\Models\Leaveday;
use Bishopm\Connexion\Models\Household;
use Bishopm\Connexion\Models\Employee;
use Bishopm\Connexion\Http\Requests\CreateEmployeeRequest;
use Bishopm\Connexion\Http\Requests\UpdateEmployeeRequest;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StaffController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */

    private $individual;

    public function __construct(IndividualsRepository $individual, EmployeesRepository $employee)
    {
        $this->individual = $individual;
        $this->employee = $employee;
    }

    public function index()
    {
        $individuals = $this->individual->staff();
        $memberindivs = Individual::withTag('staff')->get();
        foreach ($individuals as $indiv) {
            $staffs[$indiv->surname . $indiv->firstname]=$indiv;
        }
        foreach ($memberindivs as $mindiv) {
            $staffs[$mindiv->surname . $mindiv->firstname]=$mindiv;
        }
        asort($staffs);
        return view('connexion::staff.index', compact('staffs'));
    }

    public function show($slug, $thisyr="")
    {
        if (!$thisyr) {
            $thisyr=date('Y');
        }
        $staff=$this->individual->employee($slug);
        $leaveyear=array();
        $yrleave=array();
        $leavedates=array();
        if ($staff->employee) {
            foreach ($staff->employee->leavedays as $leave) {
                if (substr($leave->leavedate, 0, 4)==$thisyr) {
                    $leaveyear[$leave->leavetype][]=$leave->leavedate;
                    if (isset($leaveyear[$leave->leavetype]['total'])) {
                        $leaveyear[$leave->leavetype]['total']=$leaveyear[$leave->leavetype]['total']+1;
                    } else {
                        $leaveyear[$leave->leavetype]['total']=1;
                    }
                    $leavedates[]=$leave->leavedate;
                    $yrleave[]=$leave;
                }
            }
        }
        $leavedates=json_encode($leavedates);
        return view('connexion::staff.show', compact('staff', 'leaveyear', 'thisyr', 'leavedates', 'yrleave'));
    }

    public function create(Individual $individual)
    {
        return view('connexion::staff.create', compact('individual'));
    }

    public function edit($id)
    {
        $employee= $this->employee->find($id);
        return view('connexion::staff.edit', compact('employee'));
    }

    public function store(CreateEmployeeRequest $request)
    {
        $this->employee->create($request->all());
        return redirect()->route('admin.staff.index')
            ->withSuccess('Employee data added');
    }

    public function addleave(Request $request)
    {
        $leavedates=explode(',', $request->leavedate);
        $leavetype=$request->leavetype;
        $indivslug=substr(strrchr($request->server('HTTP_REFERER'), '/'), 1);
        $individ=Individual::where('slug', $indivslug)->first()->employee->id;
        foreach ($leavedates as $ld) {
            $ldt=Leaveday::create(['employee_id' => $individ, 'leavetype' => $leavetype, 'leavedate' => $ld]);
        }
        return redirect()->route('admin.staff.show', $indivslug);
    }

    public function update($employee, UpdateEmployeeRequest $request)
    {
        $this->employee->update($employee, $request->all());
        return redirect()->route('admin.staff.index')
            ->withSuccess('Employee data updated');
    }
}
