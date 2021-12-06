<?php

namespace App\Http\Controllers\Backend\TravelManagement\Miscellaneous;

use App\Models\TravelManagement\TravelMiscz;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Models\TravelManagement\PCC;
use DB;
use App\Models\Auth\User;
use App\Models\TravelManagement\TravelAgency;

class misczController extends Controller
{
    public function index()
    {
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ','&nbsp;',ta_phone,' ', '&nbsp;&nbsp; IATA: ',ta_iata_no,' ','&nbsp;&nbsp; Fax: ',ta_fax_no,' ') AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');

        return view('backend.travel.misc.index', $data);
    }

    function fetch_data(Request $request)
    {

        if ($request->ajax()) {
            $data = TravelMiscz::where('ta_id', $request->ta_id)->orderBy('id', 'desc')->paginate(6);
            echo json_encode($data);
        }
    }

    function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            $misc = TravelMiscz::create($request->all());
            if (!empty($misc) > 0) {
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
            $misc = TravelMiscz::where('id', $request->id)->update($data);
            if (!empty($misc)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            TravelMiscz::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

//    public function create()
//    {
//        $data['ta_id'] = Employee::select(DB::raw("CONCAT(name,'(',ta_id,') ',mobile) AS name"), 'ta_id')->pluck('name', 'ta_id');
//        return view('backend.travel.misc.create', $data);
//    }


//    public function show($id)
//    {
//        $data['misc'] = TravelMiscz::findOrFail($id);
//        $data['created_by'] = User::select('first_name', 'last_name')->where('id', $data['misc']->created_by)->get();
//        $data['updated_by'] = User::select('first_name', 'last_name')->where('id', $data['misc']->updated_by)->get();
//        return view('backend.misc.ajaxshow', $data);
//    }

    public function showed($id)
    {
        $data['misc'] = TravelMiscz::findOrFail($id);
        $data['created_by'] = User::select('first_name', 'last_name')->where('id', $data['misc']->created_by)->first();
        $data['updated_by'] = User::select('first_name', 'last_name')->where('id', $data['misc']->updated_by)->first();
        return view('backend.travel.misc.ajaxshowed', $data);
    }

//    public function edit($id)
//    {
//        $data['misc'] = TravelMiscz::findOrFail($id);
//        $data['ta_id'] = Employee::pluck('ta_id', 'ta_id');
//
//        return view('backend.travel.misc.edit', $data);
//    }


    public function printMiscz($id)
    {
        $data['travelagency'] = travelAgencyDetails($id);
        $data['miscz'] = TravelMiscz::where('ta_id',$id)->get();
//        $data['miscz'] = employeeDetails($id);
//        $data['position_pluck'] = employeeCareer($id);
//        $data['education_pluck'] = employeeEducation($id);
//        $data['experience'] = getAllEmployeeExperience($id);

        return view('backend.travel.misc.printMisc', $data);
    }


    public function destroy($id)
    {
        $misc = TravelMiscz::findOrFail($id);
        $misc->delete();

        return back()->withFlashSuccess(__('alerts.backend.records.deleted'));
    }

    public function search($ta_id)
    {
        $data['misc'] = TravelMiscz::where('ta_id', $ta_id)->latest()->paginate(4);
        return view('backend.misc.ajaxshow', $data);
        //Response in JSON
//        return response()->json([
//            'status' => 'success',
//            'misc' => $misc
//        ]);
    }

    public function listMisc($ta_id)
    {
        $misc = TravelMiscz::where('ta_id', $ta_id)->latest();

        return Datatables::of($misc)
            ->addColumn('action', function ($misc) {
                if (auth()->user()->hasanyRole(['administrator'])) {
                    return '<a data-id="' . $misc->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="misc/edit/' . $misc->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ' .
                        '<a href="misc/destroy/' . $misc->id . '" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>';
                } else {
                    return '<a data-id="' . $misc->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="misc/edit/' . $misc->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ';
                }
            })
            ->make(true);
    }

}
