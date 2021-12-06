<?php

namespace App\Http\Controllers\Backend\SalesManagement;

use App\Models\Auth\User;
use App\Models\Sales\Sale;
use App\Models\Sales\SmaOtherCost;
use App\Models\Sales\Smaprize;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmaOtherCostController extends Controller
{
    public function index()
    {
        $data['sma_id'] = Sale::select(DB::raw("CONCAT(name,'(',sma_id,')') AS name"), 'sma_id')->pluck('name', 'sma_id');
        return view('backend.sales.smaothercost.index',$data);
    }

    function fetch_data(Request $request)
    {

        if ($request->ajax()) {
            $data = SmaOtherCost::where('sma_id', $request->sma_id)->orderBy('id', 'desc')->paginate(6);
            echo json_encode($data);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            $smaothercost = SmaOtherCost::create($request->all());
            if (!empty($smaothercost) > 0) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Inserted
            </div>';
            }

            $sma_id = $request->sma_id;
            $smaothercost = $request->amount;
            $actualcost = Sale::select('actualcost')->where('sma_id', $sma_id)->pluck('actualcost');
//            $smaothercost = SmaOtherCost::select('amount')->where('sma_id', $sma_id)->pluck('amount');
//            $smaprize = Smaprize::select('prizeamount')->where('sma_id', $sma_id)->pluck('prizeamount');

            $totalactualcost = $actualcost->sum();
//            $totalsmaothercost = $smaothercost->sum();
//            $totalsmaprize = $smaprize->sum();

            $finalvalue = $totalactualcost+ $smaothercost;
//            $finalvalue = $totalactualcost + $totalsmaprize + $totalsmaothercost;


            if (!empty($finalvalue)) {
                $updatesma = array(
                    'actualcost' => $finalvalue,
                    'updated_by' => auth()->user()->id
                );
            } else {
                $updatesma = array(
                    'updated_by' => auth()->user()->id
                );
            }

            $updatefinal = Sale::where('sma_id', $sma_id)->update($updatesma);

            if (!empty($updatefinal)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                SMA Updated
            </div>';

            }
        }
    }


    public function update(Request $request)
    {
        if ($request->column_name === 'amount') {

            if ($request->ajax()) {
                $prevsmaamount = SmaOtherCost::where('id', $request->id)->pluck('amount')->sum();
                $currentsmaamount = $request->column_value;
                $newamaamount = $currentsmaamount - $prevsmaamount;
                $data = array(
                    $request->column_name => $request->column_value,
                    'updated_by' => auth()->user()->id
                );
            }
            $smaothercost = SmaOtherCost::where('id', $request->id)->update($data);
            if (!empty($smaothercost)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }

            $amount = $newamaamount;

            $sma_id = SmaOtherCost::where('id', $request->id)->pluck('sma_id');
            $actualcost = Sale::select('actualcost')->where('sma_id', $sma_id)->pluck('actualcost');

            $totalactualcost = $actualcost->sum();
            $finalvalue = $totalactualcost + $amount;

            if (!empty($finalvalue)) {
                $updatesma = array(
                    'actualcost' => $finalvalue,
                    'updated_by' => auth()->user()->id
                );
            } else {
                $updatesma = array(
                    'updated_by' => auth()->user()->id
                );
            }

            $smasale = Sale::where('sma_id', $sma_id)->update($updatesma);

            if (!empty($smasale)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                SMA Updated
            </div>';
            }

        } else {
            if ($request->ajax()) {
                $data = array(
                    $request->column_name => $request->column_value,
                    'updated_by' => auth()->user()->id
                );
            }
            $smaothercost = SmaOtherCost::where('id', $request->id)->update($data);
            if (!empty($smaothercost)) {
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
            $sma_id = SmaOtherCost::select('sma_id')->where('id', $id)->pluck('sma_id');

            $prizeamountval = SmaOtherCost::select('amount')->where('id', $id)->pluck('amount');
            $prizeamount = $prizeamountval->sum();

            // current actual value from sales
            $actualcostval = Sale::select('actualcost')->where('sma_id', $sma_id)->pluck('actualcost');
            $currentactualcost = $actualcostval->sum();

            // finding out final value
            $finalactualcost = $currentactualcost - $prizeamount;

            if (!empty($finalactualcost)) {
                $updateactualcost = array(
                    'actualcost' => $finalactualcost,
                    'updated_by' => auth()->user()->id
                );
            } else {
                $updateactualcost = array(
                    'actualcost' => 0,
                    'updated_by' => auth()->user()->id
                );
            }
            //update values in sma
            $updatefinal = Sale::where('sma_id', $sma_id)->update($updateactualcost);

            SmaOtherCost::where('id', $request->id)->delete();

            if (!empty($updatefinal)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
            }
        }
    }

    public function showed($id)
    {
        $data['smaothercost'] = SmaOtherCost::findOrFail($id);
        return view('backend.sales.smaothercost.ajaxshowed', $data);
    }

    public function printsmaothercost($id)
    {
        $data['smaval'] = smaDetails($id);
        $data['smaothercost'] = SmaOtherCost::where('sma_id',$id)->get();
        return view('backend.sales.smaothercost.printsmaothercost', $data);
    }
}
