<?php

namespace App\Http\Controllers\Backend\SalesManagement;

use App\Models\Auth\User;
use App\Models\Sales\Sale;
use App\Models\Sales\SmaOtherCost;
use App\Models\Sales\Smaprize;
use App\Models\TravelManagement\TravelAgency;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SmaPrizeController extends Controller
{
    public function index()
    {
        $data['sma_id'] = Sale::select(DB::raw("CONCAT(name,'(',sma_id,')') AS name"), 'sma_id')->pluck('name', 'sma_id');
        return view('backend.sales.smaprize.index', $data);
    }

    function fetch_data(Request $request)
    {

        if ($request->ajax()) {
            $data = SmaPrize::where('sma_id', $request->sma_id)->orderBy('id', 'desc')->paginate(6);
            echo json_encode($data);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $ta_id = $request->ta_id;
            $travelnames = TravelAgency::select('ta_name')->where('ta_id', $ta_id)->first();
            if ($travelnames != '') {
                $travelname = $travelnames->ta_name;
            } else {
                $travelname = 0;
            }
            $request->merge([
                'travelname' => $travelname,
                'created_by' => auth()->user()->id
            ]);
            $smaprize = SmaPrize::create($request->all());
            if (!empty($smaprize) > 0) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Inserted
            </div>';
            }
            $sma_id = $request->sma_id;
            $smaprize = $request->prizeamount;
            $actualcost = Sale::select('actualcost')->where('sma_id', $sma_id)->pluck('actualcost');
//            $smaprize = Smaprize::select('prizeamount')->where('sma_id', $sma_id)->pluck('prizeamount');
//            $smaothercost = SmaOtherCost::select('amount')->where('sma_id', $sma_id)->pluck('amount');

            $totalactualcost = $actualcost->sum();
//            $totalsmaprize = $smaprize->sum();
//            $totalsmaothercost = $smaothercost->sum();

            $finalvalue = $totalactualcost + $smaprize;
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
        if ($request->column_name === 'prizeamount') {

            if ($request->ajax()) {
                $prevsmaamount = SmaPrize::where('id', $request->id)->pluck('prizeamount')->sum();
                $currentsmaamount = $request->column_value;
                $newamaamount = $currentsmaamount - $prevsmaamount;

                $data = array(
                    $request->column_name => $request->column_value,
                    'updated_by' => auth()->user()->id
                );
            }
            $smaprize = SmaPrize::where('id', $request->id)->update($data);
//            if (!empty($smaprize)) {
//                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
//                Data Updated
//            </div>';
//            }

            $prizeamount = $newamaamount;

            $sma_id = SmaPrize::where('id', $request->id)->pluck('sma_id');
            $actualcost = Sale::select('actualcost')->where('sma_id', $sma_id)->pluck('actualcost');

            $totalactualcost = $actualcost->sum();
            $finalvalue = $totalactualcost + $prizeamount;
//            dd($finalvalue);

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

        }
        if ($request->column_name === 'ta_id') {
            $ta_id = $request->column_value;
            $travelnames = TravelAgency::select('ta_name')->where('ta_id', $ta_id)->first();
            if ($travelnames != '') {
                $travelname = $travelnames->ta_name;
            } else {
                $travelname = 0;
            }

            $data = array(
                $request->column_name => $request->column_value,
                'travelname' => $travelname,
                'updated_by' => auth()->user()->id
            );

            $smaprize = SmaPrize::where('id', $request->id)->update($data);
            if (!empty($smaprize)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }

        } else {
            if ($request->ajax()) {
                $data = array(
                    $request->column_name => $request->column_value,
                    'updated_by' => auth()->user()->id
                );
            }
            $smaprize = SmaPrize::where('id', $request->id)->update($data);
            if (!empty($smaprize)) {
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
            $sma_id = Smaprize::select('sma_id')->where('id', $id)->pluck('sma_id');

            $prizeamountval = Smaprize::select('prizeamount')->where('id', $id)->pluck('prizeamount');
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

            SmaPrize::where('id', $request->id)->delete();

            if (!empty($updatefinal)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
            }
        }
    }

    public
    function showed($id)
    {
        $data['smaprize'] = SmaPrize::findOrFail($id);
        return view('backend.sales.smaprize.ajaxshowed', $data);
    }

    public
    function printsmaprize($id)
    {
        $data['smaval'] = smaDetails($id);
        $data['smaprize'] = SmaPrize::where('sma_id', $id)->get();
        return view('backend.sales.smaprize.printsmaprize', $data);
    }
}
