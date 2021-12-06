<?php

namespace App\Http\Controllers\Backend\Booking;

use App\Exports\incentiveExport;
use App\Imports\incentiveImport;
use App\Models\AccountManagement\AccountManagement;
use App\Models\Booking\Incentive;
use App\Models\TravelManagement\TravelAgency;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class IncentivesController extends Controller
{

    public function index()
    {
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ','&nbsp;',ta_phone,' ', '&nbsp;&nbsp; IATA: ',ta_iata_no,' ','&nbsp;&nbsp; Fax: ',ta_fax_no,' ') AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');

        return view('backend.Incentive.index', $data);
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->hasRole('administrator')) {
                $data = Incentive::orderBy('id', 'desc')->paginate(6);
            } else {
                $ta_id = AccountManagement::select('ta_id')->where('email', auth()->user()->email)->first();
                $data = Incentive::where('ta_id', $ta_id->ta_id)->orderBy('id', 'desc')->paginate(6);
            }
            echo json_encode($data);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);

            //updating old incentive for same month
//            $oldIncentive = Incentive::where('pcc', $request->pcc)->where('month',$request->month)->where('year',$request->year)->first();
//            if (!empty($oldIncentive)){
//                    if ($oldIncentive->year == $request->year && $oldIncentive->month == $request->month) {
//                        if ($oldIncentive->fit_calc == 0) {
//                            $oldIncentive->update([
//                                'fit_calc' => $request->fit_calc,
//                                'incentives' => $oldIncentive->fit_calc+($request->fit_calc/4)
//                            ]);
//                        } else {
//                            $oldIncentive->update([
//                                'git_calc' => $request->git_calc,
//                                'incentives' => $oldIncentive->fit_calc+($request->git_calc/4)
//                            ]);
//                        }
//                    }
//            }
            $pcc = Incentive::create($request->all());
            if (!empty($pcc) > 0) {
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
            $pcc = Incentive::where('id', $request->id)->update($data);
            if (!empty($pcc)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            Incentive::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function show($id)
    {
        $data['incentive'] = Incentive::findOrFail($id);
        return view('backend.incentive.ajaxshow', $data);
    }

    public function uploadExcelForm()
    {
        return view('backend.incentive.uploadExcel');
    }

    public function uploadExcel(Request $request)
    {
        $status = $this->validate($request, [
            'incentive' => 'required|mimes:xls,xlsx'
        ]);

        Excel::import(new incentiveImport(), $request->file('incentive'));

        return back()->with('success', 'Excel Data Imported successfully.');
    }

    public function search(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->from) && !empty($request->to) && empty($request->ta_id)) {
                $fromYear = explode('-', $request->from)[0];
                $fromMonth = explode('-', $request->from)[1];
                $toYear = explode('-', $request->to)[0];
                $toMonth = explode('-', $request->to)[1];

                $data = Incentive::whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') >= ?", "$fromYear-$fromMonth-1")
                    ->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') <= ?", "$toYear-$toMonth-1")->orderBy('id', 'asc')->paginate(6);

                return response()->json([
                    'data' => $data
                ]);
            } else if (!empty($request->from) && empty($request->to) && empty($request->ta_id)) {
                $fromYear = explode('-', $request->from)[0];
                $fromMonth = explode('-', $request->from)[1];

                $data = Incentive::where('month', $fromMonth)->where('year', $fromYear)->orderBy('id', 'asc')->paginate(6);

                return response()->json([
                    'data' => $data
                ]);
            }
            else if (!empty($request->ta_id) && empty($request->from) && empty($request->to)) {
                $data = Incentive::where('ta_id', $request->ta_id)->orderBy('id', 'asc')->paginate(6);

                return response()->json([
                    'data' => $data
                ]);
            } else if (empty($request->ta_id) && empty($request->from) && empty($request->to)) {
                $data = Incentive::orderBy('id', 'asc')->paginate(6);
                return response()->json([
                    'data' => $data
                ]);
            } else if (!empty($request->from) && !empty($request->to) && !empty($request->ta_id)) {
                $fromYear = explode('-', $request->from)[0];
                $fromMonth = explode('-', $request->from)[1];
                $toYear = explode('-', $request->to)[0];
                $toMonth = explode('-', $request->to)[1];

                $data = Incentive::where('ta_id', $request->ta_id)->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') >= ?", "$fromYear-$fromMonth-1")
                    ->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') <= ?", "$toYear-$toMonth-1")->orderBy('id', 'asc')->paginate(6);

                return response()->json([
                    'data' => $data
                ]);

            } else if (!empty($request->ta_id) && !empty($request->from) && empty($request->to)) {
                $fromYear = explode('-', $request->from)[0];
                $fromMonth = explode('-', $request->from)[1];

                $data = Incentive::where('ta_id', $request->ta_id)->where('month', $fromMonth)->where('year', $fromYear)->orderBy('id', 'asc')->paginate(6);

                return response()->json([
                    'data' => $data
                ]);
            } else {
                $data = Incentive::all();
                return response()->json([
                    'data' => $data
                ]);
            }
        }
    }

    public function print(Request $request)
    {
        if ($request->ajax()) {
            if (!empty($request->from) && !empty($request->to) && empty($request->ta_id)) {
                $fromYear = explode('-', $request->from)[0];
                $fromMonth = explode('-', $request->from)[1];
                $toYear = explode('-', $request->to)[0];
                $toMonth = explode('-', $request->to)[1];

                $incentive = Incentive::whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') >= ?", "$fromYear-$fromMonth-1")
                    ->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') <= ?", "$toYear-$toMonth-1")->orderBy('id', 'asc')->get();
                return view('backend.incentive.printIncentive')->with('incentive', $incentive);
            } else if (!empty($request->from) && empty($request->to) && empty($request->ta_id)) {
                $fromYear = explode('-', $request->from)[0];
                $fromMonth = explode('-', $request->from)[1];

                $incentive = Incentive::where('month', $fromMonth)->where('year', $fromYear)->orderBy('id', 'asc')->get();
                return view('backend.incentive.printIncentive')->with('incentive', $incentive);
            } else if (!empty($request->ta_id) && empty($request->from) && empty($request->to)) {

                $incentive = Incentive::where('ta_id', $request->ta_id)->orderBy('id', 'asc')->get();
                return view('backend.incentive.printIncentive')->with('incentive', $incentive);
            } else if (empty($request->ta_id) && empty($request->from) && empty($request->to)) {
                $incentive = Incentive::orderBy('id', 'asc')->get();
                return view('backend.incentive.printIncentive')->with('incentive', $incentive);
            } else if (!empty($request->from) && !empty($request->to) && !empty($request->ta_id)) {
                $fromYear = explode('-', $request->from)[0];
                $fromMonth = explode('-', $request->from)[1];
                $toYear = explode('-', $request->to)[0];
                $toMonth = explode('-', $request->to)[1];

                $incentive = Incentive::where('ta_id', $request->ta_id)->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') >= ?", "$fromYear-$fromMonth-1")
                    ->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') <= ?", "$toYear-$toMonth-1")->orderBy('id', 'asc')->get();
                return view('backend.incentive.printIncentive')->with('incentive', $incentive);
            } else if (!empty($request->ta_id) && !empty($request->from) && empty($request->to)) {
                $fromYear = explode('-', $request->from)[0];
                $fromMonth = explode('-', $request->from)[1];

                $incentive = Incentive::where('ta_id', $request->ta_id)->where('month', $fromMonth)->where('year', $fromYear)->orderBy('id', 'asc')->get();
                return view('backend.incentive.printIncentive')->with('incentive', $incentive);
            } else {
                $incentive = Incentive::all();
                return view('backend.incentive.printIncentive')->with('incentive', $incentive);
            }
            $incentive = Incentive::get();
            return view('backend.Incentive.printIncentive')->with('incentive', $incentive);
        }
    }
    public function exportexcel(Request $request)
    {
        return Excel::download(new incentiveExport($request->from, $request->to, $request->ta_id), 'incentive.xlsx');
    }
}
