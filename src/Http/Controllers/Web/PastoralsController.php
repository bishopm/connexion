<?php 

namespace Bishopm\Connexion\Http\Controllers\Web;

use Illuminate\Http\Request;
use Bishopm\Connexion\Models\Pastoral;
use Bishopm\Connexion\Models\Household;
use Bishopm\Connexion\Repositories\IndividualsRepository;
use Bishopm\Connexion\Repositories\PastoralsRepository;
use Bishopm\Connexion\Repositories\HouseholdsRepository;
use App\Http\Controllers\Controller;

class PastoralsController extends Controller
{
    /**
     * @var PastoralRepository
     */
    private $pastoral;
    private $household;
    private $individual;

    public function __construct(PastoralsRepository $pastoral, HouseholdsRepository $household, IndividualsRepository $individual)
    {
        $this->individual = $individual;
        $this->household = $household;
        $this->pastoral = $pastoral;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request, Household $household)
    {
        $pastoral = new Pastoral;
        $pastoral->pastoraldate=$request->pastoraldate;
        $pastoral->details=$request->details;
        $pastoral->actiontype=$request->actiontype;
        $pastoral->individual_id=$request->individual_id;
        $pastoral->household_id=$household->id;
        $pastoral->save();
    }

    public function index(Household $household)
    {
        if (count($household->pastorals)) {
            foreach ($household->pastorals as $row) {
                $row->pastorname=$this->individual->find($row->individual_id)->firstname;
                $data['rows'][]=$row;
            }
            $data['rowCount']=count($data['rows']);
            if ($data['rowCount'] > 5) {
                $data['rowCount']=5;
            }
            $data['current']=1;
            $data['total']=count($data['rows']);
        } else {
            $data=array();
            $data['rowCount']=0;
        }
        return $data;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Pastoral $pastoral
     * @return Response
     */
    public function edit(Pastoral $pastoral)
    {
        return view('members::admin.pastorals.edit', compact('pastoral'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Pastoral $pastoral
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
        $pastoral=$this->pastoral->find($request->id);
        $pastoral->individual_id=$request->individual_id;
        $pastoral->details=$request->details;
        $pastoral->pastoraldate=$request->pastoraldate;
        $pastoral->actiontype=$request->actiontype;
        $pastoral->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Pastoral $pastoral
     * @return Response
     */
    public function destroy(Request $request)
    {
        $pastoral=$this->pastoral->find($request->id)->delete();
    }
}
