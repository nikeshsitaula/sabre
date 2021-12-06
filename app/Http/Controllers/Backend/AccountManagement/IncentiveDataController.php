<?php

namespace App\Http\Controllers\Backend\AccountManagement;

use App\Http\Controllers\Controller;
use App\Models\AccountManagement\AccountManagement;
use App\Models\AccountManagement\IncentiveData;
use App\Models\Booking\Incentive;
use App\Models\Booking\MIDT;
use App\Models\TravelManagement\TravelAgency;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Input;

class IncentiveDataController extends Controller
{
    public function index()
    {
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ','&nbsp;',ta_phone,' ', '&nbsp;&nbsp; IATA: ',ta_iata_no,' ','&nbsp;&nbsp; Fax: ',ta_fax_no,' ') AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');

        return view('backend.accountmanagement.incentivedata.index', $data);
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $data = IncentiveData::where('ta_id', $request->ta_id)->orderBy('id', 'desc')->paginate(6);
            echo json_encode($data);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            $incentivedata = IncentiveData::create($request->all());
            if (!empty($incentivedata) > 0) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Inserted
            </div>';
            }
        }
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            $data = array(
                $request->column_name => $request->column_value,
                'updated_by' => auth()->user()->id
            );
            $incentivedata = IncentiveData::where('id', $request->id)->update($data);
            if (!empty($incentivedata)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            IncentiveData::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function showed($id)
    {
        $data['incentivedata'] = IncentiveData::findOrFail($id);
        return view('backend.accountmanagement.incentivedata.ajaxshowed', $data);
    }

    public function printincentivedata($id)
    {
        $data['travelagency'] = travelAgencyDetails($id);
        $data['incentivedata'] = IncentiveData::where('ta_id', $id)->get();
        return view('backend.accountmanagement.incentivedata.printincentivedata', $data);
    }

    public function updateincentivedata(Request $request, $ta_id)
    {
        //previous values
        $prevtargetsegment = IncentiveData::select('targetsegment')->where('ta_id', $ta_id)->latest()->pluck('targetsegment')[0];
        $prevsegmenttomonth = IncentiveData::select('segmenttomonth')->where('ta_id', $ta_id)->latest()->pluck('segmenttomonth')[0];
        $prevtomonthmarketshare = IncentiveData::select('tomonthmarketshare')->where('ta_id', $ta_id)->latest()->pluck('tomonthmarketshare')[0];
        $prevmonth = IncentiveData::select('month')->where('ta_id', $ta_id)->latest()->pluck('month')[0];

        //current values
        $currentvolumecommitment = IncentiveData::select('volumecommitment')->where('ta_id', $ta_id)->latest()->pluck('volumecommitment')[0];
        $ccp = IncentiveData::select('contactperiod')->where('ta_id', $ta_id)->latest()->pluck('contactperiod')[0];
        if ($ccp != 0) {
            $currentcontactperiod = $ccp;
        } else {
            $currentcontactperiod = 1;
        }
        $currentid = IncentiveData::select('id')->where('ta_id', $ta_id)->latest()->pluck('id')[0];


        //get month and year and parse them
        $startDate = IncentiveData::select('startdate')->where('ta_id', $ta_id)->latest()->pluck('startdate')[0];
        $startmonth = Carbon::parse($startDate)->month;
        $startyear = Carbon::parse($startDate)->year;
        $endDate = $request->endDate;
        $endmonth = Carbon::parse($endDate)->month;
        $endyear = Carbon::parse($endDate)->year;

        //for segmenttomonth
        $dataincentive = Incentive::select('marketsharecommitment')->where('ta_id', $ta_id)->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') >= ?", "$startyear-$startmonth-1")
            ->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') <= ?", "$endyear-$endmonth-1")->pluck('marketsharecommitment');

        $totalVolumeShare = 0;
        foreach ($dataincentive as $di) {
            $totalVolumeShare += (float)$di;
        }

        //for tomonthshare
        $datamidt = MIDT::select('marketsharecommitment')->where('ta_id', $ta_id)->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') >= ?", "$startyear-$startmonth-1")
            ->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') <= ?", "$endyear-$endmonth-1")->pluck('marketsharecommitment');

        $toMonthShare = 0;
        foreach ($datamidt as $dm) {
            $toMonthShare += (float)$dm;
        }

        //for month
        $to = \Carbon\Carbon::createFromFormat('Y-m-d', $startDate);
        $from = \Carbon\Carbon::createFromFormat('Y-m-d', $endDate);
        $diff_in_months = $to->diffInMonths($from);

        //for target segment
        $neededmonth = $diff_in_months + 1;
        $targetsegmentval = ($currentvolumecommitment / $currentcontactperiod) * $neededmonth;

        //update data
        $incdata = IncentiveData::where('id', $currentid)->update([
            'segmenttomonth' => $totalVolumeShare + $prevsegmenttomonth,
            'tomonthmarketshare' => $toMonthShare + $prevtomonthmarketshare,
            'month' => $diff_in_months + $prevmonth + 1,
            'targetsegment' => $targetsegmentval + $prevtargetsegment
        ]);
        if (!empty($incdata) && !empty($toMonthShare) && !empty($month)) {
            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Incentive Data Updated';
        }

    }
}
