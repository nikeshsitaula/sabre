<?php

namespace App\Http\Controllers\Backend\TravelManagement;

use App\Http\Controllers\Controller;
use App\Models\TravelManagement\TravelAgency;
use App\Models\TravelManagement\PCC;
use App\Models\TravelManagement\TravelMiscz;
use App\Models\TravelManagement\TrainingStaff;
use App\Models\TravelManagement\Staff;
use App\Models\TravelManagement\Lniata;
use DB;
use Illuminate\Http\Request;

class TravelDashboardController extends Controller
{

    public function index(Request $request)
    {
        $data['travel'] = null;
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ',ta_phone) AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');
//        $data['pcc'] = PCC::select(DB::raw("CONCAT(br_pcc,'(',ta_id,') ',br_phone) AS br_pcc"), 'ta_id')->pluck('br_pcc', 'ta_id');
//        dd($data);
        if (!empty($request->ta_id && empty($request->pcc))) {
            $data['travelagency'] = travelAgencyDetails($request->ta_id);
            $data['pcc'] = PCC::where('ta_id', $request->ta_id)->get();
            $data['staff'] = Staff::where('ta_id', $request->ta_id)->get();
            $data['trainingstaff'] = TrainingStaff::where('ta_id', $request->ta_id)->get();
            $data['lniata'] = Lniata::where('ta_id', $request->ta_id)->get();
            $data['travelmiscz'] = TravelMiscz::where('ta_id', $request->ta_id)->get();
            return view('backend.travel.traveldashboard', $data);
        }
        if(!empty($request->ta_id) && !empty($request->pcc)){
            $data['travelagency'] = travelAgencyDetails($request->ta_id);
            $data['pcc'] = PCC::where('ta_id', $request->ta_id)->where('br_pcc',$request->pcc)->get();
            $data['staff'] = Staff::where('ta_id', $request->ta_id)->where('pcc',$request->pcc)->get();
            $data['trainingstaff'] = TrainingStaff::where('ta_id', $request->ta_id)->get();
            $data['lniata'] = Lniata::where('ta_id', $request->ta_id)->where('pcc',$request->pcc)->get();
            $data['travelmiscz'] = TravelMiscz::where('ta_id', $request->ta_id)->get();
        }

        return view('backend.travel.traveldashboard', $data);
    }
}
