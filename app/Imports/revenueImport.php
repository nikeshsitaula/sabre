<?php

namespace App\Imports;

use App\Models\AccountManagement\AccountManagement;
use App\Models\AccountManagement\AgencyAgreement;
use App\Models\Booking\Revenue;
use App\Models\TravelManagement\TravelAgency;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Str;

class revenueImport implements ToModel, WithStartRow
{
    public function model(array $row)
    {
        $travelagency = strtolower(explode('-',$row[1])[0]);
        $id = TravelAgency::where('ta_name','like','%'.$travelagency.'%')->first();
        if (!empty($id)){
            $ta_id = $id->ta_id;
        }else{
            $ta_id = 0;
        }

        $product = ($row[4]);
        $calc = ($row[5]);
        if (Str::contains($product, 'FIT')){
            $fit = 'FIT';
            $git = 0;
//            $fit_calc = floor($calc);
            $fit_calc = $calc;
            $git_calc = 0;
//            $incentive = abs($fit_calc + ($git_calc/4));
            $incentive = $fit_calc + ($git_calc/4);
        }
        else{
            $git = 'GIT';
            $fit = 0;
//            $git_calc = floor($calc);
            $git_calc = $calc;
            $fit_calc = 0;
//            $incentive = abs($fit_calc + ($git_calc/4));
            $incentive = $fit_calc + ($git_calc/4);
        }

        $val = AgencyAgreement::where('ta_id', $ta_id)->where('lowerlimit', '<', $incentive)
            ->where('upperlimit','>=',$incentive)
            ->first();

        if (!empty($val))
            $msc = $val->value* $incentive;
        else
            $msc = 0;

        $yearval = Date::excelToDateTimeObject($row[0])->format('Y-m');
        $accountmanagerdata = AccountManagement::where('ta_id', $ta_id)->where('date', 'LIKE', '%'.$yearval.'%')->pluck('user')->first();


        return new Revenue([
            'month' => Date::excelToDateTimeObject($row[0])->format('m'),
            'year' => Date::excelToDateTimeObject($row[0])->format('Y'),
            'pcc' => $row[3],
            'ta_id' => $ta_id,
            'fit' => $fit,
            'git' => $git,
            'fit_calc' => $fit_calc,
            'git_calc' => $git_calc,
            'created_by' => auth()->user()->id,
            'incentives' => $incentive,
            'marketsharecommitment' => $msc,
            'accountmanager' => $accountmanagerdata

        ]);
    }

    public function startRow(): int
    {
        return 3;
    }
}
