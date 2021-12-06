<?php

namespace App\Http\Controllers\Backend\ProductsManagement;

use App\Models\AccountManagement\AccountManagement;
use App\Models\Product\ProductAgreement;
use App\Models\Product\ProductCost;
use App\Models\Product\ProductCostEntry;
use App\Models\Product\ProductDescription;
use App\Models\TravelManagement\TravelAgency;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProductDashboardController extends Controller
{

    public function index(Request $request)
    {
        $data['travelagency'] = null;
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ',ta_phone) AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');

        if (!empty($request->ta_id) && empty($request->from) && empty($request->to)) {
            $data['travelagency'] = travelAgencyDetails($request->ta_id);
            $productcostentry = ProductCostEntry::orderBy('agreementnumber')->where('ta_id', $request->ta_id)->get();

            $data['productcostentries'] = $productcostentry->groupBy(function ($item) {
                return $item->agreementnumber;
            });
            return view('backend.products.productdashboard', $data);

        } else if (!empty($request->ta_id) && !empty($request->from) && !empty($request->to)) {
            $data['travelagency'] = travelAgencyDetails($request->ta_id);
            $productcostentry = ProductCostEntry::where('ta_id', $request->ta_id)->whereBetween('date', [$request->from, $request->to])->get();

            $data['productcostentries'] = $productcostentry->groupBy(function ($item) {
                return $item->agreementnumber;
            });
            return view('backend.products.productdashboard', $data);
        } else if (empty($request->ta_id) && !empty($request->from) && !empty($request->to)) {
            $productcostentry = ProductCostEntry::whereBetween('date', [$request->from, $request->to])->get();

            $data['productcostentries'] = $productcostentry->groupBy(function ($item) {
                return $item->agreementnumber;
            });
            return view('backend.products.productdashboard', $data);
        } else if (empty($request->ta_id) && !empty($request->from) && empty($request->to)) {
            $productcostentry = ProductCostEntry::where('date', '>=', $request->from)->get();

            $data['productcostentries'] = $productcostentry->groupBy(function ($item) {
                return $item->agreementnumber;
            });
            return view('backend.products.productdashboard', $data);
        } else if (!empty($request->ta_id) && !empty($request->from) && empty($request->to)) {
            $data['travelagency'] = travelAgencyDetails($request->ta_id);
            $productcostentry = ProductCostEntry::where('ta_id', $request->ta_id)->where('date', '>=', $request->from)->get();

            $data['productcostentries'] = $productcostentry->groupBy(function ($item) {
                return $item->agreementnumber;
            });
            return view('backend.products.productdashboard', $data);
        } else if (empty($request->ta_id) && empty($request->from) && !empty($request->to)) {
            $productcostentry = ProductCostEntry::where('date', '<=', $request->to)->get();

            $data['productcostentries'] = $productcostentry->groupBy(function ($item) {
                return $item->agreementnumber;
            });
            return view('backend.products.productdashboard', $data);
        } else if (!empty($request->ta_id) && empty($request->from) && !empty($request->to)) {
            $data['travelagency'] = travelAgencyDetails($request->ta_id);
            $productcostentry = ProductCostEntry::where('ta_id', $request->ta_id)->where('date', '<=', $request->to)->get();

            $data['productcostentries'] = $productcostentry->groupBy(function ($item) {
                return $item->agreementnumber;
            });
            return view('backend.products.productdashboard', $data);
        }
        return view('backend.products.productdashboard', $data);
    }

}
