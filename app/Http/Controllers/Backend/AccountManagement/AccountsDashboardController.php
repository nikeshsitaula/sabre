<?php

namespace App\Http\Controllers\Backend\AccountManagement;

use App\Http\Controllers\Controller;
use App\Models\AccountManagement\AccountManagement;
use App\Models\AccountManagement\AgencyAgreement;
use App\Models\AccountManagement\IncentiveData;
use App\Models\TravelManagement\TravelAgency;
use Illuminate\Http\Request;
use DB;

class   AccountsDashboardController extends Controller
{
    public function index()
    {
        $data['incentivecontroller'] = null;
        return view('backend.accountmanagement.accountdashboard', $data);
    }

    public function viewdetails(Request $request)
    {
        $data['incentivecontroller'] = DB::table("incentive_data as s")
            ->select('s.*')
            ->leftJoin("incentive_data as s1", function ($join) {
                $join->on('s.ta_id', '=', 's1.ta_id');
                $join->on('s.created_at', '<', 's1.created_at');
            })
            ->whereNull('s1.ta_id')
            ->paginate(10);
        return view('backend.accountmanagement.accountdashboard', $data);

    }
}
