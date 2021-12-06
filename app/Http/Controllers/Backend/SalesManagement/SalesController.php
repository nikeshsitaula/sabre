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

class SalesController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.sales.sma.index');
    }

    public function create()
    {
//        $data['sma_id'] = Sale::select(DB::raw("CONCAT(name,'(',sma_id,') ','&nbsp;',description,' ', '&nbsp;&nbsp; EstimatedCost: ',estimatedcost,' ','&nbsp;&nbsp; ActualCost: ',actualcost,' ','&nbsp;&nbsp; From: ',from,' ','&nbsp;&nbsp; To: ',to,' ') AS name"), 'sma_id')->pluck('name', 'sma_id');

        return view('backend.sales.sma.create');
    }

    public function store(Request $request)
    {
        $sales = new Sale();
        $request->merge([
            'created_by' => auth()->user()->id
        ]);
        $sales->create($request->all());
        return back()->withFlashSuccess(__('alerts.backend.records.created'));
    }

    public function show($id)
    {
        $data['sales'] = Sale::findOrFail($id);

        return view('backend.sales.sma.ajaxshow', $data);
    }

    public function edit($id)
    {
        $data['sales'] = Sale::findOrFail($id);

        return view('backend.sales.sma.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $sales = Sale::findOrFail($id);
        $request->merge([
            'updated_by' => auth()->user()->id
        ]);
        $sales->update($request->all());
        return back()->withFlashSuccess(__('alerts.backend.records.updated'));
    }

    public function destroy($id)
    {

        $sales = Sale::findOrFail($id);
        $smaprize = Smaprize::where('sma_id', $sales->sma_id)->delete();
        $smaothercost = SmaOtherCost::where('sma_id', $sales->sma_id)->delete();
        $sales->delete();

        return back()->withFlashSuccess(__('alerts.backend.records.deleted'));
    }

    public function checkSalesExistence(Request $request)
    {
        $exist = Sale::where('sma_id', $request->sma_id)->first();
        if ($exist) {
            $msg = false;
        } else {
            $msg = true;
        }
        return response()->json([
            'status' => 'success',
            'message' => $msg
        ]);
    }

    public function listSales()
    {
        $sales = Sale::get();

        return Datatables::of($sales)
            ->addColumn('action', function ($sales) {
                if (auth()->user()->hasanyRole(['administrator|salesmanager'])) {
                    return '<a data-id="' . $sales->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="sales/edit/' . $sales->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ' .
                        '<a href="sales/destroy/' . $sales->id . '" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>';
                } else {
                    return '<a data-id="' . $sales->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="sales/edit/' . $sales->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ';
                }
            })
            ->make(true);
    }

    public function daterange(Request $request)
    {
        $sales = Sale::get();

        if (request()->ajax()) {
            if (!empty($request->from_date)) {
                $sales = DB::table('sales')->where(function ($query) use ($request) {
                    $query->where('from','<=', $request->from_date)
                        ->where('to', '>=', $request->from_date);
                })->orWhere(function($query) use ($request) {
                    $query->where('to','>=', $request->to_date)
                        ->where('from', '<=', $request->to_date);
                })->orWhere(function($query) use ($request) {
                    $query->where('from','>=', $request->from_date)
                        ->where('to', '<=', $request->to_date);
                })->get();

//                $sales = DB::table('sales')
//                    ->wherebetween('from' , array($request->from_date, $request->to_date))
//                    ->orWhereBetween('to' , array($request->from_date, $request->to_date))
//                    ->get();
            } else {
                $sales = DB::table('sales')
                    ->get();
            }
            return Datatables::of($sales)
                ->addColumn('action', function ($sales) {
                    if (auth()->user()->hasanyRole(['administrator|salesmanager'])) {
                        return '<a data-id="' . $sales->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                            '<a href="sales/edit/' . $sales->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ' .
                            '<a href="sales/destroy/' . $sales->id . '" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>';
                    } else {
                        return '<a data-id="' . $sales->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                            '<a href="sales/edit/' . $sales->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ';
                    }
                })->make(true);
        }
        return view('backend.sales.sma.index');
    }
}
