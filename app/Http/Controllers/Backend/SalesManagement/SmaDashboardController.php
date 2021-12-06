<?php

namespace App\Http\Controllers\Backend\SalesManagement;

use App\Models\Auth\User;
use App\Models\Sales\Sale;
use App\Models\Sales\SmaOtherCost;
use App\Models\Sales\Smaprize;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SmaDashboardController extends Controller
{

    public function index(Request $request)
    {
        $data['smaval'] = null;
        $data['sma_id'] = Sale::select(DB::raw("CONCAT(name,'(',sma_id,')') AS name"), 'sma_id')->pluck('name', 'sma_id');
        if (!empty($request->all())) {
            $data['smaval'] = smaDetails($request->sma_id);
            $data['smaprize'] = Smaprize::where('sma_id', $request->sma_id)->get();
            $data['smaother'] = SmaOtherCost::where('sma_id', $request->sma_id)->get();

            return view('backend.sales.smadashboard', $data);
        }

        return view('backend.sales.smadashboard', $data);
    }
}
