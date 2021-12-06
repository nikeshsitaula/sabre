<?php

namespace App\Http\Controllers\Backend\ProductsManagement;

use App\Models\Product\ProductAgreement;
use App\Models\Product\ProductDescription;
use App\Models\TravelManagement\TravelAgency;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class ProductAgreementController extends Controller
{

    public function index()
    {
        $data['p_id'] = ProductDescription::select(DB::raw("CONCAT(name,'(',p_id,')') AS name"), 'p_id')->pluck('name', 'p_id');

        return view('backend.products.productagreement.index', $data);
    }

    function fetch_data(Request $request)
    {
        if ($request->ajax()) {
            //only p_id
            if (!empty($request->p_id) && empty($request->from) && empty($request->to)) {
                $data = ProductAgreement::where('p_id', $request->p_id)->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } //with travelid, from, to
            else if (!empty($request->p_id) && !empty($request->from) && !empty($request->to)) {
                $data = ProductAgreement::where('p_id', $request->p_id)->whereBetween('agreementdate', [$request->from, $request->to])->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } //with travelid, from
            else if (!empty($request->p_id) && !empty($request->from) && empty($request->to)) {
                $data = ProductAgreement::where('p_id', $request->p_id)->where('agreementdate', '>=', $request->from)->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } else if (!empty($request->p_id) && empty($request->from) && !empty($request->to)) {
                $data = ProductAgreement::where('p_id', $request->p_id)->where('agreementdate', '<=', $request->to)->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } else if (empty($request->p_id) && !empty($request->from) && !empty($request->to)) {
                $data = ProductAgreement::whereBetween('agreementdate', [$request->from, $request->to])->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } //with from
            else if (empty($request->p_id) && !empty($request->from) && empty($request->to)) {
                $data = ProductAgreement::where('agreementdate', '>=', $request->from)->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            } else if (empty($request->p_id) && empty($request->from) && !empty($request->to)) {
                $data = ProductAgreement::where('agreementdate', '<=', $request->to)->orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            }//with nothing
            else {
                $data = ProductAgreement::orderBy('id', 'desc')->paginate(6);
                echo json_encode($data);
            }
        }
    }

    public function store(Request $request)
    {
        if ($request->ajax()) {
            $agreementnumber = $request->agreementnumber;
            $checkagreementnumber = ProductAgreement::select('agreementnumber')->where('agreementnumber', $agreementnumber)->first();
            if (!empty($checkagreementnumber)) {
                return '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                This agreement number is already used.
            </div>';
            } else {
                $ta_id = $request->ta_id;
                $travelagencyname = TravelAgency::select('ta_name')->where('ta_id', $ta_id)->first();
                if (!empty($travelagencyname)) {
//                $travelname = TravelAgency::select('accountmanager')->where('ta_id', $ta_id)->latest()->pluck('accountmanager')[0];
                    $travelname = $travelagencyname->ta_name;
                } else {
                    return '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                No Travel Agency found with the entered Travel ID
            </div>';
                }

                $request->merge([
                    'travelname' => $travelname,
                    'created_by' => auth()->user()->id
                ]);
                $productsagreement = ProductAgreement::create($request->all());
                if (!empty($productsagreement) > 0) {
                    echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Inserted
            </div>';
                }
            }
        }
    }


    public function update(Request $request)
    {
        if ($request->column_name === 'agreementnumber') {
            $agreementnumber = $request->column_value;
            $checkagreementnumber = ProductAgreement::select('agreementnumber')->where('agreementnumber', $agreementnumber)->first();
            if (!empty($checkagreementnumber)) {
                return '<div class="alert alert-danger" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                This agreement number is already used.
            </div>';
            } else {
                $data = array(
                    $request->column_name => $request->column_value,
                    'updated_by' => auth()->user()->id
                );
                $productsagreement = ProductAgreement::where('id', $request->id)->update($data);
                if (!empty($productsagreement)) {
                    echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
                }
            }
        } else {
            if ($request->column_name === 'ta_id') {

                $ta_id = $request->column_value;
                $travelagencyname = TravelAgency::select('ta_name')->where('ta_id', $ta_id)->first();
                if (!empty($travelagencyname)) {
                    $travelname = $travelagencyname->ta_name;
                } else {
                    $travelname = 0;
                }

                $data = array(
                    $request->column_name => $request->column_value,
                    'travelname' => $travelname,
                    'updated_by' => auth()->user()->id
                );
                $productsagreement = ProductAgreement::where('id', $request->id)->update($data);
                if (!empty($productsagreement)) {
                    echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
                }

            } else {
                if ($request->ajax()) {
                    $data = array(
                        $request->column_name => $request->column_value,
                        'updated_by' => auth()->user()->id
                    );
                    $productsagreement = ProductAgreement::where('id', $request->id)->update($data);
                    if (!empty($productsagreement)) {
                        echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Updated
            </div>';
                    }
                }
            }
        }
    }

    function delete_data(Request $request)
    {
        if ($request->ajax()) {
            ProductAgreement::where('id', $request->id)->delete();

            echo '<div class="alert alert-success" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Data Deleted
            </div>';
        }
    }

    public function showed($id)
    {
        $data['productsagreement'] = ProductAgreement::findOrFail($id);
        return view('backend.products.productagreement.ajaxshowed', $data);
    }

    public function printproductsagreement(Request $request)
    {

        if (!empty($request->p_id)) {
            $data['productval'] = productsDetails($request->p_id);
            $productagreement = ProductAgreement::where('p_id', $request->p_id)->get();
            $data['productsagreement'] = $productagreement->groupBy(function ($item) {
                return $item->ta_id;
            });
        }
        if (!empty($request->p_id) && empty($request->from) && empty($request->to)) {
            $productagreement = ProductAgreement::where('p_id', $request->p_id)->orderBy('id', 'desc')->get();
            $data['productsagreement'] = $productagreement->groupBy(function ($item) {
                return $item->ta_id;
            });
        } else if (!empty($request->p_id) && !empty($request->from) && !empty($request->to)) {
            $productagreement = ProductAgreement::where('p_id', $request->p_id)->whereBetween('agreementdate', [$request->from, $request->to])->orderBy('id', 'desc')->get();
            $data['productsagreement'] = $productagreement->groupBy(function ($item) {
                return $item->ta_id;
            });
        } else if (!empty($request->p_id) && empty($request->from) && !empty($request->to)) {
            $productagreement = ProductAgreement::where('p_id', $request->p_id)->where('agreementdate', '<=', $request->to)->orderBy('id', 'desc')->get();
            $data['productsagreement'] = $productagreement->groupBy(function ($item) {
                return $item->ta_id;
            });
        } else if (!empty($request->p_id) && !empty($request->from) && empty($request->to)) {
            $productagreement = ProductAgreement::where('p_id', $request->p_id)->where('agreementdate', '>=', $request->from)->orderBy('id', 'desc')->get();
            $data['productsagreement'] = $productagreement->groupBy(function ($item) {
                return $item->ta_id;
            });
        } else if (empty($request->p_id) && !empty($request->from) && !empty($request->to)) {
            $productagreement = ProductAgreement::whereBetween('agreementdate', [$request->from, $request->to])->orderBy('id', 'desc')->get();
            $data['productsagreement'] = $productagreement->groupBy(function ($item) {
                return $item->ta_id;
            });
        } else if (!empty($request->p_id) && !empty($request->from) && empty($request->to)) {
            $productagreement = ProductAgreement::where('agreementdate', '>=', $request->from)->orderBy('ta_id', 'asc')->get();
            $data['productsagreement'] = $productagreement->groupBy(function ($item) {
                return $item->ta_id;
            });
        } else if (!empty($request->p_id) && empty($request->from) && !empty($request->to)) {
            $productagreement = ProductAgreement::where('agreementdate', '<=', $request->to)->orderBy('ta_id', 'asc')->get();
            $data['productsagreement'] = $productagreement->groupBy(function ($item) {
                return $item->ta_id;
            });
        } else {
            $productagreement = ProductAgreement::orderBy('ta_id', 'asc')->get();
            $data['productsagreement'] = $productagreement->groupBy(function ($item) {
                return $item->ta_id;
            });
        }
        return view('backend.products.productagreement.printproductsagreement', $data);
    }


}
