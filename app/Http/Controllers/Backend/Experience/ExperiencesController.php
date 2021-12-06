<?php

namespace App\Http\Controllers\Backend\Experience;

use App\Models\Auth\User;
use App\Models\Employee\Career;
use App\Models\Employee\Education;
use App\Models\Employee\Employee;
use App\Models\Employee\Experience;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Collection;


class ExperiencesController extends Controller
{
    public function index()
    {
        $data['emp_no'] = Employee::select(DB::raw("CONCAT(name,'(',emp_no,') ','&nbsp;',mobile,' ', '&nbsp;&nbsp; DOB: ',dob,' ','&nbsp;&nbsp; Address: ',address,' ') AS name"), 'emp_no')->pluck('name', 'emp_no');

        return view('backend.experience.index', $data);

    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
                $data = Experience::where('emp_no', $request->emp_no)->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
        }
    }

    function store(Request $request)
    {
        if ($request->ajax()) {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            $experience = Experience::create($request->all());
            if (!empty($experience) > 0) {
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
            $experience = Experience::where('id', $request->id)->update($data);
            if (!empty($experience)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            Experience::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function create()
    {
        $data['emp_no'] = Employee::select(DB::raw("CONCAT(name,'(',emp_no,') ',mobile) AS name"), 'emp_no')->pluck('name', 'emp_no');
        return view('backend.experience.create', $data);
    }


    public function show($id)
    {
        $data['experience'] = Experience::findOrFail($id);
        $data['created_by'] = User::select('first_name', 'last_name')->where('id', $data['experience']->created_by)->get();
        $data['updated_by'] = User::select('first_name', 'last_name')->where('id', $data['experience']->updated_by)->get();
        return view('backend.experience.ajaxshow', $data);
    }

    public function showed($id)
    {
        $data['experience'] = Experience::findOrFail($id);
        $data['created_by'] = User::select('first_name', 'last_name')->where('id', $data['experience']->created_by)->first();
        $data['updated_by'] = User::select('first_name', 'last_name')->where('id', $data['experience']->updated_by)->first();
        return view('backend.experience.ajaxshowed', $data);
    }

    public function edit($id)
    {
        $data['experience'] = Experience::findOrFail($id);
        $data['emp_no'] = Employee::pluck('emp_no', 'emp_no');

        return view('backend.experience.edit', $data);
    }

    public function printExperience($id)
    {
        $data['employee'] = employeeDetails($id);
        $data['position_pluck'] = employeeCareer($id);
        $data['education_pluck'] = employeeEducation($id);
        $data['experience'] = getAllEmployeeExperience($id);
        return view('backend.experience.printExperience', $data);
    }

    public function destroy($id)
    {
        $experience = Experience::findOrFail($id);
        $experience->delete();

        return back()->withFlashSuccess(__('alerts.backend.records.deleted'));
    }

    public function search($emp_no)
    {
        $data['experience'] = Experience::where('emp_no', $emp_no)->latest()->paginate(4);
        return view('backend.experience.ajaxshow', $data);

    }

    public function listExperiences($emp_no)
    {
        $experience = Experience::where('emp_no', $emp_no)->latest();

        return Datatables::of($experience)
            ->addColumn('action', function ($experience) {
                if (auth()->user()->hasanyRole(['administrator'])) {
                    return '<a data-id="' . $experience->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="experience/edit/' . $experience->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ' .
                        '<a href="experience/destroy/' . $experience->id . '" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>';
                } else {
                    return '<a data-id="' . $experience->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="experience/edit/' . $experience->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ';
                }
            })
            ->make(true);
    }
}
