<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Employee\EmployeeController;
use App\Http\Controllers\Backend\LandingsController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [LandingsController::class, 'index'])->name('dashboard');
