<?php

namespace App\Http\Controllers\Backend\ProductsManagement;

use App\Models\AccountManagement\AccountManagement;
use App\Models\Product\ProductAgreement;
use App\Models\Product\ProductCost;
use App\Models\Product\ProductDescription;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProductCostController extends Controller
{

    public function index()
    {
        $data['p_id'] = ProductDescription::select(DB::raw("CONCAT(name,'(',p_id,')') AS name"), 'p_id')->pluck('name', 'p_id');

        return view('backend.products.productcost.index', $data);
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->p_id) && !empty($request->agreementnumber) && empty($request->from) && empty($request->to)) {
                $data = ProductCost::where('p_id', $request->p_id)->where('agreementnumber', $request->agreementnumber)->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }

            if (!empty($request->p_id) && empty($request->agreementnumber) && empty($request->from) && empty($request->to)) {
                $data = ProductCost::where('p_id', $request->p_id)->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }

            if (empty($request->p_id) && empty($request->agreementnumber) && !empty($request->from) && !empty($request->to)) {
                $data = ProductCost::whereBetween('entrydate', [$request->from, $request->to])->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (!empty($request->p_id) && empty($request->agreementnumber) && !empty($request->from) && !empty($request->to)) {
                $data = ProductCost::where('p_id', $request->p_id)->whereBetween('entrydate', [$request->from, $request->to])->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (!empty($request->p_id) && !empty($request->agreementnumber) && !empty($request->from) && !empty($request->to)) {
                $data = ProductCost::where('p_id', $request->p_id)->where('agreementnumber', $request->agreementnumber)->whereBetween('entrydate', [$request->from, $request->to])->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (empty($request->p_id) && empty($request->agreementnumber) && empty($request->from) && empty($request->to)) {
                $data = ProductCost::orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (empty(!empty($request->p_id) && $request->agreementnumber) && !empty($request->from) && empty($request->to)) {
                $data['productscost'] = ProductCost::where('p_id',  $request->p_id)->where('entrydate', '>=', $request->from)->orderBy('id', 'asc')->paginate(6);
                return json_encode($data);
            }
            if (empty(!empty($request->p_id) && $request->agreementnumber) && empty($request->from) && !empty($request->to)) {
                $data['productscost'] = ProductCost::where('p_id',  $request->p_id)->where('entrydate', '<=', $request->to)->orderBy('id', 'asc')->paginate(6);
                return json_encode($data);
            }


            echo json_encode(['msg' => 'some error encountered']);
        }
    }

    function filterAgreementDropdown(Request $request)
    {
        if (!empty($request->value) && !empty($request->p_id)) {
//            $agreementnumber = ProductAgreement::select(DB::raw("CONCAT(travelname,'(',agreementnumber,')') AS travelname"), 'agreementnumber')->pluck('travelname', 'agreementnumber');

            $agreementnumber = ProductAgreement::where('p_id', $request->p_id)->where('agreementnumber', 'LIKE', '%' . $request->value . '%')
                ->orWhere('p_id', $request->p_id)->where('travelname', 'LIKE', '%' . $request->value . '%')
                ->orWhere('p_id', $request->p_id)->where('ta_id', 'LIKE', '%' . $request->value . '%')->paginate(20);

        return response()->json($agreementnumber);
    }
        $agreementnumber = ProductAgreement::where('p_id', $request->p_id)->paginate(20);
        return response()->json($agreementnumber);
    }


    public function store(Request $request)
    {
        if ($request->ajax()) {

            $agreementnumber = $request->agreementnumber;

            $checkagreementnumber = ProductCost::select('agreementnumber')->where('agreementnumber', $agreementnumber)->first();

            if (!empty($checkagreementnumber)) {
                return '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                This agreement number is already used.
            </div>';
            } else {

                $cost = $request->cost;
                $received = $request->received;
                $balance = $cost - $received;

                $taval = ProductAgreement::select('ta_id')->where('agreementnumber', $agreementnumber)->first();
                if ($taval != '')
                    $ta_id = ProductAgreement::where('agreementnumber', $agreementnumber)->pluck('ta_id')[0];
                else {
                    $ta_id = 0;
                }

                $am = AccountManagement::select('user')->where('ta_id', $ta_id)->first();
                if ($am != '')
                    $accountmanager = AccountManagement::where('ta_id', $ta_id)->latest()->pluck('user')[0];
                else {
                    $accountmanager = 0;
                }

                $request->merge([
                    'accountmanager' => $accountmanager,
                    'ta_id' => $ta_id,
                    'balance' => $balance,
                    'created_by' => auth()->user()->id
                ]);
                $productcost = ProductCost::create($request->all());
                if (!empty($productcost) > 0) {
                    echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Inserted
            </div>';
                }
            }

        }
    }

    public function update(Request $request)
    {
        if ($request->column_name === 'cost') {
            //get all rquired data
            $id = $request->id;
            $cost = $request->column_value;
            $payment = ProductCost::select('received')->where('id', $request->id)->pluck('received');
            $totalpayment = $payment->sum();
            $balance = $cost - $totalpayment;

            $data = array(
                $request->column_name => $request->column_value,
                'received' => $totalpayment,
                'balance' => $balance,
                'updated_by' => auth()->user()->id
            );

            //update data in Procust Cost CRUD
            $productcost = ProductCost::where('id', $request->id)->update($data);
            if (!empty($productcost)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }

        }

        if ($request->column_name === 'received') {
            //get all rquired data
            $id = $request->id;
            $received = $request->column_value;
            $cost = ProductCost::select('cost')->where('id', $request->id)->pluck('cost');
            $totalcost = $cost->sum();
            $balance = $totalcost - $received;

            $data = array(
                'cost' => $totalcost,
                $request->column_name => $request->column_value,
                'balance' => $balance,
                'updated_by' => auth()->user()->id
            );

            //update data in Procust Cost CRUD
            $productcost = ProductCost::where('id', $request->id)->update($data);
            if (!empty($productcost)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }

        }

        if ($request->column_name === 'agreementnumber') {
            //gets agreementnumber
            $agreementnumber = $request->column_value;

            //find travel id from the above agreementnumber
            $taval = ProductAgreement::select('ta_id')->where('agreementnumber', $agreementnumber)->first();
            if ($taval != '')
                $ta_id = ProductAgreement::where('agreementnumber', $agreementnumber)->latest()->pluck('ta_id')[0];
            else {
                $ta_id = 0;
            }

            //find account manager from the above travel id
            $accountmanagerval = AccountManagement::select('user')->where('ta_id', $ta_id)->first();
            if ($accountmanagerval != '') {
                $accountmanager = AccountManagement::select('user')->where('ta_id', $ta_id)->latest()->pluck('user')[0];
            } else {
                $accountmanager = 0;
            }

            if ($request->ajax()) {
                $data = array(
                    $request->column_name => $request->column_value,
                    'ta_id' => $ta_id,
                    'accountmanager' => $accountmanager,
                    'updated_by' => auth()->user()->id
                );
                $productcost = ProductCost::where('id', $request->id)->update($data);
                if (!empty($productcost)) {
                    echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
                }
            }
        } else {
            if ($request->ajax()) {
                $data = array(
                    $request->column_name => $request->column_value,
                    'updated_by' => auth()->user()->id
                );
                $productcost = ProductCost::where('id', $request->id)->update($data);
                if (!empty($productcost)) {
                    echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
                }
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            ProductCost::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function showed($id)
    {
        $data['productcost'] = ProductCost::findOrFail($id);
        return view('backend.products.productcost.ajaxshowed', $data);
    }

    public function checkAgreement(Request $request)
    {
        $checkagreementnumber = ProductAgreement::where('p_id', $request->p_id)->first();
        if (empty($checkagreementnumber)) {
            return response()->json([
                'status' => false,
                'message' => 'There are no Agreement Numbers associated with this Product ID'
            ]);
        }
    }

    public function printproductscost(Request $request, $id)
    {
        if ($id != 0) {
//            $data['productval'] = productsDetails($request->p_id);
            if (empty($request->agreementnumber) && empty($request->from) && empty($request->to)) {
                $data['productval'] = productsDetails($request->id);
                $data['productscost'] = ProductCost::where('p_id', $id)->orderBy('p_id', 'asc')->get();
            }
            if (!empty($request->agreementnumber) && empty($request->from) && empty($request->to)) {
                $data['productval'] = productsDetails($request->id);
                $data['productscost'] = ProductCost::where('p_id', $id)->where('agreementnumber', $request->agreementnumber)->orderBy('agreementnumber', 'asc')->get();
            }
            if (empty($request->agreementnumber) && !empty($request->from) && !empty($request->to)) {
                $data['productval'] = productsDetails($request->id);
                $data['productscost'] = ProductCost::where('p_id', $id)->whereBetween('entrydate', [$request->from, $request->to])->orderBy('p_id', 'asc')->get();
            }
            if (!empty($request->agreementnumber) && !empty($request->from) && !empty($request->to)) {
                $data['productval'] = productsDetails($request->id);
                $data['productscost'] = ProductCost::where('p_id', $id)->where('agreementnumber', $request->agreementnumber)->whereBetween('entrydate', [$request->from, $request->to])->orderBy('agreementnumber', 'asc')->get();
            }
            if (empty($request->agreementnumber) && !empty($request->from) && empty($request->to)) {
                $data['productval'] = productsDetails($request->id);
                $data['productscost'] = ProductCost::where('p_id', $id)->where('entrydate', '>=', $request->from)->orderBy('agreementnumber', 'asc')->get();
            }
            if (empty($request->agreementnumber) && empty($request->from) && !empty($request->to)) {
                $data['productval'] = productsDetails($request->id);
                $data['productscost'] = ProductCost::where('p_id', $id)->where('entrydate', '<=', $request->to)->orderBy('agreementnumber', 'asc')->get();
            }
            return view('backend.products.productcost.printproductscost', $data);
        } else {
            if (empty($id) && empty($request->agreementnumber) && !empty($request->from) && !empty($request->to)) {
                $productcostentry = ProductCost::whereBetween('entrydate', [$request->from, $request->to])->orderBy('id', 'desc')->get();

                $data['productcostentries'] = $productcostentry->groupBy(function ($item) {
                    return $item->p_id;
                });
            } else {
                $productcostentry = ProductCost::orderBy('agreementnumber', 'asc')->get();

                $data['productcostentries'] = $productcostentry->groupBy(function ($item) {
                    return $item->p_id;
                });
            }
        }
        return view('backend.products.productcost.printsecondfile', $data);
    }

}
