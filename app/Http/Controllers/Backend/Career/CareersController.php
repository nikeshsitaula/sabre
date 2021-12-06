<?php

namespace App\Http\Controllers\Backend\Career;

use App\Models\Auth\User;
use App\Models\Employee\Employee;
use App\Models\Employee\Career;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Collection;


class CareersController extends Controller
{
    public function index()
    {
        $data['emp_no'] = Employee::select(DB::raw("CONCAT(name,'(',emp_no,') ','&nbsp;',mobile,' ', '&nbsp;&nbsp; DOB: ',dob,' ','&nbsp;&nbsp; Address: ',address,' ') AS name"), 'emp_no')->pluck('name', 'emp_no');

        return view('backend.career.index', $data);

    }

    function fetch_data(Request $request)
    {

        if ($request->ajax()) {
            $data = Career::where('emp_no', $request->emp_no)->orderBy('id', 'desc')->paginate(6);
            echo json_encode($data);
        }
    }

    function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            if ($request->has('position') || $request->has('level')) {
                $employee = Employee::where('emp_no', $request->emp_no)->first();
                $employee->position = $request->position;
                $employee->level = $request->level;
                $employee->update();
            }


            $career = Career::create($request->all());
            if (!empty($career) > 0) {
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

            $career = Career::where('id', $request->id)->update($data);
            if (!empty($career)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
            $emp_no = Career::where('id', $request->id)->pluck('emp_no')[0];
            $levelval = Career::where('emp_no', $emp_no)->latest()->pluck('level')[0];
            $positionval = Career::where('emp_no', $emp_no)->latest()->pluck('position')[0];
            if ($request->has('column_name')) {
                $emp_no = Career::where('id', $request->id)->pluck('emp_no')[0];
                $employee = Employee::where('emp_no', $emp_no)->first();
                if ($request->has('position'))
                    $employee->position = $positionval;
                if ($request->has('level'))
                    $employee->level = $levelval;
                $employee->update();
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;
            $emp_no = Career::select('emp_no')->where('id', $id)->pluck('emp_no')->sum();
//            dd($emp_no);
            Career::where('id', $request->id)->delete();
            $position = Career::select('position')->where('emp_no', $emp_no)->pluck('position')->last();
            $level = Career::select('level')->where('emp_no', $emp_no)->pluck('level')->last();


            if (!empty($position) && !empty($level)) {
                $updateemployee = array(
                    'position' => $position,
                    'level' => $level,
                    'updated_by' => auth()->user()->id
                );
            } else {
                $updateemployee = array(
                    'position' => 0,
                    'level' => 0,
                    'updated_by' => auth()->user()->id
                );
            }
            //update values in employee
            $updatefinal = Employee::where('emp_no', $emp_no)->update($updateemployee);

            if (!empty($updatefinal)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
            }
        }
    }


    public
    function create()
    {
        $data['emp_no'] = Employee::select(DB::raw("CONCAT(name,'(',emp_no,') ',mobile) AS name"), 'emp_no')->pluck('name', 'emp_no');

        return view('backend.career.create', $data);
    }

//    public function store(Request $request)
//    {
//        $career = new Career;
//        $request->merge([
//            'created_by' => auth()->user()->id
//        ]);
//
//        $career->create($request->all());
//
//        return response()->json([
//            'status' => 'success',
//            'request data' => $request->all()
//        ]);
//    }

    public
    function show($id)
    {
        $data['career'] = Career::findOrFail($id);
        $data['created_by'] = User::select('first_name', 'last_name')->where('id', $data['career']->created_by)->get();
        $data['updated_by'] = User::select('first_name', 'last_name')->where('id', $data['career']->updated_by)->get();
        return view('backend.career.ajaxshow', $data);
    }

    public
    function showed($id)
    {
        $data['career'] = Career::findOrFail($id);
        $data['created_by'] = User::select('first_name', 'last_name')->where('id', $data['career']->created_by)->first();
        $data['updated_by'] = User::select('first_name', 'last_name')->where('id', $data['career']->updated_by)->first();
        return view('backend.career.ajaxshowed', $data);
    }

    public function edit($id)
    {
        $data['career'] = Career::findOrFail($id);
        $data['emp_no'] = Employee::pluck('emp_no', 'emp_no');

        return view('backend.career.edit', $data);
    }

    public function printCareer($id)
    {
        $data['career'] = Career::where('emp_no', $id)->get();
        $data['employee'] = employeeDetails($id);
        $data['position_pluck'] = employeeCareer($id);
        $data['education_pluck'] = employeeEducation($id);
        $data['experience'] = getAllEmployeeExperience($id);
        return view('backend.career.printCareer', $data);
    }

//    public function update(Request $request, $id)
//    {
//        $career = Career::findOrFail($id);
//        $request->merge([
//            'updated_by' => auth()->user()->id
//        ]);
//        $career->update($request->all());
//        return back()->withFlashSuccess(__('alerts.backend.records.updated'));
//    }

    public
    function destroy($id)
    {
        $career = Career::findOrFail($id);
        $career->delete();

        return back()->withFlashSuccess(__('alerts.backend.records.deleted'));
    }

    public
    function search($emp_no)
    {
        $data['career'] = Career::where('emp_no', $emp_no)->latest()->paginate(4);
        return view('backend.career.ajaxshow', $data);
    }

    public
    function listCareers($emp_no)
    {

        $career = Career::where('emp_no', $emp_no)->latest();

        return Datatables::of($career)
            ->addColumn('action', function ($career) {
                if (auth()->user()->hasanyRole(['administrator'])) {
                    return '<a data-id="' . $career->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="career/edit/' . $career->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ' .
                        '<a href="career/destroy/' . $career->id . '" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>';
                } else {
                    return '<a data-id="' . $career->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="career/edit/' . $career->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ';
                }
            })
            ->make(true);
    }
}
