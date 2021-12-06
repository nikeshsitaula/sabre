<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
//use Auth;
//use App\Http\Controllers\Frontend\Redirect;
use Illuminate\Support\Facades\Auth;

/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (Auth::check())
            return redirect('/admin/dashboard');

        return redirect('/login');
    }
}
