<?php

namespace App\Exports;

use App\Models\Booking\Revenue;
use App\User;

use Maatwebsite\Excel\Concerns\Exportable;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class revenueExport implements FromView
{
    use Exportable;

    public function __construct($from, $to, $ta_id)
    {
        $this->from = $from;
        $this->to = $to;
        $this->ta_id = $ta_id;
    }

    public function view():view
    {
//        return view('backend.revenue.printExcel', [
//            'data' => $this->data
//        ]);

        if (!empty($this->from) && !empty($this->to) && empty($this->ta_id)) {
            $fromYear = explode('-', $this->from)[0];
            $fromMonth = explode('-', $this->from)[1];
            $toYear = explode('-', $this->to)[0];
            $toMonth = explode('-', $this->to)[1];

            $data = Revenue::whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') >= ?", "$fromYear-$fromMonth-1")
                ->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') <= ?", "$toYear-$toMonth-1")->orderBy('id', 'asc')->get();
            return view('backend.revenue.printExcel')->with('data', $data);

        } else if (!empty($this->from) && empty($this->to) && empty($this->ta_id)) {
            $fromYear = explode('-', $this->from)[0];
            $fromMonth = explode('-', $this->from)[1];

            $data = Revenue::where('month', $fromMonth)->where('year', $fromYear)->orderBy('id', 'asc')->paginate(6);
            return view('backend.revenue.printExcel')->with('data', $data);

        } else if (!empty($this->ta_id) && empty($this->from) && empty($this->to)) {

            $data = Revenue::where('ta_id', $this->ta_id)->orderBy('id', 'asc')->paginate(6);
            return view('backend.revenue.printExcel')->with('data', $data);


        } else if (empty($this->ta_id) && empty($this->from) && empty($this->to)) {
            $data = Revenue::orderBy('id', 'asc')->paginate(6);
            return view('backend.revenue.printExcel')->with('data', $data);

        } else if (!empty($this->from) && !empty($this->to) && !empty($this->ta_id)) {
            $fromYear = explode('-', $this->from)[0];
            $fromMonth = explode('-', $this->from)[1];
            $toYear = explode('-', $this->to)[0];
            $toMonth = explode('-', $this->to)[1];

            $data = Revenue::where('ta_id', $this->ta_id)->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') >= ?", "$fromYear-$fromMonth-1")
                ->whereRaw("STR_TO_DATE(CONCAT(year,'-',month, '-', 1), '%Y-%m-%d') <= ?", "$toYear-$toMonth-1")->orderBy('id', 'asc')->paginate(6);
            return view('backend.revenue.printExcel')->with('data', $data);

        } else if (!empty($this->ta_id) && !empty($this->from) && empty($this->to)) {
            $fromYear = explode('-', $this->from)[0];
            $fromMonth = explode('-', $this->from)[1];

            $data = Revenue::where('ta_id', $this->ta_id)->where('month', $fromMonth)->where('year', $fromYear)->orderBy('id', 'asc')->paginate(6);
            return view('backend.revenue.printExcel')->with('data', $data);

        } else {
            $data = Revenue::all();
            return view('backend.revenue.printExcel')->with('data', $data);
        }
    }
}
