<?php

namespace App\Http\Controllers\Backend\Document;

use App\Models\Auth\User;
use App\Models\Employee\Document;
use App\Models\Employee\DocumentImage;
use App\Models\Employee\Employee;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class DocumentsController extends Controller
{
    public function index()
    {
        $data['emp_no'] = Employee::select(DB::raw("CONCAT(name,'(',emp_no,') ',mobile) AS name"), 'emp_no')->pluck('name', 'emp_no');

        return view('backend.document.index', $data);
    }

    public function create()
    {
        $data['emp_no'] = Employee::select(DB::raw("CONCAT(name,'(',emp_no,') ',mobile) AS name"), 'emp_no')->pluck('name', 'emp_no');

        return view('backend.document.create', $data);
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'document' => 'required'
        ]);

        $document = new Document;
        $request->merge([
            'created_by' => auth()->user()->id
        ]);

        //stores document info in the document table except images[]
        $data = $request->except('document');
        $doc = $document->create($data);
        //stores images[] of the document
        if ($request->hasFile('document')) {
            foreach ($request->document as $photo) {
                //stores passport to the Storage
                $extension = $photo->getClientOriginalExtension();
                //file name to store
                $fileNameToStore = time() . rand(0, 3) . '.' . $extension;
                //upload image
                $path = $photo->storeAs('public/document_images', $fileNameToStore);

                //stores document to the DocumentImage DB
                DocumentImage::create([
                    'emp_no' => $doc->emp_no,
                    'document_id' => $doc->id,
                    'name' => $fileNameToStore
                ]);
            }
        }

        return back()->withFlashSuccess(__('alerts.backend.records.created'));
    }

//    public function show($id)
//    {
//        $data['document'] = Document::findOrFail($id);
//        return view('backend.document.ajaxshow', $data);
//    }

    public function showimage($emp_id)
    {
        $data['document'] = Document::where('emp_no', $emp_id)->get();
        $emp = Document::select('id')->where('emp_no', $emp_id)->first();

        if ($emp) {
            $data['images'] = DocumentImage::where('document_id', $emp_id)->get();
        }

        return view('backend.document.ajaxshow', $data);
    }

    public function showed($id)
    {
        $data['document'] = Document::where('id',$id)->first();
        $data['images'] = DocumentImage::where('document_id', $id)->get();
        $data['created_by'] = User::select('first_name', 'last_name')->where('id', $data['document']->created_by)->first();
        $data['updated_by'] = User::select('first_name', 'last_name')->where('id', $data['document']->updated_by)->first();
        return view('backend.document.ajaxshowed', $data);
    }

    public function edit($id)
    {
        $data['document'] = Document::findOrFail($id);
        $data['emp_no'] = Employee::pluck('emp_no', 'emp_no');
        $data['images'] = DocumentImage::where('document_id', $id)->get();

        return view('backend.document.edit', $data);
    }

    public function update(Request $request, $id)
    {
        $document = Document::findOrFail($id);
        $request->merge([
            'updated_by' => auth()->user()->id
        ]);
        $document->update($request->all());
        return back()->withFlashSuccess(__('alerts.backend.records.updated'));
    }

    public function destroy($id)
    {
        $document = Document::findOrFail($id);
        $images = DocumentImage::where('document_id', $id)->get();
        foreach ($images as $image) {
            Storage::delete('public/document_images/' . $image->name);
            $image->delete();
        }
        $document->delete();

        return back()->withFlashSuccess(__('alerts.backend.records.deleted'));
    }

    public function addImage(Request $request, $id)
    {
        if ($request->hasFile('document')) {
            foreach ($request->document as $photo) {
                //stores passport to the Storage
                $extension = $photo->getClientOriginalExtension();
                //file name to store
                $fileNameToStore = time() . rand(0, 3) . '.' . $extension;
                //upload image
                $path = $photo->storeAs('public/document_images', $fileNameToStore);

                //stores document to the DocumentImage DB
                DocumentImage::create([
                    'emp_no' => $request->emp_no,
                    'document_id' => $id,
                    'name' => $fileNameToStore
                ]);
            }

            return back()->withFlashSuccess(__('alerts.backend.records.imageUploaded'));

        }

        return back()->withFlashSuccess(__('alerts.backend.records.error'));

    }

    public function deleteImage($id)
    {
        $image = DocumentImage::findOrFail($id);
        Storage::delete('public/document_images/' . $image->name);
        $image->delete();
        return back()->withFlashSuccess(__('alerts.backend.records.deleted'));
    }

    //download PDF
    public function printDocument($id)
    {
        $data['document'] = Document::where('emp_no', $id)->get();
        $data['employee'] = employeeDetails($id);
        $data['position_pluck'] = employeeCareer($id);
        $data['education_pluck'] = employeeEducation($id);
        $data['experience'] = getAllEmployeeExperience($id);

        return view('backend.document.printDocument',$data);
    }

//    public function search($emp_no)
//    {
//        $data['document'] = Document::where('emp_no', $emp_no)->get();
//        return view('backend.document.ajaxshow', $data);
//    }

    public function listDocuments()
    {
        $document = Document::latest();
        return Datatables::of($document)
            ->addColumn('created_by', function ($document) {
                $created_by = '';
                if (!empty($document->created_by)) {
                    try {
                        $created_by = User::select('first_name', 'last_name')->where('id', $document->created_by)->first();
                        return $created_by->name;
                    } catch (\Exception $e) {

                    }
                }
                return $created_by;
            })
            ->addColumn('action', function ($document) {
                if (auth()->user()->hasanyRole(['administrator|employeemanager'])) {
                    return '<a data-id="' . $document->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="document/edit/' . $document->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ' .
                        '<a href="document/destroy/' . $document->id . '" onclick="return confirm(\'Are you sure?\')" class="btn btn-danger btn-xs"><i class="fas fa-trash-alt"></i></a>';
                } else {
                    return '<a data-id="' . $document->id . '" href="#" data-toggle="modal" id="openShow" class="btn btn-info btn-xs"><i class="fas fa-eye"></i></a> ' .
                        '<a href="document/edit/' . $document->id . '" class="btn btn-primary btn-xs"><i class="fas fa-edit"></i></a> ';
                }
            })
            ->make(true);
    }
}
