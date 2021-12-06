<?php

namespace App\Http\Controllers\Backend\ProductsManagement;

use App\Models\Product\ProductAgreement;
use App\Models\Product\ProductCost;
use App\Models\Product\ProductCostEntry;
use App\Models\Product\ProductDescription;
use App\Models\Sales\Sale;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProductDescriptionController extends Controller
{
    public function index()
    {
        return view('backend.products.productdescription.index');
    }


    public function create()
    {
        $data['p_id'] = ProductDescription::select(DB::raw("CONCAT(name,'(',p_id,')','&nbsp;',description) AS name"), 'p_id')->pluck('name', 'p_id');

        return view('backend.products.productdescription.create');
    }

    public function store(Request $request)
    {
        $products = new ProductDescription();
        $products->create($request->all());
        return back()->withFlashSuccess(__('alerts.backend.records.created'));
    }


    public function show($id)
    {
        $data['products'] = ProductDescription::findOrFail($id);

        return view('backend.products.productdescription.ajaxshow', $data);
    }

    public function edit($id)
    {
        $data['products'] = ProductDescription::findOrFail($id);

        return view('backend.products.productdescription.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $products = ProductDescription::findOrFail($id);
        $products->update($request->all());
        return back()->withFlashSuccess(__('alerts.backend.records.updated'));
    }

    public function destroy($id)
    {
        $products = ProductDescription::findOrFail($id);
        $productsagreement = ProductAgreement::where('p_id',$products->p_id)->delete();
        $productscost = ProductCost::where('p_id',$products->p_id)->delete();
        $productscostentry = ProductCostEntry::where('p_id',$products->p_id)->delete();
        $products->delete();

        return back()->withFlashSuccess(__('alerts.backend.records.deleted'));
    }


    public function checkProductExistence(Request $request)
    {
        //search prosuct with p_id if it exist or not
        $exist = ProductDescription::where('p_id', $request->p_id)->first();
        if ($exist) {
            $msg = false;
        } else {
            $msg = true;
        }
        //returns response as json data ( can be checked in console for this response which is displayed in blade using console.log(data.message) in create.blade.php
        return response()->json([
            'status' => 'success',
            'message' => $msg
        ]);
    }

    public function listproduct()
    {
        $products = ProductDescription::get();
        return Datatables::of($products)
            ->addColumn('action', function ($products) {
                if (auth()->user()->hasanyRole(['administrator|productsmanager'])) {
                    return '<a data-id="' . $products->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="products/edit/' . $products->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ' .
                        '<a href="products/destroy/' . $products->id . '" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>';
                } else {
                    return '<a data-id="' . $products->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="products/edit/' . $products->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ';
                }
            })
            ->make(true);
    }

}
