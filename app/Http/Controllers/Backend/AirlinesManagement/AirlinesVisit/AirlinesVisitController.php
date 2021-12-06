<?php

namespace App\Http\Controllers\Backend\AirlinesManagement\AirlinesVisit;

use App\Http\Controllers\Controller;
use App\Models\AirlinesManagement\Airline;
use App\Models\AirlinesManagement\AirlineVisit;
use App\Models\Auth\Role;
use App\Models\Auth\User;
use Illuminate\Http\Request;
use DB;

class AirlinesVisitController extends Controller
{
    public function index()
    {
        $data['ai_id'] = Airline::select(DB::raw("CONCAT(name,'(',ai_id,') ','&nbsp;',phone,' ', '&nbsp;&nbsp; IATA: ',numericiata,' ','&nbsp;&nbsp; IATA(alphanumeric): ',alphanumericiata,' ') AS name"), 'ai_id')->pluck('name', 'ai_id');

        return view('backend.airlinesmanagement.airlinesvisit.index', $data);
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            //only airportid
            if (!empty($request->ai_id) && empty($request->from) && empty($request->to)) {
                $data = AirlineVisit::where('ai_id', $request->ai_id)->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } //with airportid, from, to
            else if (!empty($request->ai_id) && !empty($request->from) && !empty($request->to)) {
                $data = AirlineVisit::where('ai_id', $request->ai_id)->whereBetween('date', [$request->from, $request->to])->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } //with airportid, from
            else if (!empty($request->ai_id) && !empty($request->from) && empty($request->to)) {
                $data = AirlineVisit::where('ai_id', $request->ai_id)->where('date', 'like', '%' . $request->from . '%')->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } //with from, to
            else if (empty($request->ai_id) && !empty($request->from) && !empty($request->to)) {
                $data = AirlineVisit::whereBetween('date', [$request->from, $request->to])->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } //with from
            else if (empty($request->ai_id) && !empty($request->from) && empty($request->to)) {
                $data = AirlineVisit::where('date', 'like', '%' . $request->from . '%')->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } //with nothing
            else {
                $data = AirlineVisit::orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            }
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            $airlinesvisit = AirlineVisit::create($request->all());
            if (!empty($airlinesvisit) > 0) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Inserted
            </div>';
            }
        }
    }


    public function update(Request $request)
    {
        if ($request->ajax()) {
            $data = array(
                $request->column_name => $request->column_value,
                'updated_by' => auth()->user()->id
            );
            $airlinesvisit = AirlineVisit::where('id', $request->id)->update($data);
            if (!empty($airlinesvisit)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            AirlineVisit::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function showed($id)
    {
        $data['airlinesvisit'] = AirlineVisit::findOrFail($id);
        return view('backend.airlinesmanagement.airlinesvisit.ajaxshowed', $data);
    }

    public function printairlinesvisit(Request $request)
    {
        if (!empty($request->ai_id)) {
            $data['airlines'] = airlinesDetails($request->ai_id);
            $data['airlinesvisit'] = AirlineVisit::where('ai_id', $request->ai_id)->get();
        }
        //only airportid
        if (!empty($request->ai_id) && empty($request->from) && empty($request->to)) {
            $data['airlinesvisit'] = AirlineVisit::where('ai_id', $request->ai_id)->orderBy('id', 'desc')->get();
        } //with airportid, from, to
        else if (!empty($request->ai_id) && !empty($request->from) && !empty($request->to)) {
            $data['airlinesvisit'] = AirlineVisit::where('ai_id', $request->ai_id)->whereBetween('date', [$request->from, $request->to])->orderBy('id', 'desc')->get();
        } //with airportid, from
        else if (!empty($request->ai_id) && !empty($request->from) && empty($request->to)) {
            $data['airlinesvisit'] = AirlineVisit::where('ai_id', $request->ai_id)->where('date', 'like', '%' . $request->from . '%')->orderBy('id', 'desc')->get();
        } //with from, to
        else if (empty($request->ai_id) && !empty($request->from) && !empty($request->to)) {
            $data['airlinesvisit'] = AirlineVisit::whereBetween('date', [$request->from, $request->to])->orderBy('id', 'desc')->get();
        } //with from
        else if (empty($request->ai_id) && !empty($request->from) && empty($request->to)) {
            $data['airlinesvisit'] = AirlineVisit::where('date', 'like', '%' . $request->from . '%')->orderBy('id', 'desc')->get();
        } //with nothing
        else {
            $data['airlinesvisit'] = AirlineVisit::orderBy('id', 'desc')->get();
        }
        return view('backend.airlinesmanagement.airlinesvisit.printAirlinesVisit', $data);
    }
}
