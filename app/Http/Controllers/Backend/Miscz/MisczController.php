<?php

namespace App\Http\Controllers\Backend\Miscz;

use App\Models\Auth\User;
use App\Models\Employee\Employee;
use App\Models\Employee\Miscz;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Collection;

class MisczController extends Controller
{
    public function index()
    {
        $data['emp_no'] = Employee::select(DB::raw("CONCAT(name,'(',emp_no,') ','&nbsp;',mobile,' ', '&nbsp;&nbsp; DOB: ',dob,' ','&nbsp;&nbsp; Address: ',address,' ') AS name"), 'emp_no')->pluck('name', 'emp_no');

        return view('backend.misc.index', $data);
    }

    function fetch_data(Request $request)
    {

        if ($request->ajax()) {
            $data = Miscz::where('emp_no', $request->emp_no)->orderBy('id', 'desc')->paginate(6);
            echo json_encode($data);
        }
    }

    function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            $misc = Miscz::create($request->all());
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
            $misc = Miscz::where('id', $request->id)->update($data);
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
            Miscz::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function create()
    {
        $data['emp_no'] = Employee::select(DB::raw("CONCAT(name,'(',emp_no,') ',mobile) AS name"), 'emp_no')->pluck('name', 'emp_no');
        return view('backend.misc.create', $data);
    }


    public function show($id)
    {
        $data['misc'] = Miscz::findOrFail($id);
        $data['created_by'] = User::select('first_name', 'last_name')->where('id', $data['misc']->created_by)->get();
        $data['updated_by'] = User::select('first_name', 'last_name')->where('id', $data['misc']->updated_by)->get();
        return view('backend.misc.ajaxshow', $data);
    }

    public function showed($id)
    {
        $data['misc'] = Miscz::findOrFail($id);
        $data['created_by'] = User::select('first_name', 'last_name')->where('id', $data['misc']->created_by)->first();
        $data['updated_by'] = User::select('first_name', 'last_name')->where('id', $data['misc']->updated_by)->first();
        return view('backend.misc.ajaxshowed', $data);
    }

    public function edit($id)
    {
        $data['misc'] = Miscz::findOrFail($id);
        $data['emp_no'] = Employee::pluck('emp_no', 'emp_no');

        return view('backend.misc.edit', $data);
    }


    public function printMiscz($id)
    {
        $data['miscz'] = Miscz::where('emp_no',$id)->get();
        $data['employee'] = employeeDetails($id);
        $data['position_pluck'] = employeeCareer($id);
        $data['education_pluck'] = employeeEducation($id);
        $data['experience'] = getAllEmployeeExperience($id);
        
        return view('backend.misc.printMiscz', $data);
    }


    public function destroy($id)
    {
        $misc = Miscz::findOrFail($id);
        $misc->delete();

        return back()->withFlashSuccess(__('alerts.backend.records.deleted'));
    }

    public function search($emp_no)
    {
        $data['misc'] = Miscz::where('emp_no', $emp_no)->latest()->paginate(4);
        return view('backend.misc.ajaxshow', $data);
        //Response in JSON
//        return response()->json([
//            'status' => 'success',
//            'misc' => $misc
//        ]);
    }

    public function listMisc($emp_no)
    {
        $misc = Miscz::where('emp_no', $emp_no)->latest();

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
