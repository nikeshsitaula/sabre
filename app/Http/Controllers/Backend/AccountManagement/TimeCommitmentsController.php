<?php

namespace App\Http\Controllers\Backend\AccountManagement;

use App\Http\Controllers\Controller;
use App\Models\AccountManagement\AccountManagement;
use App\Models\AccountManagement\TimeCommitment;
use App\Models\TravelManagement\TravelAgency;
use Illuminate\Http\Request;
use DB;

class TimeCommitmentsController extends Controller
{
    public function index()
    {
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ','&nbsp;',ta_phone,' ', '&nbsp;&nbsp; IATA: ',ta_iata_no,' ','&nbsp;&nbsp; Fax: ',ta_fax_no,' ') AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');

        return view('backend.accountmanagement.timecommitment.index', $data);
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $data = TimeCommitment::where('ta_id', $request->ta_id)->orderBy('id', 'desc')->paginate(6);
            echo json_encode($data);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            $timecommitment = TimeCommitment::create($request->all());
            if (!empty($timecommitment) > 0) {
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
            $timecommitment = TimeCommitment::where('id', $request->id)->update($data);
            if (!empty($timecommitment)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            TimeCommitment::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function showed($id)
    {
        $data['timecommitment'] = TimeCommitment::findOrFail($id);
        return view('backend.accountmanagement.timecommitment.ajaxshowed', $data);
    }

    public function printtimecommitment($id)
    {
        $data['travelagency'] = travelAgencyDetails($id);
        $data['timecommitment'] = TimeCommitment::where('ta_id', $id)->get();
        return view('backend.accountmanagement.timecommitment.printTimeCommitment', $data);
    }
}
