<?php

namespace App\Http\Controllers\Backend\AirlinesManagement\AirlinesMisc;

use App\Http\Controllers\Controller;
use App\Models\AirlinesManagement\Airline;
use App\Models\AirlinesManagement\AirlineMisc;
use Illuminate\Http\Request;
use DB;

class AirlinesMiscController extends Controller
{
    public function index()
    {
        $data['ai_id'] = Airline::select(DB::raw("CONCAT(name,'(',ai_id,') ','&nbsp;',phone,' ', '&nbsp;&nbsp; IATA(numeric): ',numericiata,' ','&nbsp;&nbsp; IATA(alphanumeric): ',alphanumericiata,' ','&nbsp;&nbsp; Fax: ',fax,' ') AS name"), 'ai_id')->pluck('name', 'ai_id');
        return view('backend.airlinesmanagement.airlinesmisc.index',$data);
    }

    function fetch_data(Request $request)
    {

        if ($request->ajax()) {
            $data = AirlineMisc::where('ai_id', $request->ai_id)->orderBy('id', 'desc')->paginate(6);
            echo json_encode($data);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            $airlinesmisc = AirlineMisc::create($request->all());
            if (!empty($airlinesmisc) > 0) {
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
            $airlinesmisc = AirlineMisc::where('id', $request->id)->update($data);
            if (!empty($airlinesmisc)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            AirlineMisc::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function showed($id)
    {
        $data['airlinesmisc'] = AirlineMisc::findOrFail($id);
        return view('backend.airlinesmanagement.airlinesmisc.ajaxshowed', $data);
    }

    public function printairlinesmisc($id)
    {
        $data['airlines'] = airlinesDetails($id);
        $data['airlinesmisc'] = AirlineMisc::where('ai_id',$id)->get();
        return view('backend.airlinesmanagement.airlinesmisc.printAirlinesMisc', $data);
    }
}
