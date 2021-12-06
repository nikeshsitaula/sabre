<?php

namespace App\Imports;

use App\Models\AccountManagement\AccountManagement;
use App\Models\Booking\MIDT;
use App\Models\TravelManagement\TravelAgency;
use Carbon\Carbon;
use DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class midtImport implements ToModel, WithStartRow
{

    public function model(array $row)
    {
        $travelagency = strtolower(explode('-', $row[1])[0]);
        $id = TravelAgency::where('ta_name', 'like', '%' . $travelagency . '%')->first();
        if (!empty($id)) {
            $ta_id = $id->ta_id;
        } else {
            $ta_id = 0;
        }
        if($row[3] != 0) {
            $mscalc = ($row[3]/($row[3] + $row[4] + $row[5]))*100 ;
            $marketsharecommitments = number_format($mscalc, 2, '.', ',');
        } else {
            $mscalc = 0;
            $marketsharecommitments = 0;
        }

        $yearval = Date::excelToDateTimeObject($row[0])->format('Y-m');
        $accountmanagerdata = AccountManagement::where('ta_id', $ta_id)->where('date', 'LIKE', '%'.$yearval.'%')->pluck('user')->first();

        return new MIDT([
            'month' => Date::excelToDateTimeObject($row[0])->format('m'),
            'year' => Date::excelToDateTimeObject($row[0])->format('Y'),
            'sabre_bookings' => $row[3],
            'amadeus' => $row[4],
            'travel_port' => $row[5],
            'others' => 0,
            'ta_id' => $ta_id,
            'created_by' => auth()->user()->id,
            'marketsharecommitment' => $marketsharecommitments,
            'accountmanager' => $accountmanagerdata
        ]);
    }

    public function startRow(): int
    {
        return 3;
    }
}
