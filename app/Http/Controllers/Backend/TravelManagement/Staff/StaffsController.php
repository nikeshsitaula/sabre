<?php

namespace App\Http\Controllers\Backend\TravelManagement\Staff;

use App\Models\TravelManagement\PCC;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TravelManagement\Staff;
use DB;
use App\Models\Auth\User;
use App\Models\TravelManagement\TravelAgency;

class StaffsController extends Controller
{

    public function index()
    {
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ','&nbsp;',ta_phone,' ', '&nbsp;&nbsp; IATA: ',ta_iata_no,' ','&nbsp;&nbsp; Fax: ',ta_fax_no,' ') AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');
//        $data['pcc'] = PCC::select(DB::raw("CONCAT( 'PCC:', br_pcc, '&nbsp;&nbsp;', 'Address: ', br_address, '&nbsp;&nbsp;','Phone: ', br_phone, '&nbsp;&nbsp;', 'Fax: ', br_fax_no,'&nbsp; &nbsp;', 'Email: ', br_email) AS name"), 'br_pcc')->pluck('name', 'br_pcc');
        return view('backend.travel.staff.index', $data);
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->ta_id) && empty($request->pcc)) {
                $data = Staff::where('ta_id', $request->ta_id)->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (!empty($request->ta_id) && !empty($request->pcc)) {
                $data = Staff::where('ta_id', $request->ta_id)->where('pcc', $request->pcc)->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            echo json_encode(['msg' => 'some error encountered']);
        }

    }

    function filterPCCDropdown(Request $request){
        if (!empty($request->value) && !empty($request->ta_id)){
            $pcc = PCC::where('ta_id', $request->ta_id)->where('br_pcc', 'LIKE', '%' . $request->value . '%')
                ->orWhere('ta_id', $request->ta_id)->where('br_address', 'LIKE', '%' . $request->value . '%')
                ->orWhere('ta_id', $request->ta_id)->where('ta_id', 'LIKE', '%' . $request->value . '%')->paginate(20);

//            $pcc = PCC::where('ta_id',$request->ta_id)->where('br_pcc','LIKE','%'.$request->value.'%')->paginate(20);
            return response()->json($pcc);
        }
          $pcc = PCC::where('ta_id',$request->ta_id)->paginate(20);
        return response()->json($pcc);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $staff = Staff::create($request->all());
            if (!empty($staff) > 0) {
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
            $staff = Staff::where('id', $request->id)->update($data);
            if (!empty($staff)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            Staff::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function showed($id)
    {
        $data['staff'] = Staff::findOrFail($id);

        return view('backend.travel.staff.ajaxshowed', $data);
    }

    public function checkpcc(Request $request)
    {
        $checkpcc = PCC::where('ta_id', $request->ta_id)->first();
        if (empty($checkpcc)) {
            return response()->json([
                'status' => false,
                'message' => 'There are no PCC associated with the travel agency'
            ]);
        }
    }

    public function printStaff(Request $request,$id)
    {
        $data['travelagency'] = travelAgencyDetails($id);
        if (!empty($request->pcc))
            $data['staff'] = Staff::where('ta_id',$id)->where('pcc', $request->pcc)->get();
        else
            $data['staff'] = Staff::where('ta_id',$id)->get();
        return view('backend.travel.staff.printStaff', $data);
    }

}
