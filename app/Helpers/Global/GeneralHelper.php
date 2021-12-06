<?php

use App\Models\AccountManagement\AccountManagement;
use App\Models\AirlinesManagement\Airline;
use App\Models\Auth\User;
use App\Models\Employee\Career;
use App\Models\Employee\Education;
use App\Models\Employee\Employee;
use App\Models\Employee\Experience;
use App\Models\Product\ProductAgreement;
use App\Models\Product\ProductDescription;
use App\Models\Sales\Sale;
use App\Models\TravelManagement\AccountManager;
use App\Models\TravelManagement\TravelAgency;
use function foo\func;

if (!function_exists('app_name')) {
    /**
     * Helper to grab the application name.
     *
     * @return mixed
     */
    function app_name()
    {
        return config('app.name');
    }
}

if (!function_exists('gravatar')) {
    /**
     * Access the gravatar helper.
     */
    function gravatar()
    {
        return app('gravatar');
    }
}

if (!function_exists('home_route')) {
    /**
     * Return the route to the "home" page depending on authentication/authorization status.
     *
     * @return string
     */
    function home_route()
    {
        if (auth()->check()) {
            if (auth()->user()->can('view backend')) {
                return 'admin.dashboard';
            }

            return 'frontend.user.dashboard';
        }

        return 'frontend.index';
    }

    // employee

    function employeeDetails($emp_no)
    {
        return Employee::where('emp_no', $emp_no)->latest()->first();
    }

    function employeePosition($emp_no)
    {
        return Career::select('position')->where('emp_no', $emp_no)->pluck('position')->last();
    }

    function employeeEducation($emp_no)
    {
        return Education::select('qualification')->where('emp_no', $emp_no)->pluck('qualification')->last();
    }

    function employeeCareer($emp_no)
    {
        return Career::select('position')->where('emp_no', $emp_no)->pluck('position')->last();
    }

    function getAllEmployeeExperience($emp_no)
    {
        return Experience::where('emp_no', $emp_no)->get();
    }

    //travel
    function travelAgencyDetails($ta_id)
    {
        return TravelAgency::where('ta_id', $ta_id)->latest()->first();
    }

    //get by column and travel id name
    function travelAgencyByField($ta_id,$column)
    {
        return TravelAgency::select($column)->where('ta_id', $ta_id)->first()->$column;
    }


    //travel account manager
    function travelAccountManager($ta_id)
    {
        return AccountManager::select('accountmanager')->where('ta_id', $ta_id)->pluck('accountmanager')->last();
    }

    function getTravelName($ta_id)
    {
        return TravelAgency::select('ta_name')->where('ta_id', $ta_id)->pluck('ta_name')[0];
    }

    //airlines details
    function airlinesDetails($ai_id)
    {
        return Airline::where('ai_id', $ai_id)->latest()->first();
    }

    //Account Manager
    function accountManagerName($ta_id)
    {
        $am = AccountManagement::select('user')->where('ta_id', $ta_id)->first();
        if ($am != '')
            return $am->user;
        else{
            return 0;
        }
    }

    //product details
    function productsDetails($p_id)
    {
        return ProductDescription::where('p_id', $p_id)->latest()->first();
    }

    //product details
    function agreementsDetails($agreementnumber)
    {
        return ProductAgreement::where('agreementnumber', $agreementnumber)->latest()->first();
    }

    function getProductID($agreementnumber)
    {
        return ProductAgreement::select('p_id')->where('agreementnumber', $agreementnumber)->pluck('p_id')[0];
    }

    function getProductName($p_id)
    {
        return ProductDescription::select('name')->where('p_id', $p_id)->pluck('name')[0];
    }

    //sma details
    function smaDetails($sma_id)
    {
        return Sale::where('sma_id', $sma_id)->latest()->first();
    }
}
