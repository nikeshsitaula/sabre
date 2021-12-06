<?php

namespace App\Http\Controllers\Backend\Employee;

use App\Exports\EmployeesExport;
use App\Models\Employee\Career;
use App\Models\Employee\Document;
use App\Models\Employee\DocumentImage;
use App\Models\Employee\Education;
use App\Models\Employee\Employee;
use App\Models\Employee\Experience;
use App\Models\Employee\Miscz;
use App\Models\Employee\Training;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;
use DB;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        return view('backend.employee.index');
    }

    public function create()
    {
        $data['emp_no'] = Employee::select(DB::raw("CONCAT(name,'(',emp_no,') ','&nbsp;',mobile,' ', '&nbsp;&nbsp; DOB: ',dob,' ','&nbsp;&nbsp; Address: ',address,' ') AS name"), 'emp_no')->pluck('name', 'emp_no');

        return view('backend.employee.create');
    }

    public function store(Request $request)
    {
        $employee = new Employee;
        $request->merge([
            'created_by' => auth()->user()->id
        ]);
        $employee->create($request->all());
        return back()->withFlashSuccess(__('alerts.backend.records.created'));
    }

    public function show($id)
    {
        $data['employee'] = Employee::findOrFail($id);

        return view('backend.employee.ajaxshow', $data);
    }

    public function edit($id)
    {
        $data['employee'] = Employee::findOrFail($id);

        return view('backend.employee.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);
        $request->merge([
            'updated_by' => auth()->user()->id
        ]);
        $employee->update($request->all());
        return back()->withFlashSuccess(__('alerts.backend.records.updated'));
    }

    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $career = Career::where('emp_no',$employee->emp_no)->delete();
        $experience = Experience::where('emp_no',$employee->emp_no)->delete();
        $education = Education::where('emp_no',$employee->emp_no)->delete();
        $training = Training::where('emp_no',$employee->emp_no)->delete();
        $misc = Miscz::where('emp_no',$employee->emp_no)->delete();
        $document = Document::where('emp_no',$employee->emp_no)->delete();
        $images = DocumentImage::where('emp_no', $employee->emp_no)->get();
        foreach ($images as $image) {
            Storage::delete('public/document_images/' . $image->name);
            $image->delete();
        }
        $employee->delete();

        return back()->withFlashSuccess(__('alerts.backend.records.deleted'));
    }

//    public function uploadExcelForm()
//    {
//        return view('backend.employee.uploadExcel');
//    }

    public function checkEmployeeExistence(Request $request)
    {
        //search employee with emp no if it exist or not
        $exist = Employee::where('emp_no', $request->emp_no)->first();
        if ($exist) {
            $msg = false;
        } else {
            $msg = true;
        }
        //returns response as json data ( can be checked in console for this response which is displayed in blade using console.log(data.message) in create.blade.php
        return response()->json([
            'status' => 'success',
            'message' => $msg
        ]);
    }

//    public function downloadExcel()
//    {
//        return Excel::download(new EmployeesExport, 'employee.xlsx');
//    }

    public function listEmployees()
    {
        $employee = Employee::get();

        return Datatables::of($employee)
            ->addColumn('action', function ($employee) {
                if (auth()->user()->hasanyRole(['administrator|employeemanager'])) {
                    return '<a data-id="' . $employee->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="employee/edit/' . $employee->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ' .
                        '<a href="employee/destroy/' . $employee->id . '" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>';
                } else {
                    return '<a data-id="' . $employee->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="employee/edit/' . $employee->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ';
                }
            })
            ->make(true);
    }
}
