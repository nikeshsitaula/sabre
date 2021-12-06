<?php

namespace App\Http\Controllers\Backend\Booking;

use App\Exports\revenueExport;
use App\Imports\revenueImport;
use App\Models\AccountManagement\AccountManagement;
use App\Models\Booking\Revenue;
use App\Models\TravelManagement\TravelAgency;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class RevenuesController extends Controller
{

    public function index()
    {
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ','&nbsp;',ta_phone,' ', '&nbsp;&nbsp; IATA: ',ta_iata_no,' ','&nbsp;&nbsp; Fax: ',ta_fax_no,' ') AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');

        return view('backend.revenue.index', $data);
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            if (auth()->user()->hasRole('administrator')) {
                $data = Revenue::orderBy('id', 'desc')->paginate(6);
            } else {
                $ta_id = AccountManagement::select('ta_id')->where('email', auth()->user()->email)->first();
                $data = Revenue::where('ta_id', $ta_id->ta_id)->orderBy('id', 'desc')->paginate(6);
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
            $pcc = Revenue::create($request->all());
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
            $pcc = Revenue::where('id', $request->id)->update($data);
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
            Revenue::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function show($id)
    {
        $data['revenue'] = Revenue::findOrFail($id);
        return view('backend.revenue.ajaxshow', $data);
    }

    public function uploadExcelForm()
    {
        return view('backend.revenue.uploadExcel');
    }

    public function uploadExcel(Request $request)
    {
        $status = $this->validate($request, [
            'revenue' => 'required|mimes:xls,xlsx'
        ]);

        Excel::import(new revenueImport(), $request->file('revenue'));

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

                $data = Revenue::whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') >= ?", "$fromYear-$fromMonth-1")
                    ->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') <= ?", "$toYear-$toMonth-1")
                    ->orderBy('id', 'asc')
                    ->paginate(6);
                return response()->json([
                    'data' => $data
                ]);
            } else if (!empty($request->from) && empty($request->to) && empty($request->ta_id)) {
                $fromYear = explode('-', $request->from)[0];
                $fromMonth = explode('-', $request->from)[1];

                $data = Revenue::where('month', $fromMonth)->where('year', $fromYear)->orderBy('id', 'asc')->paginate(6);

                return response()->json([
                    'data' => $data
                ]);
            } else if (!empty($request->ta_id) && empty($request->from) && empty($request->to)) {

                $data = Revenue::where('ta_id', $request->ta_id)->orderBy('id', 'asc')->paginate(6);

                return response()->json([
                    'data' => $data
                ]);
            } else if (empty($request->ta_id) && empty($request->from) && empty($request->to)) {
                $data = Revenue::orderBy('id', 'asc')->paginate(6);
                return response()->json([
                    'data' => $data
                ]);
            } else if (!empty($request->from) && !empty($request->to) && !empty($request->ta_id)) {
                $fromYear = explode('-', $request->from)[0];
                $fromMonth = explode('-', $request->from)[1];
                $toYear = explode('-', $request->to)[0];
                $toMonth = explode('-', $request->to)[1];

                $data = Revenue::where('ta_id', $request->ta_id)->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') >= ?", "$fromYear-$fromMonth-1")
                    ->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') <= ?", "$toYear-$toMonth-1")->orderBy('id', 'asc')->paginate(6);

                return response()->json([
                    'data' => $data
                ]);

            } else if (!empty($request->ta_id) && !empty($request->from) && empty($request->to)) {
                $fromYear = explode('-', $request->from)[0];
                $fromMonth = explode('-', $request->from)[1];

                $data = Revenue::where('ta_id', $request->ta_id)->where('month', $fromMonth)->where('year', $fromYear)->orderBy('id', 'asc')->paginate(6);

                return response()->json([
                    'data' => $data
                ]);
            } else {
                $data = Revenue::all();
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

                $revenue = Revenue::whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') >= ?", "$fromYear-$fromMonth-1")
                    ->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') <= ?", "$toYear-$toMonth-1")->orderBy('id', 'asc')->get();
                return view('backend.revenue.printRevenue')->with('revenue', $revenue);

            } else if (!empty($request->from) && empty($request->to) && empty($request->ta_id)) {
                $fromYear = explode('-', $request->from)[0];
                $fromMonth = explode('-', $request->from)[1];

                $revenue = Revenue::where('month', $fromMonth)->where('year', $fromYear)->orderBy('id', 'asc')->get();
                return view('backend.revenue.printRevenue')->with('revenue', $revenue);
            } else if (!empty($request->ta_id) && empty($request->from) && empty($request->to)) {

                $revenue = Revenue::where('ta_id', $request->ta_id)->orderBy('id', 'asc')->get();
                return view('backend.revenue.printRevenue')->with('revenue', $revenue);
            } else if (empty($request->ta_id) && empty($request->from) && empty($request->to)) {
                $revenue = Revenue::orderBy('id', 'asc')->get();
                return view('backend.revenue.printRevenue')->with('revenue', $revenue);
            } else if (!empty($request->from) && !empty($request->to) && !empty($request->ta_id)) {
                $fromYear = explode('-', $request->from)[0];
                $fromMonth = explode('-', $request->from)[1];
                $toYear = explode('-', $request->to)[0];
                $toMonth = explode('-', $request->to)[1];

                $revenue = Revenue::where('ta_id', $request->ta_id)->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') >= ?", "$fromYear-$fromMonth-1")
                    ->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') <= ?", "$toYear-$toMonth-1")->orderBy('id', 'asc')->get();
                return view('backend.revenue.printRevenue')->with('revenue', $revenue);
            } else if (!empty($request->ta_id) && !empty($request->from) && empty($request->to)) {
                $fromYear = explode('-', $request->from)[0];
                $fromMonth = explode('-', $request->from)[1];

                $revenue = Revenue::where('ta_id', $request->ta_id)->where('month', $fromMonth)->where('year', $fromYear)->orderBy('id', 'asc')->get();
                return view('backend.revenue.printRevenue')->with('revenue', $revenue);
            } else {
                $revenue = Revenue::all();
                return view('backend.revenue.printRevenue')->with('revenue', $revenue);
            }
            $revenue = Revenue::get();
            return view('backend.revenue.printRevenue')->with('revenue', $revenue);
        }
    }
    public function exportexcel(Request $request)
    {
        return Excel::download(new revenueExport($request->from, $request->to, $request->ta_id), 'revenue.xlsx');
    }
}
