<?php

namespace App\Http\Controllers\Backend\TravelManagement\Lniata;

use App\Models\TravelManagement\Lniata;
use App\Models\TravelManagement\PCC;
use App\Models\TravelManagement\TravelAgency;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LniatasController extends Controller
{
    public function index()
    {
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ','&nbsp;',ta_phone,' ', '&nbsp;&nbsp; IATA: ',ta_iata_no,' ','&nbsp;&nbsp; Fax: ',ta_fax_no,' ') AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');
        return view('backend.travel.lniata.index', $data);
    }

    function fetch_data(Request $request)
    {

        if ($request->ajax()) {
            if (!empty($request->ta_id) && empty($request->pcc)) {
                $data = Lniata::where('ta_id', $request->ta_id)->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (!empty($request->ta_id) && !empty($request->pcc)) {
                $data = Lniata::where('ta_id', $request->ta_id)->where('pcc', $request->pcc)->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            echo json_encode(['msg' => 'some error encountered']);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $lniata = Lniata::create($request->all());
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            if (!empty($lniata) > 0) {
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
            $lniata = Lniata::where('id', $request->id)->update($data);
            if (!empty($lniata)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            Lniata::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function showed($id)
    {
        $data['lniata'] = Lniata::findOrFail($id);
        return view('backend.travel.lniata.ajaxshowed', $data);
    }

    public function printLniata(Request $request, $id)
    {
        $data['travelagency'] = travelAgencyDetails($id);
        if (!empty($request->pcc))
            $data['lniata'] = Lniata::where('ta_id', $id)->where('pcc', $request->pcc)->get();
        else
            $data['lniata'] = Lniata::where('ta_id', $id)->get();
        return view('backend.travel.lniata.printLniata', $data);
    }

}
