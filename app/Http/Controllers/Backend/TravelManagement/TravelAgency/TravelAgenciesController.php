<?php

namespace App\Http\Controllers\Backend\TravelManagement\TravelAgency;

use App\Models\AccountManagement\AccountManagement;
use App\Models\AccountManagement\AgencyAgreement;
use App\Models\AccountManagement\IncentiveData;
use App\Models\Booking\Incentive;
use App\Models\Booking\MIDT;
use App\Models\Booking\Revenue;
use App\Models\TravelManagement\Lniata;
use App\Models\TravelManagement\PCC;
use App\Models\TravelManagement\Staff;
use App\Models\TravelManagement\TrainingStaff;
use App\Models\TravelManagement\TravelMiscz;
use App\Models\TravelManagement\Visit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Auth\User;
use App\Models\TravelManagement\TravelAgency;
use DB;
use Yajra\DataTables\Facades\DataTables;

class TravelAgenciesController extends Controller
{

    public function index()
    {
        return view('backend.travel.travelagency.index');
    }


    public function create()
    {
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ','&nbsp;',ta_phone,' ', '&nbsp;&nbsp; IATA: ',ta_iata_no,' ','&nbsp;&nbsp; Fax: ',ta_fax_no,' ') AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');

        return view('backend.travel.travelagency.create');
    }

    public function store(Request $request)
    {
        $travel = new TravelAgency;
        $travel->create($request->all());
        return back()->withFlashSuccess(__('alerts.backend.records.created'));
    }


    public function show($id)
    {
        $data['travel'] = TravelAgency::findOrFail($id);

        return view('backend.travel.travelagency.ajaxshow', $data);
    }

    public function edit($id)
    {
        $data['travel'] = TravelAgency::findOrFail($id);

        return view('backend.travel.travelagency.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $travel = TravelAgency::findOrFail($id);
        $travel->update($request->all());
        return back()->withFlashSuccess(__('alerts.backend.records.updated'));
    }


    public function destroy($id)
    {
        $travel = TravelAgency::findOrFail($id);
        $pcc = PCC::where('ta_id',$travel->ta_id)->delete();
        $staff = Staff::where('ta_id',$travel->ta_id)->delete();
        $trainingstaff = TrainingStaff::where('ta_id',$travel->ta_id)->delete();
        $lniata = Lniata::where('ta_id',$travel->ta_id)->delete();
        $travelmiscz = TravelMiscz::where('ta_id',$travel->ta_id)->delete();
        $visit = Visit::where('ta_id',$travel->ta_id)->delete();
        $midt = MIDT::where('ta_id',$travel->ta_id)->delete();
        $incentive = Incentive::where('ta_id',$travel->ta_id)->delete();
        $revenue = Revenue::where('ta_id',$travel->ta_id)->delete();
        $accountmanagement = AccountManagement::where('ta_id',$travel->ta_id)->delete();
        $revenue = AgencyAgreement::where('ta_id',$travel->ta_id)->delete();
        $revenue = IncentiveData::where('ta_id',$travel->ta_id)->delete();
        $travel->delete();

        return back()->withFlashSuccess(__('alerts.backend.records.deleted'));
    }


    public function checkTravelExistence(Request $request)
    {
        //search travel with ta_id if it exist or not
        $exist = TravelAgency::where('ta_id', $request->ta_id)->first();
        if ($exist) {
            $msg = false;
        } else {
            $msg = true;
        }
        //returns response as json data ( can be checked in console for this response which is displayed in blade using console.log(data.message) in create.blade.php
        return response()->json([
            'status' => 'success',
            'message' => $msg
        ]);
    }

    public function listTravels()
    {
        $travel = TravelAgency::get();
        return Datatables::of($travel)
            ->addColumn('action', function ($travel) {
                if (auth()->user()->hasanyRole(['administrator|travelmanager'])) {
                    return '<a data-id="' . $travel->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="travel/edit/' . $travel->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ' .
                        '<a href="travel/destroy/' . $travel->id . '" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>';
                } else {
                    return '<a data-id="' . $travel->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="travel/edit/' . $travel->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ';
                }
            })
            ->make(true);
    }

}
