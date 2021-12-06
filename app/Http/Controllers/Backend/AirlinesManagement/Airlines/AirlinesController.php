<?php

namespace App\Http\Controllers\Backend\AirlinesManagement\Airlines;

use App\Http\Controllers\Controller;
use App\Models\AirlinesManagement\Airline;
use App\Models\AirlinesManagement\AirlineMisc;
use App\Models\AirlinesManagement\AirlineStaff;
use App\Models\AirlinesManagement\AirlineVisit;
use Illuminate\Http\Request;
use DB;
use Yajra\DataTables\Facades\DataTables;

class AirlinesController extends Controller
{
    public function index()
    {
        return view('backend.airlinesmanagement.airlines.index');
    }


    public function create()
    {
        $data['ai_id'] = Airline::select(DB::raw("CONCAT(name,'(',ai_id,') ','&nbsp;',phone,' ', '&nbsp;&nbsp; IATA(numeric): ',numericiata,' ','&nbsp;&nbsp; IATA(alphanumeric): ',alphanumericiata,' ','&nbsp;&nbsp; Fax: ',fax,' ') AS name"), 'ai_id')->pluck('name', 'ai_id');

        return view('backend.airlinesmanagement.airlines.create');
    }

    public function store(Request $request)
    {
        $airlines = new Airline();
        $airlines->create($request->all());
        return back()->withFlashSuccess(__('alerts.backend.records.created'));
    }


    public function show($id)
    {
        $data['airlines'] = Airline::findOrFail($id);

        return view('backend.airlinesmanagement.airlines.ajaxshow', $data);
    }

    public function edit($id)
    {
        $data['airlines'] = Airline::findOrFail($id);

        return view('backend.airlinesmanagement.airlines.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $airlines = Airline::findOrFail($id);
        $airlines->update($request->all());
        return back()->withFlashSuccess(__('alerts.backend.records.updated'));
    }

    public function destroy($id)
    {
        $airlines = Airline::findOrFail($id);
        $airlinemisc = AirlineMisc::where('ai_id',$airlines->ai_id)->delete();
        $airlinestaff = AirlineStaff::where('ai_id',$airlines->ai_id)->delete();
        $airlinevisit = AirlineVisit::where('ai_id',$airlines->ai_id)->delete();
        $airlines->delete();

        return back()->withFlashSuccess(__('alerts.backend.records.deleted'));
    }

    public function checkAirlinesExistence(Request $request)
    {
        //search airline with ai_id if it exist or not
        $exist = Airline::where('ai_id', $request->ai_id)->first();
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

    public function listAirlines()
    {
        $airlines = Airline::get();
        return Datatables::of($airlines)
            ->addColumn('action', function ($airlines) {
                if (auth()->user()->hasanyRole(['administrator|airlinemanager'])) {
                    return '<a data-id="' . $airlines->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="airlines/edit/' . $airlines->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ' .
                        '<a href="airlines/destroy/' . $airlines->id . '" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>';
                } else {
                    return '<a data-id="' . $airlines->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="airlines/edit/' . $airlines->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ';
                }
            })
            ->make(true);
    }

}
