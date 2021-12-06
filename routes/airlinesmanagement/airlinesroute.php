<?php

use App\Http\Controllers\Backend\AirlinesManagement\Airlines\AirlinesController;
use App\Http\Controllers\Backend\AirlinesManagement\AirlinesDashboardController;
use App\Http\Controllers\Backend\AirlinesManagement\AirlinesMisc\AirlinesMiscController;
use App\Http\Controllers\Backend\AirlinesManagement\AirlinesStaff\AirlinesStaffController;
use App\Http\Controllers\Backend\AirlinesManagement\AirlinesVisit\AirlinesVisitController;

//airlinesmanagement
// ->middleware('role:airlinemanager', 'permission:view');
Route::group(['prefix' => 'airlines', 'middleware' => ['role:administrator' or 'role:airlinemanager']], function () {
    Route::get('/', [AirlinesController::class, 'index'])->name('airlines.index')->middleware([ 'role:administrator|airlinemanager_view' ]);
    Route::get('create', [AirlinesController::class, 'create'])->name('airlines.create')->middleware([ 'role:administrator|airlinemanager_add']);
    Route::post('store', [AirlinesController::class, 'store'])->name('airlines.store')->middleware([ 'role:administrator|airlinemanager_add' ]);
    Route::get('show/{id}', [AirlinesController::class, 'show'])->name('airlines.show')->middleware([ 'role:administrator|airlinemanager_view' ]);
    Route::get('edit/{id}', [AirlinesController::class, 'edit'])->name('airlines.edit')->middleware([ 'role:administrator|airlinemanager_edit' ]);
    Route::put('update/{id}', [AirlinesController::class, 'update'])->name('airlines.update')->middleware([ 'role:administrator|airlinemanager_edit' ]);
    Route::get('destroy/{id}', [AirlinesController::class, 'destroy'])->name('airlines.destroy')->middleware([ 'role:administrator|airlinemanager_delete' ]);
    Route::get('list/airlines', [AirlinesController::class, 'listAirlines'])->name('list.airlines')->middleware([ 'role:administrator|airlinemanager_view' ]);
    Route::get('checkAirlinesExistence', [AirlinesController::class, 'checkAirlinesExistence'])->name('airlines.checkAirlinesExistence')->middleware([ 'role:administrator|airlinemanager_view' ]);
    Route::get('downloadExcel', [AirlinesController::class, 'downloadExcel'])->name('airlines.downloadExcel')->middleware([ 'role:administrator|airlinemanager_view' ]);

    Route::group(['prefix' => 'airlinesstaff', 'middleware' => ['role:administrator' or 'role:airlinemanager']], function () {
        Route::get('/', [AirlinesStaffController::class, 'index'])->name('airlinesstaff.index')->middleware([ 'role:administrator|airlinemanager_view' ]);
        Route::get('/fetch_data', [AirlinesStaffController::class, 'fetch_data'])->name('airlinesstaff.fetch_data')->middleware([ 'role:administrator|airlinemanager_view' ]);
        Route::post('/store', [AirlinesStaffController::class, 'store'])->name('airlinesstaff.store')->middleware([ 'role:administrator|airlinemanager_add' ]);
        Route::post('/update', [AirlinesStaffController::class, 'update'])->name('airlinesstaff.update')->middleware([ 'role:administrator|airlinemanager_edit' ]);
        Route::post('/delete_data', [AirlinesStaffController::class, 'delete_data'])->name('airlinesstaff.delete_data')->middleware([ 'role:administrator|airlinemanager_delete' ]);
        Route::get('showed/{id}', [AirlinesStaffController::class, 'showed'])->name('airlinesstaff.showed')->middleware([ 'role:administrator|airlinemanager_view' ]);
        Route::get('printairlinesstaff/{id}', [AirlinesStaffController::class, 'printairlinesstaff'])->name('airlinesstaff.printairlinesstaff')->middleware([ 'role:administrator|airlinemanager_view' ]);
    });

    Route::group(['prefix' => 'airlinesvisit', 'middleware' => ['role:administrator' or 'role:airlinemanager']], function () {
        Route::get('/', [AirlinesVisitController::class, 'index'])->name('airlinesvisit.index')->middleware([ 'role:administrator|airlinemanager_view' ]);
        Route::get('/fetch_data', [AirlinesVisitController::class, 'fetch_data'])->name('airlinesvisit.fetch_data')->middleware([ 'role:administrator|airlinemanager_view' ]);
        Route::post('/store', [AirlinesVisitController::class, 'store'])->name('airlinesvisit.store')->middleware([ 'role:administrator|airlinemanager_add' ]);
        Route::post('/update', [AirlinesVisitController::class, 'update'])->name('airlinesvisit.update')->middleware([ 'role:administrator|airlinemanager_edit' ]);
        Route::post('/delete_data', [AirlinesVisitController::class, 'delete_data'])->name('airlinesvisit.delete_data')->middleware([ 'role:administrator|airlinemanager_delete' ]);
        Route::get('showed/{id}', [AirlinesVisitController::class, 'showed'])->name('airlinesvisit.showed')->middleware([ 'role:administrator|airlinemanager_view' ]);
        Route::get('printairlinesvisit', [AirlinesVisitController::class, 'printairlinesvisit'])->name('airlinesvisit.printairlinesvisit')->middleware([ 'role:administrator|airlinemanager_view' ]);
    });

    Route::group(['prefix' => 'airlinesmisc', 'middleware' => ['role:administrator' or 'role:airlinemanager']], function () {
        Route::get('/', [AirlinesMiscController::class, 'index'])->name('airlinesmisc.index')->middleware([ 'role:administrator|airlinemanager_view' ]);
        Route::get('/fetch_data', [AirlinesMiscController::class, 'fetch_data'])->name('airlinesmisc.fetch_data')->middleware([ 'role:administrator|airlinemanager_view' ]);
        Route::post('/store', [AirlinesMiscController::class, 'store'])->name('airlinesmisc.store')->middleware([ 'role:administrator|airlinemanager_add' ]);
        Route::post('/update', [AirlinesMiscController::class, 'update'])->name('airlinesmisc.update')->middleware([ 'role:administrator|airlinemanager_edit' ]);
        Route::post('/delete_data', [AirlinesMiscController::class, 'delete_data'])->name('airlinesmisc.delete_data')->middleware([ 'role:administrator|airlinemanager_delete' ]);
        Route::get('showed/{id}', [AirlinesMiscController::class, 'showed'])->name('airlinesmisc.showed')->middleware([ 'role:administrator|airlinemanager_view' ]);
        Route::get('printairlinesmisc/{id}', [AirlinesMiscController::class, 'printairlinesmisc'])->name('airlinesmisc.printairlinesmisc')->middleware('permission:view');
//        Route::get('checkAirlines', [AirlinesMiscController::class, 'checkAirlines'])->name('airlinesmisc.checkAirlines');
//        Route::get('filterAirlinesDropdown', [AirlinesMiscController::class, 'filterAirlinesDropdown'])->name('airlinesmisc.filterAirlinesDropdown');
    });

    //dashboard
    Route::group(['prefix' => 'airlinesdashboard', 'middleware' => ['role:administrator' or 'role:airlinemanager']], function () {
        Route::get('/dashboard', [AirlinesDashboardController::class, 'index'])->name('airlinesdashboard.index')->middleware([ 'role:administrator|airlinemanager_view' ]);
    });
});


