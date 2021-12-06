<?php

namespace App\Http\Controllers\Backend\TravelManagement\AccountManager;

use App\Models\TravelManagement\AccountManager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TravelManagement\PCC;
use App\Models\TravelManagement\TravelAgency;
use DB;


class AccountManagerConroller extends Controller
{
    public function index()
    {
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ','&nbsp;',ta_phone,' ', '&nbsp;&nbsp; IATA: ',ta_iata_no,' ','&nbsp;&nbsp; Fax: ',ta_fax_no,' ') AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');

        return view('backend.travel.accountmanager.index', $data);

    }

    function fetch_data(Request $request)
    {

        if ($request->ajax()) {
            $data = AccountManager::where('ta_id', $request->ta_id)->orderBy('id', 'desc')->paginate(6);
            echo json_encode($data);
        }
    }

    function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            if ($request->has('accountmanager')){
                $travelagency = TravelAgency::where('ta_id', $request->ta_id)->first();
                $travelagency->accountmanager = $request->accountmanager;
                $travelagency->update();
            }


            $accountmanager = AccountManager::create($request->all());
            if (!empty($accountmanager) > 0) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Inserted
            </div>';
            }
        }
    }

    function update(Request $request)
    {
        if ($request->ajax()) {
            $data = array(
                $request->column_name => $request->column_value,
                'updated_by' => auth()->user()->id
            );

            $accountmanager = AccountManager::where('id', $request->id)->update($data);
            if (!empty($accountmanager)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }

            if ($request->has('column_name')) {
                $ta_id=AccountManager::where('id', $request->id)->pluck('ta_id')[0];
                $accountmanager = TravelAgency::where('ta_id', $ta_id)->first();
                if ($request->has('accountmanager'))
                    $accountmanager->accountmanager = $request->accountmanager;
                $accountmanager->update();
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            AccountManager::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }


    public
    function create()
    {
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(name,'(',ta_id,') ',mobile) AS name"), 'ta_id')->pluck('name', 'ta_id');

        return view('backend.travel.accountmanager.create', $data);
    }


    public
    function showed($id)
    {
        $data['accountmanager'] = AccountManager::findOrFail($id);
        return view('backend.travel.accountmanager.ajaxshowed', $data);
    }

    public function edit($id)
    {
        $data['accountmanager'] = AccountManager::findOrFail($id);
        $data['ta_id'] = TravelAgency::pluck('ta_id', 'ta_id');

        return view('backend.travel.accountmanager.edit', $data);
    }

    public function printAccountManager($id)
    {
        $data['travelagency'] = travelAgencyDetails($id);
        $data['accountmanager'] = AccountManager::where('ta_id',$id)->get();
        $data['travelagency_pluck'] = travelAccountManager($id);
        return view('backend.travel.accountmanager.printAccountManager', $data);
    }


    public
    function destroy($id)
    {
        $accountmanager = AccountManager::findOrFail($id);
        $accountmanager->delete();

        return back()->withFlashSuccess(__('alerts.backend.records.deleted'));
    }

    public
    function search($ta_id)
    {
        $data['accountmanager'] = AccountManager::where('ta_id', $ta_id)->latest()->paginate(4);
        return view('backend.travel.accountmanager.ajaxshow', $data);
    }

    public
    function listAccountManager($emp_no)
    {

        $accountmanager = AccountManager::where('ta_id', $emp_no)->latest();

        return Datatables::of($accountmanager)
            ->addColumn('action', function ($accountmanager) {
                if (auth()->user()->hasanyRole(['administrator'])) {
                    return '<a data-id="' . $accountmanager->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="accountmanager/edit/' . $accountmanager->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ' .
                        '<a href="accountmanager/destroy/' . $accountmanager->id . '" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>';
                } else {
                    return '<a data-id="' . $accountmanager->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="accountmanager/edit/' . $accountmanager->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ';
                }
            })
            ->make(true);
    }
}
