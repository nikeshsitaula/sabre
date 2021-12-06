<?php

namespace App\Http\Controllers\Backend\Training;

use App\Models\Auth\User;
use App\Models\Employee\Employee;
use App\Models\Employee\Training;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class TrainingsController extends Controller
{
    public function index()
    {
        $data['emp_no'] = Employee::select(DB::raw("CONCAT(name,'(',emp_no,') ','&nbsp;',mobile,' ', '&nbsp;&nbsp; DOB: ',dob,' ','&nbsp;&nbsp; Address: ',address,' ') AS name"), 'emp_no')->pluck('name', 'emp_no');

        return view('backend.training.index', $data);
    }

    function fetch_data(Request $request)
    {

        if($request->ajax())
        {
            $data = Training::where('emp_no', $request->emp_no)->orderBy('id', 'desc')->paginate(6);
            echo json_encode($data);
        }
    }

    function store(Request $request)
    {
        if($request->ajax())
        {
            $request->merge([
                'created_by' => auth()->user()->id
            ]);
            $training= Training::create($request->all());
            if(!empty($training) > 0)
            {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Inserted
            </div>';
            }
        }
    }

    function update(Request $request)
    {
        if($request->ajax())
        {
            $data = array(
                $request->column_name       =>  $request->column_value,
                'updated_by' => auth()->user()->id
            );
            $training = Training::where('id', $request->id)->update($data);
            if(!empty($training)){
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if($request->ajax())
        {
            Training::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function create()
    {
        $data['emp_no'] = Employee::select(DB::raw("CONCAT(name,'(',emp_no,') ',mobile) AS name"),'emp_no')->pluck('name','emp_no');

        return view('backend.training.create', $data);
    }

//    public function store(Request $request)
//    {
//        $training = new Training;
//        $request->merge([
//            'created_by'=> auth()->user()->id
//        ]);
//        $training->create($request->all());
//        return back()->withFlashSuccess(__('alerts.backend.records.created'));
//    }

    public function show($id)
    {
        $data['training'] = Training::findOrFail($id);
        return view('backend.training.ajaxshow', $data);
    }

    public function showed($id)
    {
        $data['training'] = Training::findOrFail($id);
        $data['created_by'] = User::select('first_name','last_name')->where('id', $data['training']->created_by)->first();
        $data['updated_by'] = User::select('first_name','last_name')->where('id', $data['training']->updated_by)->first();
        return view('backend.training.ajaxshowed', $data);
    }

    public function edit($id)
    {
        $data['training'] = Training::findOrFail($id);
        $data['emp_no'] = Employee::pluck('emp_no','emp_no');

        return view('backend.training.edit', $data);
    }


    public function printTraining($id)
    {
        $data['training'] = Training::where('emp_no',$id)->get();
        $data['employee'] = employeeDetails($id);
        $data['position_pluck'] = employeeCareer($id);
        $data['education_pluck'] = employeeEducation($id);
        $data['experience'] = getAllEmployeeExperience($id);

        return view('backend.training.printTraining', $data);
    }

//    public function update(Request $request, $id)
//    {
//        $training = Training::findOrFail($id);
//        $request->merge([
//            'updated_by'=>auth()->user()->id
//        ]);
//        $training->update($request->all());
//        return back()->withFlashSuccess(__('alerts.backend.records.updated'));
//    }

    public function destroy($id)
    {
        $training = Training::findOrFail($id);
        $training->delete();

        return back()->withFlashSuccess(__('alerts.backend.records.deleted'));
    }

    public function search($emp_no)
    {
        $data['training'] = Training::where('emp_no', $emp_no)->get();
        return view('backend.training.ajaxshow', $data);
    }

    public function listTrainings()
    {
        $training = Training::latest();
        return Datatables::of($training)
            ->addColumn('created_by', function ($training) {
                $created_by = '';
                if (!empty($training->created_by)) {
                    try {
                        $created_by = User::select('first_name','last_name')->where('id', $training->created_by)->first();
                        return $created_by->name;
                    } catch (\Exception $e) {

                    }
                }
                return $created_by;
            })
            ->addColumn('action', function ($training) {
                if (auth()->user()->hasanyRole(['administrator'])) {
                    return '<a data-id="' . $training->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="training/edit/' . $training->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ' .
                        '<a href="training/destroy/' . $training->id . '" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>';
                }else{
                    return '<a data-id="' . $training->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="training/edit/' . $training->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ';
                }})
            ->make(true);
    }
}
