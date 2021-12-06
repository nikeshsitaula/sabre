<?php

namespace App\Http\Controllers\Backend\TravelManagement\TrainingStaff;


use App\Http\Controllers\Controller;
use App\Models\TravelManagement\Staff;
use App\Models\TravelManagement\TrainingStaff;
use App\Models\TravelManagement\PCC;
use DB;
use App\Models\Auth\User;
use App\Models\TravelManagement\TravelAgency;

use Illuminate\Http\Request;

class TrainingStaffsController extends Controller
{

    public function index()
    {
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ','&nbsp;',ta_phone,' ', '&nbsp;&nbsp; IATA: ',ta_iata_no,' ','&nbsp;&nbsp; Fax: ',ta_fax_no,' ') AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');
//        $data['pcc'] = PCC::select(DB::raw("CONCAT( 'PCC:', br_pcc, '&nbsp;&nbsp;', 'Address: ', br_address, '&nbsp;&nbsp;','Phone: ', br_phone, '&nbsp;&nbsp;', 'Fax: ', br_fax_no,'&nbsp; &nbsp;', 'Email: ', br_email) AS name"), 'br_pcc')->pluck('name', 'br_pcc');
        return view('backend.travel.trainingstaff.index', $data);
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {

            if (!empty($request->ta_id) && empty($request->staff_no) && empty($request->from) && empty($request->to) && empty($request->course)) {
                $data = TrainingStaff::where('ta_id', $request->ta_id)->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (!empty($request->ta_id) && !empty($request->staff_no) && empty($request->from) && empty($request->to) && empty($request->course)) {
                $data = TrainingStaff::where('ta_id', $request->ta_id)->where('staff_no', $request->staff_no)->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (!empty($request->ta_id) && empty($request->staff_no) && !empty($request->from) && !empty($request->to) && empty($request->course)) {
                $data = TrainingStaff::where('ta_id', $request->ta_id)->where(function ($query) use ($request) {
                    $query->where('from', '<=', $request->from)
                        ->where('to', '>=', $request->from);
                })->orWhere(function ($query) use ($request) {
                    $query->where('to', '>=', $request->to)
                        ->where('from', '<=', $request->to);
                })->orWhere(function ($query) use ($request) {
                    $query->where('from', '>=', $request->from)
                        ->where('to', '<=', $request->to);
                })->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (!empty($request->ta_id) && !empty($request->staff_no) && !empty($request->from) && !empty($request->to) && empty($request->course)) {
//                $data = TrainingStaff::where('ta_id', $request->ta_id)->where('staff_no', $request->staff_no)->whereBetween('from', [$request->from, $request->to])->orderBy('id', 'desc')->paginate(6);
                $data = TrainingStaff::where('ta_id', $request->ta_id)->where(function ($query) use ($request) {
                    $query->where('staff_no', $request->staff_no)->where('from', '<=', $request->from)
                        ->where('to', '>=', $request->from);
                })->orWhere(function ($query) use ($request) {
                    $query->where('staff_no', $request->staff_no)->where('to', '>=', $request->to)
                        ->where('from', '<=', $request->to);
                })->orWhere(function ($query) use ($request) {
                    $query->where('staff_no', $request->staff_no)->where('from', '>=', $request->from)
                        ->where('to', '<=', $request->to);
                })->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);

                return json_encode($data);
            }

            if (empty($request->ta_id) && empty($request->staff_no) && !empty($request->from) && !empty($request->to) && empty($request->course)) {
                $data = TrainingStaff::where(function ($query) use ($request) {
                    $query->where('from', '<=', $request->from)
                        ->where('to', '>=', $request->from);
                })->orWhere(function ($query) use ($request) {
                    $query->where('to', '>=', $request->to)
                        ->where('from', '<=', $request->to);
                })->orWhere(function ($query) use ($request) {
                    $query->where('from', '>=', $request->from)
                        ->where('to', '<=', $request->to);
                })->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (empty($request->ta_id) && empty($request->staff_no) && empty($request->from) && empty($request->to) && empty($request->course)) {
                $data = TrainingStaff::orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (empty($request->ta_id) && empty($request->staff_no) && !empty($request->from) && !empty($request->to) && !empty($request->course)) {
                $data = TrainingStaff::where(function ($query) use ($request) {
                    $query->where('from', '<=', $request->from)
                        ->where('to', '>=', $request->from)->where('course', $request->course);
                })->orWhere(function ($query) use ($request) {
                    $query->where('to', '>=', $request->to)
                        ->where('from', '<=', $request->to)->where('course', $request->course);
                })->orWhere(function ($query) use ($request) {
                    $query->where('from', '>=', $request->from)
                        ->where('to', '<=', $request->to)->where('course', $request->course);
                })->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (!empty($request->ta_id) && empty($request->staff_no) && !empty($request->from) && !empty($request->to) && !empty($request->course)) {
                $data = TrainingStaff::where('ta_id', $request->ta_id)->where(function ($query) use ($request) {
                    $query->where('from', '<=', $request->from)
                        ->where('to', '>=', $request->from)->where('course', $request->course);
                })->orWhere(function ($query) use ($request) {
                    $query->where('to', '>=', $request->to)
                        ->where('from', '<=', $request->to)->where('course', $request->course);
                })->orWhere(function ($query) use ($request) {
                    $query->where('from', '>=', $request->from)
                        ->where('to', '<=', $request->to)->where('course', $request->course);
                })->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (!empty($request->ta_id) && !empty($request->staff_no) && !empty($request->from) && !empty($request->to) && !empty($request->course)) {
                $data = TrainingStaff::where('ta_id', $request->ta_id)->where(function ($query) use ($request) {
                    $query->where('from', '<=', $request->from)
                        ->where('to', '>=', $request->from)->where('staff_no', $request->staff_no)->where('course', $request->course);
                })->orWhere(function ($query) use ($request) {
                    $query->where('to', '>=', $request->to)
                        ->where('from', '<=', $request->to)->where('staff_no', $request->staff_no)->where('course', $request->course);
                })->orWhere(function ($query) use ($request) {
                    $query->where('from', '>=', $request->from)
                        ->where('to', '<=', $request->to)->where('staff_no', $request->staff_no)->where('course', $request->course);
                })->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (!empty($request->ta_id) && empty($request->staff_no) && empty($request->from) && empty($request->to) && !empty($request->course)) {
                $data = TrainingStaff::where('ta_id', $request->ta_id)->where('course', $request->course)->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }
            if (!empty($request->ta_id) && !empty($request->staff_no) && empty($request->from) && empty($request->to) && !empty($request->course)) {
                $data = TrainingStaff::where('ta_id', $request->ta_id)->where('course', $request->course)->where('staff_no', $request->staff_no)->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }

            if (empty($request->ta_id) && empty($request->staff_no) && empty($request->from) && empty($request->to) && !empty($request->course)) {
                $data = TrainingStaff::where('course', $request->course)->orderBy('id', 'desc')->paginate(6);
                return json_encode($data);
            }

            echo json_encode(['msg' => 'some error encountered']);
        }

    }

    function filterTrainingStaff(Request $request)
    {
        if (!empty($request->value) && !empty($request->ta_id)) {
            $staff_no = Staff::select(DB::raw("staff_no AS id,CONCAT('Staff No:', staff_no,' ',' ~ ' ,'PCC:', pcc,' ~ ' ,'Name:', name,' ~', ' Position:', position) AS text"))
                ->where('ta_id', $request->ta_id)->where('staff_no', 'LIKE', '%' . $request->value . '%')
                ->orWhere('ta_id', $request->ta_id)->where('pcc', 'LIKE', '%' . $request->value . '%')
                ->orWhere('ta_id', $request->ta_id)->where('position', 'LIKE', '%' . $request->value . '%')
                ->orWhere('ta_id', $request->ta_id)->where('name', 'LIKE', '%' . $request->value . '%')->paginate(20);
            return response()->json($staff_no);
        }
        $staff_no = Staff::select(DB::raw("staff_no AS id,CONCAT('Staff No:', staff_no,' ',' ~ ' ,'PCC:', pcc,' ~ ' ,'Name:', name,' ~', ' Position:', position) AS text"))
            ->where('ta_id', $request->ta_id)->paginate(20);
        return response()->json($staff_no);
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $trainingstaff = TrainingStaff::create($request->all());
            if (!empty($trainingstaff) > 0) {
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
            $trainingstaff = TrainingStaff::where('id', $request->id)->update($data);
            if (!empty($trainingstaff)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            TrainingStaff::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function showed($id)
    {
        $data['trainingstaff'] = TrainingStaff::findOrFail($id);

        return view('backend.travel.trainingstaff.ajaxshowed', $data);
    }

    public function printStaffTraining(Request $request, $id)
    {
        if ($id != 0) {
            $data['travelagency'] = travelAgencyDetails($id);
            if (empty($request->staff_no) && empty($request->from) && empty($request->to) && empty($request->course)) {
                $data['trainingstaff'] = TrainingStaff::where('ta_id', $id)->orderBy('staff_no', 'asc')->get();
            }
            if (!empty($request->staff_no) && empty($request->from) && empty($request->to) && !empty($request->course)) {
                $data['trainingstaff'] = TrainingStaff::where('ta_id', $id)->where('staff_no', $request->staff_no)->where('course', $request->course)->orderBy('id', 'asc')->get();
            }
            if (!empty($request->staff_no) && empty($request->from) && empty($request->to) && empty($request->course)) {
                $data['trainingstaff'] = TrainingStaff::where('ta_id', $id)->where('staff_no', $request->staff_no)->orderBy('id', 'desc')->get();
            }
            if (empty($request->staff_no) && !empty($request->from) && !empty($request->to) && empty($request->course)) {
                $data['trainingstaff'] = TrainingStaff::where('ta_id', $request->ta_id)->where(function ($query) use ($request) {
                    $query->where('from', '<=', $request->from)
                        ->where('to', '>=', $request->from);
                })->orWhere(function ($query) use ($request) {
                    $query->where('to', '>=', $request->to)
                        ->where('from', '<=', $request->to);
                })->orWhere(function ($query) use ($request) {
                    $query->where('from', '>=', $request->from)
                        ->where('to', '<=', $request->to);
                })->orderBy('id', 'desc')->get();
            }
            if (!empty($request->staff_no) && !empty($request->from) && !empty($request->to) && empty($request->course)) {
                $data['trainingstaff'] = TrainingStaff::where('ta_id', $request->ta_id)->where(function ($query) use ($request) {
                    $query->where('staff_no', $request->staff_no)->where('from', '<=', $request->from)
                        ->where('to', '>=', $request->from);
                })->orWhere(function ($query) use ($request) {
                    $query->where('staff_no', $request->staff_no)->where('to', '>=', $request->to)
                        ->where('from', '<=', $request->to);
                })->orWhere(function ($query) use ($request) {
                    $query->where('staff_no', $request->staff_no)->where('from', '>=', $request->from)
                        ->where('to', '<=', $request->to);
                })->orderBy('id', 'desc')->get();
            }
            if (!empty($request->staff_no) && !empty($request->from) && !empty($request->to) && !empty($request->course)) {
                $data['trainingstaff'] = TrainingStaff::where('ta_id', $request->ta_id)->where(function ($query) use ($request) {
                    $query->where('course', $request->course)->where('staff_no', $request->staff_no)->where('from', '<=', $request->from)
                        ->where('to', '>=', $request->from);
                })->orWhere(function ($query) use ($request) {
                    $query->where('course', $request->course)->where('staff_no', $request->staff_no)->where('to', '>=', $request->to)
                        ->where('from', '<=', $request->to);
                })->orWhere(function ($query) use ($request) {
                    $query->where('course', $request->course)->where('staff_no', $request->staff_no)->where('from', '>=', $request->from)
                        ->where('to', '<=', $request->to);
                })->orderBy('id', 'desc')->get();
            }
            if (empty($request->staff_no) && !empty($request->from) && !empty($request->to) && !empty($request->course)) {
                $data['trainingstaff'] = TrainingStaff::where('ta_id', $request->ta_id)->where(function ($query) use ($request) {
                    $query->where('course', $request->course)->where('from', '<=', $request->from)
                        ->where('to', '>=', $request->from);
                })->orWhere(function ($query) use ($request) {
                    $query->where('course', $request->course)->where('to', '>=', $request->to)
                        ->where('from', '<=', $request->to);
                })->orWhere(function ($query) use ($request) {
                    $query->where('course', $request->course)->where('from', '>=', $request->from)
                        ->where('to', '<=', $request->to);
                })->orderBy('id', 'desc')->get();
            }

            if (empty($request->staff_no) && empty($request->from) && empty($request->to) && !empty($request->course)) {
                $data['trainingstaff'] = TrainingStaff::where('ta_id', $request->ta_id)->where('course', $request->course)->orderBy('id', 'desc')->get();
            }

            return view('backend.travel.trainingstaff.printTrainingStaff', $data);
        } else {

            if (empty($id) && empty($request->staff_no) && !empty($request->from) && !empty($request->to) && empty($request->course)) {
                $dataa['trainingstaff'] = TrainingStaff::where(function ($query) use ($request) {
                    $query->where('from', '<=', $request->from)
                        ->where('to', '>=', $request->from);
                })->orWhere(function ($query) use ($request) {
                    $query->where('to', '>=', $request->to)
                        ->where('from', '<=', $request->to);
                })->orWhere(function ($query) use ($request) {
                    $query->where('from', '>=', $request->from)
                        ->where('to', '<=', $request->to);
                })->orderBy('staff_no', 'asc')->get();
                $data['trainingstaffall'] = $dataa['trainingstaff']->groupBy(function ($item) {
                    return $item->ta_id;
                });
            } else if (empty($id) && empty($request->staff_no) && !empty($request->from) && !empty($request->to) && !empty($request->course)) {
                $dataa['trainingstaff'] = TrainingStaff::where(function ($query) use ($request) {
                    $query->where('from', '<=', $request->from)
                        ->where('to', '>=', $request->from)->where('course', $request->course);
                })->orWhere(function ($query) use ($request) {
                    $query->where('to', '>=', $request->to)
                        ->where('from', '<=', $request->to)->where('course', $request->course);
                })->orWhere(function ($query) use ($request) {
                    $query->where('from', '>=', $request->from)
                        ->where('to', '<=', $request->to)->where('course', $request->course);
                })->orderBy('id', 'desc')->get();
                $data['trainingstaffall'] = $dataa['trainingstaff']->groupBy(function ($item) {
                    return $item->ta_id;
                });
            } else if (empty($id) && empty($request->staff_no) && empty($request->from) && empty($request->to) && !empty($request->course)) {
                $dataa['trainingstaff'] = TrainingStaff::where('course', $request->course)->orderBy('id', 'desc')->get();
                $data['trainingstaffall'] = $dataa['trainingstaff']->groupBy(function ($item) {
                    return $item->ta_id;
                });
            } else {

                $data['trainingstaffall'] = TrainingStaff::orderBy('ta_id', 'asc')->get()->groupBy(function ($item) {
                    return $item->ta_id;
                });
            }
//            return view('backend.travel.trainingstaff.printTrainingStaff', $data);
        }
        return view('backend.travel.trainingstaff.printTrainingStaff', $data);

    }
}
