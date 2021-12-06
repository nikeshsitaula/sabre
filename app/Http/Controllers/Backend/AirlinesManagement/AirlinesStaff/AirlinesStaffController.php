<?php

namespace App\Http\Controllers\Backend\AirlinesManagement\AirlinesStaff;

use App\Http\Controllers\Controller;
use App\Models\AirlinesManagement\Airline;
use App\Models\AirlinesManagement\AirlineStaff;
use Illuminate\Http\Request;
use DB;

class AirlinesStaffController extends Controller
{
    public function index()
    {
        $data['ai_id'] = Airline::select(DB::raw("CONCAT(name,'(',ai_id,') ','&nbsp;',phone,' ', '&nbsp;&nbsp; IATA(numeric): ',numericiata,' ','&nbsp;&nbsp; IATA(alphanumeric): ',alphanumericiata,' ','&nbsp;&nbsp; Fax: ',fax,' ') AS name"), 'ai_id')->pluck('name', 'ai_id');
        return view('backend.airlinesmanagement.airlinesstaff.index',$data);
    }

    function fetch_data(Request $request)
    {

        if ($request->ajax()) {
            $data = AirlineStaff::where('ai_id', $request->ai_id)->orderBy('id', 'desc')->paginate(6);
            echo json_encode($data);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            $airlinesstaff = AirlineStaff::create($request->all());
            if (!empty($airlinesstaff) > 0) {
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
            $airlinesstaff = AirlineStaff::where('id', $request->id)->update($data);
            if (!empty($airlinesstaff)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            AirlineStaff::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function showed($id)
    {
        $data['airlinesstaff'] = AirlineStaff::findOrFail($id);
        return view('backend.airlinesmanagement.airlinesstaff.ajaxshowed', $data);
    }

    public function printairlinesstaff($id)
    {
        $data['airlines'] = airlinesDetails($id);
        $data['airlinesstaff'] = AirlineStaff::where('ai_id',$id)->get();
        return view('backend.airlinesmanagement.airlinesstaff.printAirlinesStaff', $data);
    }
}
