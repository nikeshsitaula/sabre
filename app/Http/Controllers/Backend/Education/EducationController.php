<?php

namespace App\Http\Controllers\Backend\Education;

use App\Models\Auth\User;
use App\Models\Employee\Education;
use App\Models\Employee\Employee;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class EducationController extends Controller
{
    public function index()
    {
        $data['emp_no'] = Employee::select(DB::raw("CONCAT(name,'(',emp_no,') ','&nbsp;',mobile,' ', '&nbsp;&nbsp; DOB: ',dob,' ','&nbsp;&nbsp; Address: ',address,' ') AS name"), 'emp_no')->pluck('name', 'emp_no');

        return view('backend.education.index', $data);
    }

    function fetch_data(Request $request)
    {

        if ($request->ajax()) {
            $data = Education::where('emp_no', $request->emp_no)->orderBy('id', 'desc')->paginate(6);
            echo json_encode($data);
        }
    }

    function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            $education = Education::create($request->all());
            if (!empty($education) > 0) {
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
            $education = Education::where('id', $request->id)->update($data);
            if (!empty($education)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            Education::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

//    public function create()
//    {
//        $data['emp_no'] = Employee::select(DB::raw("CONCAT(name,'(',emp_no,') ',mobile) AS name"), 'emp_no')->pluck('name', 'emp_no');
//
//        return view('backend.education.create', $data);
//    }

//    public function store(Request $request)
//    {
//        $education = new Education;
//        $request->merge([
//            'created_by' => auth()->user()->id
//        ]);
//        $education->create($request->all());
//        return back()->withFlashSuccess(__('alerts.backend.records.created'));
//    }

    public function show($id)
    {
        $data['education'] = Education::findOrFail($id);
        $data['created_by'] = User::select('first_name', 'last_name')->where('id', $data['education']->created_by)->get();
        $data['updated_by'] = User::select('first_name', 'last_name')->where('id', $data['education']->updated_by)->get();
        return view('backend.education.ajaxshow', $data);
    }

    public function showed($id)
    {
        $data['education'] = Education::findOrFail($id);
        $data['created_by'] = User::select('first_name', 'last_name')->where('id', $data['education']->created_by)->first();
        $data['updated_by'] = User::select('first_name', 'last_name')->where('id', $data['education']->updated_by)->first();
        return view('backend.education.ajaxshowed', $data);
    }

//    public function edit($id)
//    {
//        $data['education'] = Education::findOrFail($id);
//        $data['emp_no'] = Employee::pluck('emp_no', 'emp_no');
//
//        return view('backend.education.edit', $data);
//    }

    public function printEducation($id)
    {
        $data['education'] = Education::where('emp_no',$id)->get();
        $data['employee'] = employeeDetails($id);
        $data['position_pluck'] = employeeCareer($id);
        $data['education_pluck'] = employeeEducation($id);
        $data['experience'] = getAllEmployeeExperience($id);
        return view('backend.education.printEducation', $data);
    }

//    public function update(Request $request, $id)
//    {
//        $education = Education::findOrFail($id);
//        $request->merge([
//            'updated_by' => auth()->user()->id
//        ]);
//        $education->update($request->all());
//        return back()->withFlashSuccess(__('alerts.backend.records.updated'));
//    }

    public function destroy($id)
    {
        $education = Education::findOrFail($id);
        $education->delete();

        return back()->withFlashSuccess(__('alerts.backend.records.deleted'));
    }

//    public function search($emp_no)
//    {
//        $data['education'] = Education::where('emp_no', $emp_no)->get();
//        return view('backend.education.ajaxshow', $data);
//    }

    public function listEducations()
    {
        $education = Education::latest();
        return Datatables::of($education)
            ->addColumn('created_by', function ($education) {
                $created_by = '';
                if (!empty($education->created_by)) {
                    try {
                        $created_by = User::select('first_name', 'last_name')->where('id', $education->created_by)->first();
                        return $created_by->name;
                    } catch (\Exception $e) {

                    }
                }
                return $created_by;
            })
            ->addColumn('action', function ($education) {
                if (auth()->user()->hasanyRole(['administrator'])) {
                    return '<a data-id="' . $education->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="education/edit/' . $education->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ' .
                        '<a href="education/destroy/' . $education->id . '" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>';
                } else {
                    return '<a data-id="' . $education->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="education/edit/' . $education->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ';
                }
            })
            ->make(true);
    }
}
