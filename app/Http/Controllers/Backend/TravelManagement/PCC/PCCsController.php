<?php

namespace App\Http\Controllers\Backend\TravelManagement\PCC;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\TravelManagement\PCC;
use DB;
use App\Models\Auth\User;
use App\Models\TravelManagement\TravelAgency;

class PCCsController extends Controller
{
    public function index()
    {
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ','&nbsp;',ta_phone,' ', '&nbsp;&nbsp; IATA: ',ta_iata_no,' ','&nbsp;&nbsp; Fax: ',ta_fax_no,' ') AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');
        return view('backend.travel.pcc.index',$data);
    }

    function fetch_data(Request $request)
    {

        if ($request->ajax()) {
            $data = PCC::where('ta_id', $request->ta_id)->orderBy('id', 'desc')->paginate(6);
            echo json_encode($data);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            $pcc = PCC::create($request->all());
            if (!empty($pcc)) {
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
            $pcc = PCC::where('id', $request->id)->update($data);
            if (!empty($pcc)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            PCC::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function showed($id)
    {
        $data['pcc'] = PCC::findOrFail($id);
        return view('backend.travel.pcc.ajaxshowed', $data);
    }

    public function printPCC($id)
    {
        $data['travelagency'] = travelAgencyDetails($id);
        $data['pcc'] = PCC::where('ta_id',$id)->get();
        return view('backend.travel.pcc.printPCC', $data);
    }

}
