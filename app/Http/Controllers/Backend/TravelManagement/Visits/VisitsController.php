<?php

namespace App\Http\Controllers\Backend\TravelManagement\Visits;

use App\Models\TravelManagement\Visit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TravelManagement\TravelAgency;
use DB;
use Yajra\DataTables\Facades\DataTables;

class VisitsController extends Controller
{
    public function index()
    {
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ','&nbsp;',ta_phone,' ', '&nbsp;&nbsp; IATA: ',ta_iata_no,' ','&nbsp;&nbsp; Fax: ',ta_fax_no,' ') AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');

        return view('backend.travel.visit.index', $data);
    }

    function fetch_data(Request $request)
    {

        if ($request->ajax()) {
            //only travelid
            if (!empty($request->ta_id) && empty($request->from) && empty($request->to)) {
                $data = Visit::where('ta_id', $request->ta_id)->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } //with travelid, from, to
            else if (!empty($request->ta_id) && !empty($request->from) && !empty($request->to)) {
                $data = Visit::where('ta_id', $request->ta_id)->whereBetween('date', [$request->from, $request->to])->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } //with travelid, from
            else if (!empty($request->ta_id) && !empty($request->from) && empty($request->to)) {
                $data = Visit::where('ta_id', $request->ta_id)->where('date', 'like', '%' . $request->from . '%')->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } //with from, to
            else if (empty($request->ta_id) && !empty($request->from) && !empty($request->to)) {
                $data = Visit::whereBetween('date', [$request->from, $request->to])->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } //with from
            else if (empty($request->ta_id) && !empty($request->from) && empty($request->to)) {
                $data = Visit::where('date', 'like', '%' . $request->from . '%')->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } //with nothing
            else {
                $data = Visit::orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            }
        }
    }

    function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            $visit = Visit::create($request->all());
            if (!empty($visit) > 0) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Inserted
            </div>';
            }
        }
    }


    function update(Request $request)
    {
        if ($request->ajax()) {
            $data = array(
                $request->column_name => $request->column_value,
                'updated_by' => auth()->user()->id
            );
            $visit = Visit::where('id', $request->id)->update($data);
            if (!empty($visit)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            Visit::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function showed($id)
    {
        $data['visit'] = Visit::findOrFail($id);
        return view('backend.travel.visit.ajaxshowed', $data);
    }

    public function printVisit(Request $request)
    {
        if (!empty($request->ta_id)){
            $data['travelagency'] = travelAgencyDetails($request->ta_id);
            $data['visit'] = Visit::where('ta_id',$request->ta_id)->get();
        }
        //only airportid
        if (!empty($request->ta_id) && empty($request->from) && empty($request->to)){
            $data['visit'] = Visit::where('ta_id', $request->ta_id)->orderBy('id', 'desc')->get();
        }
        //with airportid, from, to
        else if (!empty($request->ta_id) && !empty($request->from) && !empty($request->to)){
            $data['visit'] = Visit::where('ta_id', $request->ta_id)->whereBetween('date',[$request->from, $request->to])->orderBy('id', 'desc')->get();
        }
        //with airportid, from
        else if (!empty($request->ta_id) && !empty($request->from) && empty($request->to)){
            $data['visit'] = Visit::where('ta_id', $request->ta_id)->where('date','like','%'.$request->from.'%')->orderBy('id', 'desc')->get();
        }
        //with from, to
        else if (empty($request->ta_id) && !empty($request->from) && !empty($request->to)){
            $data['visit'] = Visit::whereBetween('date',[$request->from, $request->to])->orderBy('id', 'desc')->get();
        }
        //with from
        else if (empty($request->ta_id) && !empty($request->from) && empty($request->to)){
            $data['visit'] = Visit::where('date','like','%'.$request->from.'%')->orderBy('id', 'desc')->get();
        }
        //with nothing
        else{
            $data['visit'] = Visit::orderBy('id', 'desc')->get();
        }
        return view('backend.travel.visit.printVisit', $data);
    }
}
