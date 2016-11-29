<?php

namespace bishopm\base\Http\Controllers;

use bishopm\base\Repositories\SpecialdaysRepository;
use bishopm\base\Repositories\HouseholdsRepository;
use bishopm\base\Models\Specialday;
use bishopm\base\Models\Household;
use App\Http\Controllers\Controller;
use bishopm\base\Http\Requests\CreateSpecialdayRequest;
use bishopm\base\Http\Requests\UpdateSpecialdayRequest;
use Illuminate\Http\Request;

class SpecialdayController extends Controller
{
    /**
     * @var SpecialdayRepository
     */
    private $specialday, $household;

    public function __construct(SpecialdayRepository $specialday, HouseholdRepository $household)
    {
        parent::__construct();

        $this->specialday = $specialday;
        $this->household = $household;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
     public function index(Specialday $special,Household $household)
     {
       foreach ($household->specialday as $row){
         $row->anniversarydetails=$row->details;
         $row->anniversaryid=$row->id;
         $data['rows'][]=$row;
       }
       $data['rowCount']=count($data['rows']);
       if ($data['rowCount'] > 5) {
         $data['rowCount']=5;
       }
       $data['current']=1;
       $data['total']=count($data['rows']);
       return $data;
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create($household)
    {
        return view('members::admin.specialdays.create',compact('household'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, Household $household)
    {
        $special = New Specialday;
        $special->anniversarydate=$request->anniversarydate;
        $special->details=$request->anniversarydetails;
        $special->anniversarytype=$request->anniversarytype;
        $special->household_id=$household->id;
        $special->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Specialday $specialday
     * @return Response
     */
    public function edit(Specialday $specialday)
    {
        return view('members::admin.specialdays.edit', compact('specialday'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Specialday $specialday
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
      $special=$this->specialday->find($request->anniversaryid);
      $special->details=$request->anniversarydetails;
      $special->anniversarydate=$request->anniversarydate;
      $special->anniversarytype=$request->anniversarytype;
      $special->save();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  Specialday $specialday
     * @return Response
     */
    public function destroy(Request $request)
    {
        $special=$this->specialday->find($request->anniversaryid)->delete();
    }
}
