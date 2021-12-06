<?php

namespace App\Http\Controllers\Backend\AccountManagement;

use App\Http\Controllers\Controller;
use App\Models\AccountManagement\AccountManagement;
use App\Models\AccountManagement\AgencyAgreement;
use App\Models\TravelManagement\TravelAgency;
use Illuminate\Http\Request;
use DB;

class AgencyAgreementsController extends Controller
{
    public function index()
    {
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ','&nbsp;',ta_phone,' ', '&nbsp;&nbsp; IATA: ',ta_iata_no,' ','&nbsp;&nbsp; Fax: ',ta_fax_no,' ') AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');

        return view('backend.accountmanagement.agencyagreement.index', $data);
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $data = AgencyAgreement::where('ta_id', $request->ta_id)->orderBy('id', 'desc')->paginate(6);
            echo json_encode($data);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            $agencyagreement = AgencyAgreement::create($request->all());
            if (!empty($agencyagreement) > 0) {
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
            $agencyagreement = AgencyAgreement::where('id', $request->id)->update($data);
            if (!empty($agencyagreement)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            AgencyAgreement::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function showed($id)
    {
        $data['agencyagreement'] = AgencyAgreement::findOrFail($id);
        return view('backend.accountmanagement.agencyagreement.ajaxshowed', $data);
    }

    public function printagencyagreement($id)
    {
        $data['travelagency'] = travelAgencyDetails($id);
        $data['agencyagreement'] = AgencyAgreement::where('ta_id', $id)->get();
        return view('backend.accountmanagement.agencyagreement.printAgencyAgreement', $data);
    }
}
