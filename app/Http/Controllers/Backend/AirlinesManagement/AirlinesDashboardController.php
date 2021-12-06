<?php

namespace App\Http\Controllers\Backend\AirlinesManagement;

use App\Http\Controllers\Controller;
use App\Models\AirlinesManagement\Airline;
use App\Models\AirlinesManagement\AirlineMisc;
use App\Models\AirlinesManagement\AirlineStaff;
use App\Models\AirlinesManagement\AirlineVisit;
use DB;
use Illuminate\Http\Request;

class AirlinesDashboardController extends Controller
{
    public function index(Request $request)
    {
//        $data['airlines'] = null;
        $data['ai_id'] = Airline::select(DB::raw("CONCAT(name,'(',ai_id,') ',phone) AS name"), 'ai_id')->pluck('name', 'ai_id');
        if (!empty($request->all())) {
            $data['airlines'] = airlinesDetails($request->ai_id);
            $data['airlinesstaff'] = AirlineStaff::where('ai_id', $request->ai_id)->get();
            $data['airlinesvisit'] = AirlineVisit::where('ai_id', $request->ai_id)->get();
            $data['airlinesmisc'] = AirlineMisc::where('ai_id', $request->ai_id)->get();
            return view('backend.airlinesmanagement.airlinesdashboard', $data);
        }
        return view('backend.airlinesmanagement.airlinesdashboard', $data);
    }

}
