<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Employee\Career;
use App\Models\Employee\Document;
use App\Models\Employee\DocumentImage;
use App\Models\Employee\Education;
use App\Models\Employee\Employee;
use App\Models\Employee\Experience;
use App\Models\Employee\Miscz;
use App\Models\Employee\Training;
use DB;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index(Request $request)
    {
        $data['employee'] = null;
        $data['emp_no'] = Employee::select(DB::raw("CONCAT(name,'(',emp_no,') ',mobile) AS name"), 'emp_no')->pluck('name', 'emp_no');
        if (!empty($request->all())) {
            $data['employee'] = employeeDetails($request->emp_no);
            $data['experience'] = Experience::where('emp_no', $request->emp_no)->get();
            $data['career'] = Career::where('emp_no', $request->emp_no)->get();
            $data['education'] = Education::where('emp_no', $request->emp_no)->get();
            $data['training'] = Training::where('emp_no', $request->emp_no)->get();
            $data['miscz'] = Miscz::where('emp_no', $request->emp_no)->get();
            $data['position_pluck'] = Career::select('position')->where('emp_no',$request->emp_no)->pluck('position')->last();
            $data['education_pluck'] = Education::select('qualification')->where('emp_no',$request->emp_no)->pluck('qualification')->last();
            $data['document'] = Document::where('emp_no', $request->emp_no)->get();
            if ($data) {
                $data['images'] = DocumentImage::where('emp_no', $request->emp_no)->get();
            }
            return view('backend.dashboard', $data);
        }

        return view('backend.dashboard', $data);
    }
}
