<?php

namespace App\Http\Controllers\Backend\ProductsManagement;

use App\Models\AccountManagement\AccountManagement;
use App\Models\Product\ProductAgreement;
use App\Models\Product\ProductCost;
use App\Models\Product\ProductCostEntry;
use App\Models\Product\ProductDescription;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProductCostEntryController extends Controller
{

    public function index()
    {
        $data['agreementnumber'] = ProductAgreement::select(DB::raw("CONCAT('Agreement Number: ',agreementnumber,' Product ID: ',p_id,' Travel Agency: ',travelname) AS p_id"), 'agreementnumber')->pluck('p_id', 'agreementnumber');
//        $data['agreementnumber'] = ProductAgreement::select(DB::raw("CONCAT(travelname,'(',agreementnumber,')') AS travelname"), 'agreementnumber')->pluck('travelname', 'agreementnumber');

        return view('backend.products.productcostentry.index', $data);
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->agreementnumber) && !empty($request->ta_id) && empty($request->from) && empty($request->to)) {
                $data = ProductCostEntry::where('agreementnumber', $request->agreementnumber)->where('ta_id', $request->ta_id)->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }

            if (!empty($request->agreementnumber) && empty($request->ta_id) && empty($request->from) && empty($request->to)) {
                $data = ProductCostEntry::where('agreementnumber', $request->agreementnumber)->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }

            if (empty($request->agreementnumber) && empty($request->ta_id) && !empty($request->from) && !empty($request->to)) {
                $data = ProductCostEntry::whereBetween('date', [$request->from, $request->to])->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (!empty($request->agreementnumber) && empty($request->ta_id) && !empty($request->from) && !empty($request->to)) {
                $data = ProductCostEntry::where('agreementnumber', $request->agreementnumber)->whereBetween('date', [$request->from, $request->to])->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (!empty($request->agreementnumber) && !empty($request->ta_id) && !empty($request->from) && !empty($request->to)) {
                $data = ProductCostEntry::where('agreementnumber', $request->agreementnumber)->where('ta_id', $request->ta_id)->whereBetween('date', [$request->from, $request->to])->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (empty($request->agreementnumber) && empty($request->ta_id) && empty($request->from) && empty($request->to)) {
                $data = ProductCostEntry::orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            echo json_encode(['msg' => 'some error encountered']);
        }
    }

    function filterTravelDropdown(Request $request)
    {
        if (!empty($request->value) && !empty($request->agreementnumber)) {
            $ta_id = ProductAgreement::where('agreementnumber', $request->agreementnumber)->where('ta_id', 'LIKE', '%' . $request->value . '%')
                ->orWhere('agreementnumber', $request->agreementnumber)->where('travelname', 'LIKE', '%' . $request->value . '%')->paginate(20);
            return response()->json($ta_id);
        }
        $ta_id = ProductAgreement::where('agreementnumber', $request->agreementnumber)->paginate(20);
        return response()->json($ta_id);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {

            // required values from Agreement Entry Model
            $agreementnumber = $request->agreementnumber;
            $pid = ProductAgreement::where('agreementnumber', $agreementnumber)->pluck('p_id')->sum();
            if($pid != '') {
                $pname = ProductDescription::where('p_id', $pid)->pluck('name')[0];
            }else{
                $pname=0;
            }
            $entrycost = $request->cost;
            $entrypayment = $request->payment;
            $entrybalance = $entrycost - $entrypayment;

            $request->merge([
                'balance' => $entrybalance,
                'name' => $pname,
                'p_id' => $pid,
                'created_by' => auth()->user()->id
            ]);
            $productcostentry = ProductCostEntry::create($request->all());
            if (!empty($productcostentry) > 0) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Inserted
            </div>';
            }

            // required values from Product Cost Model
            $currentcost = ProductCost::select('cost')->where('agreementnumber', $agreementnumber)->pluck('cost');
            $totalcurrentcost = $currentcost->sum();

            $currentpayment = ProductCost::select('received')->where('agreementnumber', $agreementnumber)->pluck('received');
            $totalcurrentpayment = $currentpayment->sum();

            $currentbalance = ProductCost::select('balance')->where('agreementnumber', $agreementnumber)->pluck('balance');
            $totalcurrentbalance = $currentbalance->sum();

            //final values

            $finalcost = $entrycost + $totalcurrentcost;
            $finalpayment = $entrypayment + $totalcurrentpayment;
            $finalbalance = $entrybalance + $totalcurrentbalance;

            if (!empty($finalbalance)) {
                $updateproductcost = array(
                    'cost' => $finalcost,
                    'received'=> $finalpayment,
                    'balance' => $finalbalance,
                    'updated_by' => auth()->user()->id
                );
            } else {
                $updateproductcost = array(
                    'updated_by' => auth()->user()->id
                );
            }

            $updatefinal = ProductCost::where('agreementnumber', $agreementnumber)->update($updateproductcost);

            if (!empty($updatefinal)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Product Cost Updated
            </div>';

            }
        }
    }

    public function update(Request $request)
    {
        //for cost
        if ($request->column_name === 'cost') {
            $id = $request->id;
            $prevsmaamount = ProductCostEntry::where('id', $request->id)->pluck('cost')->sum();
            $currentsmaamount = $request->column_value;
            $newamaamount = $currentsmaamount - $prevsmaamount;
            //get all required data
            $payment = ProductCostEntry::select('payment')->where('id', $request->id)->pluck('payment');
            $totalpayment = $payment->sum();
            $balance = $currentsmaamount - $totalpayment;

            //create an array of the required data
            $data = array(
                $request->column_name => $request->column_value,
                'payment' => $totalpayment,
                'balance' => $balance,
                'updated_by' => auth()->user()->id
            );
            //update data in Procust Cost Entry CRUD
            $productcostentry = ProductCostEntry::where('id', $request->id)->update($data);
            if (!empty($productcostentry)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }

            $agreementnumber = ProductCostEntry::select('agreementnumber')->where('id', $request->id)->pluck('agreementnumber');

            // required values from Product Cost Model
            $currentcost = ProductCost::select('cost')->where('agreementnumber', $agreementnumber)->pluck('cost');
            $totalcurrentcost = $currentcost->sum();

            $currentpayment = ProductCost::select('received')->where('agreementnumber', $agreementnumber)->pluck('received');
            $totalcurrentpayment = $currentpayment->sum();

            $currentbalance = ProductCost::select('balance')->where('agreementnumber', $agreementnumber)->pluck('balance');
            $totalcurrentbalance = $currentbalance->sum();

            //final values
            $finalcost = $newamaamount + $totalcurrentcost;
            $finalpayment = $totalcurrentpayment;
            $finalbalance = $finalcost - $finalpayment;

            //array of final values
            if (!empty($finalbalance)) {
                $updateproductcost = array(
                    'cost' => $finalcost,
                    'received'=> $finalpayment,
                    'balance' => $finalbalance,
                    'updated_by' => auth()->user()->id
                );
            } else {
                $updateproductcost = array(
                    'updated_by' => auth()->user()->id
                );
            }

            //update values in productcost
            $updatefinal = ProductCost::where('agreementnumber', $agreementnumber)->update($updateproductcost);

            if (!empty($updatefinal)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Product Cost Updated
            </div>';

            }

        }
            //forpayment
        if ($request->column_name === 'payment') {
            $id = $request->id;
            $prevsmaamount = ProductCostEntry::where('id', $request->id)->pluck('payment')->sum();
            $currentsmaamount = $request->column_value;
            $newamaamount = $currentsmaamount - $prevsmaamount;

            //get all rquired data
            $cost = ProductCostEntry::select('cost')->where('id', $request->id)->pluck('cost');
            $totalcost = $cost->sum();
            $balance = $totalcost - $currentsmaamount;

            //create an array of the required data
            $data = array(
                'cost' => $totalcost,
                $request->column_name => $request->column_value,
                'balance' => $balance,
                'updated_by' => auth()->user()->id
            );
            //update data in Procust Cost Entry CRUD
            $productcostentry = ProductCostEntry::where('id', $request->id)->update($data);
            if (!empty($productcostentry)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }

            $agreementnumber = ProductCostEntry::select('agreementnumber')->where('id', $request->id)->pluck('agreementnumber');

            // required values from Product Cost Model
            $currentcost = ProductCost::select('cost')->where('agreementnumber', $agreementnumber)->pluck('cost');
            $totalcurrentcost = $currentcost->sum();

            $currentpayment = ProductCost::select('received')->where('agreementnumber', $agreementnumber)->pluck('received');
            $totalcurrentpayment = $currentpayment->sum();

            $currentbalance = ProductCost::select('balance')->where('agreementnumber', $agreementnumber)->pluck('balance');
            $totalcurrentbalance = $currentbalance->sum();

            //final values
            $finalpayment = $newamaamount + $totalcurrentpayment;
            $finalcost = $totalcurrentcost;
            $finalbalance = $finalcost - $finalpayment;

            //array of final values
            if (!empty($finalbalance)) {
                $updateproductcost = array(
                    'cost' => $finalcost,
                    'received'=> $finalpayment,
                    'balance' => $finalbalance,
                    'updated_by' => auth()->user()->id
                );
            } else {
                $updateproductcost = array(
                    'updated_by' => auth()->user()->id
                );
            }

            //update values in productcost
            $updatefinal = ProductCost::where('agreementnumber', $agreementnumber)->update($updateproductcost);

            if (!empty($updatefinal)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Product Cost Updated
            </div>';

            }

        }
        if ($request->ajax()) {
            $data = array(
                $request->column_name => $request->column_value,
                'updated_by' => auth()->user()->id
            );
            $productcostentry = ProductCostEntry::where('id', $request->id)->update($data);
            if (!empty($productcostentry)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;

            // required values from Product Cost Entry Model
            $agreementnumber = ProductCostEntry::select('agreementnumber')->where('id', $id)->pluck('agreementnumber');
            $payment = ProductCostEntry::select('payment')->where('id', $id)->pluck('payment')->sum();
            $cost = ProductCostEntry::select('cost')->where('id', $id)->pluck('cost')->sum();

            // required values from Product Cost Model
            $currentcost = ProductCost::select('cost')->where('agreementnumber', $agreementnumber)->pluck('cost');
            $totalcurrentcost = $currentcost->sum();

            $currentpayment = ProductCost::select('received')->where('agreementnumber', $agreementnumber)->pluck('received');
            $totalcurrentpayment = $currentpayment->sum();

            //final values
            $finalcost = $totalcurrentcost - $cost;
            $finalpayment = $totalcurrentpayment - $payment;
            $finalbalance = $finalcost - $finalpayment;

            //array of final values
            if (!empty($finalbalance)) {
                $updateproductcost = array(
                    'cost' => $finalcost,
                    'received' => $finalpayment,
                    'balance' => $finalbalance,
                    'updated_by' => auth()->user()->id
                );
            } else {
                $updateproductcost = array(
                    'cost' => 0,
                    'received' =>0,
                    'balance' => 0,
                    'updated_by' => auth()->user()->id
                );
            }

            //update values in productcost
            $updatefinal = ProductCost::where('agreementnumber', $agreementnumber)->update($updateproductcost);

            ProductCostEntry::where('id', $request->id)->delete();

            if (!empty($updatefinal)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
            }
        }
    }

    public function showed($id)
    {
        $data['productcostentry'] = ProductCostEntry::findOrFail($id);
        return view('backend.products.productcostentry.ajaxshowed', $data);
    }

    public function checkTravel(Request $request)
    {
        $checktravel = ProductAgreement::where('agreementnumber', $request->agreementnumber)->first();
        if (empty($checktravel)) {
            return response()->json([
                'status' => false,
                'message' => 'There are no Travel ID associated with this Agreement Number'
            ]);
        }
    }

    public function printproductscostentry(Request $request, $id)
    {

        if ($id != 0) {
            if (empty($request->ta_id) && empty($request->from) && empty($request->to)) {
                $data['productval'] = agreementsDetails($request->id);
                $data['productcostentry'] = ProductCostEntry::where('agreementnumber', $id)->orderBy('id', 'desc')->get();
            }
            if (!empty($request->ta_id) && empty($request->from) && empty($request->to)) {
                $data['productval'] = agreementsDetails($request->id);
                $data['productcostentry'] = ProductCostEntry::where('agreementnumber', $id)->where('ta_id', $request->ta_id)->orderBy('id', 'desc')->get();
            }
            if (empty($request->ta_id) && !empty($request->from) && !empty($request->to)) {
                $data['productval'] = agreementsDetails($request->id);
                $data['productcostentry'] = ProductCostEntry::where('agreementnumber', $id)->whereBetween('date', [$request->from, $request->to])->orderBy('id', 'desc')->get();
            }
            if (!empty($request->ta_id) && !empty($request->from) && !empty($request->to)) {
                $data['productval'] = agreementsDetails($request->id);
                $data['productcostentry'] = ProductCostEntry::where('agreementnumber', $id)->where('ta_id', $request->ta_id)->whereBetween('date', [$request->from, $request->to])->orderBy('id', 'desc')->get();
            }
            return view('backend.products.productcostentry.printproductscostentry', $data);
        } else {
            if (empty($id) && empty($request->ta_id) && !empty($request->from) && !empty($request->to)) {
//                $productcostentry = ProductCostEntry::whereBetween('date', [$request->from, $request->to])->orderBy('id', 'desc')->get();


                $productcostentry = ProductCostEntry::whereBetween('date', [$request->from, $request->to])->orderBy('id', 'desc')->get();
                $data['productcostentries'] = $productcostentry->groupBy(function ($item) {
                    return $item->agreementnumber;
                });

            } else {
                $productcostentry = ProductCostEntry::orderBy('ta_id', 'asc')->get();
                $data['productcostentries'] = $productcostentry->groupBy(function ($item) {
                    return $item->agreementnumber;
                });

            }
        }
        return view('backend.products.productcostentry.printsecondfile', $data);
    }

}
