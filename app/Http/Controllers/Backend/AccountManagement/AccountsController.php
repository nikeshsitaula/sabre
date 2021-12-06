<?php

namespace App\Http\Controllers\Backend\AccountManagement;

use App\Http\Controllers\Controller;
use App\Models\AccountManagement\AccountManagement;
use App\Models\AccountManagement\AccountManagerSchedule;
use App\Models\Auth\User;
use App\Models\Booking\Incentive;
use App\Models\Booking\MIDT;
use App\Models\Booking\Revenue;
use App\Models\TravelManagement\AccountManager;
use App\Models\TravelManagement\TravelAgency;
use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Http\Request;
use DB;

class AccountsController extends Controller
{
    public function index()
    {
        $data['ta_id'] = TravelAgency::select(DB::raw("CONCAT(ta_name,'(',ta_id,') ','&nbsp;',ta_phone,' ', '&nbsp;&nbsp; IATA: ',ta_iata_no,' ','&nbsp;&nbsp; Fax: ',ta_fax_no,' ') AS ta_name"), 'ta_id')->pluck('ta_name', 'ta_id');

        return view('backend.accountmanagement.accountsmanager.index', $data);
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            $data = AccountManagement::where('ta_id', $request->ta_id)->orderBy('id', 'desc')->paginate(6);
            echo json_encode($data);
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $user = User::where('email', $request->email)->first();
            if (!empty($user)) {
                $request->merge([
                    'created_by' => auth()->user()->id,
                    'user' => $user->full_name
                ]);
            } else {
                return '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                No User found with this email
            </div>';
            }
            $accountsmanager = AccountManagement::create($request->all());
            $name = User::where('email', $request->email)->first();
            MIDT::where('ta_id', $request->ta_id)->update([
                'accountmanager' => $name->full_name
            ]);
            if (!empty($accountsmanager)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Inserted
            </div>';
            }

//            $ta_id = AccountManagement::where('id', $request->id)->pluck('ta_id');
            if (!empty($user)) {
                $updateaccountmanager = array(
                    'accountmanager' => $user->full_name,
                    'updated_by' => auth()->user()->id
                );
            } else {
                $updateaccountmanager = array(
                    'updated_by' => auth()->user()->id
                );
            }

            $yearval = Carbon::createFromFormat('Y-m-d', $accountsmanager->date)->year;
            $monthval = Carbon::createFromFormat('Y-m-d', $accountsmanager->date)->month;

            $ta_id = AccountManagement::where('id', $accountsmanager->id)->pluck('ta_id');

            $datamidt = MIDT::where('ta_id', $ta_id)->where('year', $yearval)->where('month', $monthval)->update($updateaccountmanager);
            $datarevenue = Revenue::where('ta_id', $ta_id)->where('year', $yearval)->where('month', $monthval)->update($updateaccountmanager);
            $dataincentive = Incentive::where('ta_id', $ta_id)->where('year', $yearval)->where('month', $monthval)->update($updateaccountmanager);

            $updatefinal = TravelAgency::where('ta_id', $request->ta_id)->update($updateaccountmanager);

            if (!empty($datamidt) && !empty($datarevenue) && !empty($dataincentive) && !empty($updatefinal)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                AccountManager Updated
            </div>';

            }
        }
    }

    public function update(Request $request)
    {

        //checks if email is updated
        if ($request->column_name === 'email') {
            //get the user name for that email
            $user = User::where('email', $request->column_value)->first();

            if ($request->ajax()) {
                if (!empty($user)) {
                    $data = array(
                        $request->column_name => $request->column_value,
                        'user' => $user->full_name,
                        'updated_by' => auth()->user()->id
                    );
                } else {
                    return '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                No User found with this email
            </div>';
                }

                $accountsmanager = AccountManagement::where('id', $request->id)->update($data);

                if (!empty($accountsmanager)) {
                    echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
                }

                if (!empty($user)) {
                    $updateaccountmanager = array(
                        'accountmanager' => $user->full_name,
                        'updated_by' => auth()->user()->id
                    );
                } else {
                    $updateaccountmanager = array(
                        'updated_by' => auth()->user()->id
                    );
                }

                $accountsdetail = AccountManagement::where('id', $request->id)->pluck('date')[0];
                $yearval = Carbon::createFromFormat('Y-m-d', $accountsdetail)->year;
                $monthval = Carbon::createFromFormat('Y-m-d', $accountsdetail)->month;

                $ta_id = AccountManagement::where('id', $request->id)->pluck('ta_id');

                $datamidt = MIDT::where('ta_id', $ta_id)->where('year', $yearval)->where('month', $monthval)->update($updateaccountmanager);
                $datarevenue = Revenue::where('ta_id', $ta_id)->where('year', $yearval)->where('month', $monthval)->update($updateaccountmanager);
                $dataincentive = Incentive::where('ta_id', $ta_id)->where('year', $yearval)->where('month', $monthval)->update($updateaccountmanager);

                $obtval = AccountManagement::where('ta_id', $ta_id)->latest()->pluck('user')[0];
                if (!empty($user)) {
                    $obtvals = array(
                        'accountmanager' => $obtval,
                        'updated_by' => auth()->user()->id
                    );
                } else {
                    $obtvals = array(
                        'updated_by' => auth()->user()->id
                    );
                }
                $updatefinal = TravelAgency::where('ta_id', $ta_id)->update($obtvals);


                if (!empty($datamidt) && !empty($datarevenue) && !empty($dataincentive) && !empty($updatefinal)) {
                    echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Accounts Manager Updated
            </div>';

                }
            }
        }
        else {
            $date = $request->column_value;
            $user = AccountManagement::select('user')->where('date', $date)->first();
//            dd($user);
            if (!empty($user)) {
                $updateaccountmanager = array(
                    'accountmanager' => $user->user,
                    'updated_by' => auth()->user()->id
                );
            } else {
                $updateaccountmanager = array(
                    'updated_by' => auth()->user()->id
                );
            }

            if ($request->ajax()) {
                $data = array(
                    $request->column_name => $request->column_value,
                    'updated_by' => auth()->user()->id
                );
            }
            $accountsmanager = AccountManagement::where('id', $request->id)->update($data);

            if (!empty($accountsmanager)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
            }

            $yearval = Carbon::createFromFormat('Y-m-d', $date)->year;
            $monthval = Carbon::createFromFormat('Y-m-d', $date)->month;

            $ta_id = AccountManagement::where('id', $request->id)->pluck('ta_id');
            $datamidt = MIDT::where('ta_id', $ta_id)->where('year', $yearval)->where('month', $monthval)->update($updateaccountmanager);
            $datarevenue = Revenue::where('ta_id', $ta_id)->where('year', $yearval)->where('month', $monthval)->update($updateaccountmanager);
            $dataincentive = Incentive::where('ta_id', $ta_id)->where('year', $yearval)->where('month', $monthval)->update($updateaccountmanager);

            $obtval = AccountManagement::where('ta_id', $ta_id)->latest()->pluck('user')[0];
            if (!empty($user)) {
                $obtvals = array(
                    'accountmanager' => $obtval,
                    'updated_by' => auth()->user()->id
                );
            } else {
                $obtvals = array(
                    'updated_by' => auth()->user()->id
                );
            }
            $updatefinal = TravelAgency::where('ta_id', $ta_id)->update($obtvals);


            if (!empty($datamidt) && !empty($datarevenue) && !empty($dataincentive) && !empty($updatefinal)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Accounts Manager Updated
            </div>';

            }

        }

    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            $id = $request->id;
            $ta_id = AccountManagement::select('ta_id')->where('id', $id)->pluck('ta_id')->sum();
            AccountManagement::where('id', $request->id)->delete();
            $accountmanagerval = AccountManagement::select('user')->where('ta_id', $ta_id)->pluck('user')->last();

            if (!empty($accountmanagerval)) {
                $updatetravelmanager = array(
                    'accountmanager' => $accountmanagerval,
                    'updated_by' => auth()->user()->id
                );
            } else {
                $updatetravelmanager = array(
                    'accountmanager' => 0,
                    'updated_by' => auth()->user()->id
                );
            }

            //update values in travel agency
            $updatefinal = TravelAgency::where('ta_id', $ta_id)->update($updatetravelmanager);

            if (!empty($updatefinal)) {
                echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
            }
        }
    }

    public function showed($id)
    {
        $data['accountsmanager'] = AccountManagement::findOrFail($id);
        return view('backend.accountmanagement.accountsmanager.ajaxshowed', $data);
    }

    public function printaccountsmanager($id)
    {
        $data['travelagency'] = travelAgencyDetails($id);
        $data['accountsmanager'] = AccountManagement::where('ta_id', $id)->get();
        return view('backend.accountmanagement.accountsmanager.printAccountsManager', $data);
    }

    public function managerschedule()
    {
        $ta_id = TravelAgency::select('ta_id')->get();
        foreach ($ta_id as $tid) {
            $accountManager = AccountManagement::where('ta_id', $tid->ta_id)->latest()->first();
            if (!empty($accountManager)) {
                $newAccountManager = $accountManager->replicate();
                $newAccountManager->date = Carbon::parse($accountManager->date)->addMonth()->format('Y-m') . '-1';
                $newAccountManager->save();
            }
//            $scheduleDate = AccountManagerSchedule::where('ta_id', $tid->ta_id)->latest()->first();
//
//            if ($scheduleDate['next_month'] === $scheduleDate['running_date']) {
//                $accountManager = AccountManagement::where('ta_id', $tid->ta_id)->latest()->first();
//                if (!empty($accountManager)) {
//                    $newAccountManager = $accountManager->replicate();
//                    $newAccountManager->date = $scheduleDate['next_month'];
//                    $newAccountManager->save();
//
//                    AccountManagerSchedule::where('ta_id', $tid->ta_id)->update([
//                        'next_month' => Carbon::parse($scheduleDate['next_month'])->addMonth(),
//                        'running_date' => $scheduleDate['next_month']
//                    ]);
//                }
//            } else {
//                $scheduleDate->update([
//                    'running_date' => Carbon::parse($scheduleDate['running_date'])->addDay()
//                ]);
//            }
        }
        return 'Account Manager updated Successfully!!';

    }
}
