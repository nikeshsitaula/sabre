<?php


use App\Http\Controllers\Backend\TravelManagement\AccountManager\AccountManagerConroller;
use App\Http\Controllers\Backend\TravelManagement\Lniata\LniatasController;
use App\Http\Controllers\Backend\TravelManagement\Miscellaneous\misczController;
use App\Http\Controllers\Backend\TravelManagement\PCC\PCCsController;
use App\Http\Controllers\Backend\TravelManagement\Staff\StaffsController;
use App\Http\Controllers\Backend\TravelManagement\TrainingStaff\TrainingStaffsController;
use App\Http\Controllers\Backend\TravelManagement\TravelAgency\TravelAgenciesController;
use App\Http\Controllers\Backend\TravelManagement\TravelDashboardController;
use App\Http\Controllers\Backend\TravelManagement\Visits\VisitsController;


//travelagency

Route::group(['prefix' => 'travel', 'middleware' => ['role:administrator' or 'role:travelmanager']], function () {
    Route::get('/', [TravelAgenciesController::class, 'index'])->name('travel.index')->middleware(['role:administrator|travelmanager_view']);
    Route::get('create', [TravelAgenciesController::class, 'create'])->name('travel.create')->middleware(['role:administrator|travelmanager_add']);
    Route::post('store', [TravelAgenciesController::class, 'store'])->name('travel.store')->middleware(['role:administrator|travelmanager_add']);
    Route::get('show/{id}', [TravelAgenciesController::class, 'show'])->name('travel.show')->middleware(['role:administrator|travelmanager_view']);
    Route::get('edit/{id}', [TravelAgenciesController::class, 'edit'])->name('travel.edit')->middleware(['role:administrator|travelmanager_edit']);
    Route::put('update/{id}', [TravelAgenciesController::class, 'update'])->name('travel.update')->middleware(['role:administrator|travelmanager_edit']);
    Route::get('destroy/{id}', [TravelAgenciesController::class, 'destroy'])->name('travel.destroy')->middleware(['role:administrator|travelmanager_delete']);
    Route::get('list/travel', [TravelAgenciesController::class, 'listTravels'])->name('list.travels')->middleware(['role:administrator|travelmanager_view']);
    Route::get('checkTravelExistence', [TravelAgenciesController::class, 'checkTravelExistence'])->name('travel.checkTravelExistence')->middleware(['role:administrator|travelmanager_view']);
    Route::get('downloadExcel', [TravelAgenciesController::class, 'downloadExcel'])->name('travel.downloadExcel')->middleware(['role:administrator|travelmanager_view']);

    Route::group(['prefix' => 'pcc', 'middleware' => ['role:administrator' or 'role:travelmanager']], function () {
        Route::get('/', [PCCsController::class, 'index'])->name('pcc.index')->middleware(['role:administrator|travelmanager_view']);
        Route::get('/fetch_data', [PCCsController::class, 'fetch_data'])->name('pcc.fetch_data')->middleware(['role:administrator|travelmanager_view']);
        Route::post('/store', [PCCsController::class, 'store'])->name('pcc.store')->middleware(['role:administrator|travelmanager_add']);
        Route::post('/update', [PCCsController::class, 'update'])->name('pcc.update')->middleware(['role:administrator|travelmanager_edit']);
        Route::post('/delete_data', [PCCsController::class, 'delete_data'])->name('pcc.delete_data')->middleware(['role:administrator|travelmanager_delete']);
        Route::get('showed/{id}', [PCCsController::class, 'showed'])->name('pcc.showed')->middleware(['role:administrator|travelmanager_view']);
        Route::get('printPCC/{id}', [PCCsController::class, 'printPCC'])->name('pcc.printPCC')->middleware(['role:administrator|travelmanager_view']);
    });

    Route::group(['prefix' => 'travelmiscz', 'middleware' => ['role:administrator' or 'role:travelmanager']], function () {
        Route::get('/', [misczController::class, 'index'])->name('travelmiscz.index')->middleware(['role:administrator|travelmanager_view']);
        Route::get('/fetch_data', [misczController::class, 'fetch_data'])->name('travelmiscz.fetch_data')->middleware(['role:administrator|travelmanager_view']);
        Route::post('/store', [misczController::class, 'store'])->name('travelmiscz.store')->middleware(['role:administrator|travelmanager_add']);
        Route::post('/update', [misczController::class, 'update'])->name('travelmiscz.update')->middleware(['role:administrator|travelmanager_edit']);
        Route::post('/delete_data', [misczController::class, 'delete_data'])->name('travelmiscz.delete_data')->middleware(['role:administrator|travelmanager_delete']);
        Route::get('showed/{id}', [misczController::class, 'showed'])->name('travelmiscz.showed')->middleware(['role:administrator|travelmanager_view']);
        Route::get('printMiscz/{id}', [misczController::class, 'printMiscz'])->name('travelmiscz.printMiscz')->middleware(['role:administrator|travelmanager_view']);
    });

    Route::group(['prefix' => 'visit', 'middleware' => ['role:administrator' or 'role:travelmanager']], function () {
        Route::get('/', [VisitsController::class, 'index'])->name('visit.index')->middleware(['role:administrator|travelmanager_view']);
        Route::get('/fetch_data', [VisitsController::class, 'fetch_data'])->name('visit.fetch_data')->middleware(['role:administrator|travelmanager_view']);
        Route::post('/store', [VisitsController::class, 'store'])->name('visit.store')->middleware(['role:administrator|travelmanager_add']);
        Route::post('/update', [VisitsController::class, 'update'])->name('visit.update')->middleware(['role:administrator|travelmanager_edit']);
        Route::post('/delete_data', [VisitsController::class, 'delete_data'])->name('visit.delete_data')->middleware(['role:administrator|travelmanager_delete']);
        Route::get('showed/{id}', [VisitsController::class, 'showed'])->name('visit.showed')->middleware(['role:administrator|travelmanager_view']);
        Route::get('printVisit', [VisitsController::class, 'printVisit'])->name('visit.printVisit')->middleware(['role:administrator|travelmanager_view']);
    });

    Route::group(['prefix' => 'staff', 'middleware' => ['role:administrator' or 'role:travelmanager']], function () {
        Route::get('/', [StaffsController::class, 'index'])->name('staff.index')->middleware(['role:administrator|travelmanager_view']);
        Route::get('/fetch_data', [StaffsController::class, 'fetch_data'])->name('staff.fetch_data')->middleware(['role:administrator|travelmanager_view']);
        Route::post('/store', [StaffsController::class, 'store'])->name('staff.store')->middleware(['role:administrator|travelmanager_add']);
        Route::post('/update', [StaffsController::class, 'update'])->name('staff.update')->middleware(['role:administrator|travelmanager_edit']);
        Route::post('/delete_data', [StaffsController::class, 'delete_data'])->name('staff.delete_data')->middleware(['role:administrator|travelmanager_delete']);
        Route::get('showed/{id}', [StaffsController::class, 'showed'])->name('staff.showed')->middleware(['role:administrator|travelmanager_view']);
        Route::get('printStaff/{id}', [StaffsController::class, 'printStaff'])->name('staff.printStaff')->middleware(['role:administrator|travelmanager_view']);
        Route::get('checkpcc', [StaffsController::class, 'checkpcc'])->name('staff.checkpcc')->middleware(['role:administrator|travelmanager_view']);
        Route::get('filterPCCDropdown', [StaffsController::class, 'filterPCCDropdown'])->name('staff.filterPCCDropdown')->middleware(['role:administrator|travelmanager_view']);
    });

    Route::group(['prefix' => 'trainingstaff', 'middleware' => ['role:administrator' or 'role:travelmanager']], function () {
        Route::get('/', [TrainingStaffsController::class, 'index'])->name('trainingstaff.index')->middleware(['role:administrator|travelmanager_view']);
        Route::get('/fetch_data', [TrainingStaffsController::class, 'fetch_data'])->name('trainingstaff.fetch_data')->middleware(['role:administrator|travelmanager_view']);
        Route::post('/store', [TrainingStaffsController::class, 'store'])->name('trainingstaff.store')->middleware(['role:administrator|travelmanager_add']);
        Route::post('/update', [TrainingStaffsController::class, 'update'])->name('trainingstaff.update')->middleware(['role:administrator|travelmanager_edit']);
        Route::post('/delete_data', [TrainingStaffsController::class, 'delete_data'])->name('trainingstaff.delete_data')->middleware(['role:administrator|travelmanager_delete']);
        Route::get('showed/{id}', [TrainingStaffsController::class, 'showed'])->name('trainingstaff.showed')->middleware(['role:administrator|travelmanager_view']);
        Route::get('printTrainingStaff/{id}', [TrainingStaffsController::class, 'printStaff'])->name('trainingstaff.printStaff')->middleware(['role:administrator|travelmanager_view']);
        Route::get('checkpcc', [TrainingStaffsController::class, 'checkpcc'])->name('trainingstaff.checkpcc')->middleware(['role:administrator|travelmanager_view']);
        Route::get('filterTrainingStaff', [TrainingStaffsController::class, 'filterTrainingStaff'])->name('trainingstaff.filterTrainingStaff')->middleware(['role:administrator|travelmanager_view']);
        Route::get('printStaffTraining/{id}', [TrainingStaffsController::class, 'printStaffTraining'])->name('travelmiscz.printStaffTraining')->middleware(['role:administrator|travelmanager_view']);
    });

    Route::group(['prefix' => 'lniata', 'middleware' => ['role:administrator' or 'role:travelmanager']], function () {
        Route::get('/', [LniatasController::class, 'index'])->name('lniata.index')->middleware(['role:administrator|travelmanager_view']);
        Route::get('/fetch_data', [LniatasController::class, 'fetch_data'])->name('lniata.fetch_data')->middleware(['role:administrator|travelmanager_view']);
        Route::post('/store', [LniatasController::class, 'store'])->name('lniata.store')->middleware(['role:administrator|travelmanager_add']);
        Route::post('/update', [LniatasController::class, 'update'])->name('lniata.update')->middleware(['role:administrator|travelmanager_edit']);
        Route::post('/delete_data', [LniatasController::class, 'delete_data'])->name('lniata.delete_data')->middleware(['role:administrator|travelmanager_delete']);
        Route::get('showed/{id}', [LniatasController::class, 'showed'])->name('lniata.showed')->middleware(['role:administrator|travelmanager_view']);
        Route::get('checkpcc', [LniatasController::class, 'checkpcc'])->name('lniata.checkpcc')->middleware(['role:administrator|travelmanager_view']);
        Route::get('printLniata/{id}', [LniatasController::class, 'printLniata'])->name('lniata.printLniata')->middleware(['role:administrator|travelmanager_view']);
    });

//    Route::group(['prefix' => 'accountmanager', 'middleware' => ['role:administrator' or 'role:travelmanager']], function () {
//        Route::get('/', [AccountManagerConroller::class, 'index'])->name('accountmanager.index')->middleware(['role:administrator|travelmanager_view']);
//        Route::get('/fetch_data', [AccountManagerConroller::class, 'fetch_data'])->name('accountmanager.fetch_data')->middleware(['role:administrator|travelmanager_view']);
//        Route::post('/store', [AccountManagerConroller::class, 'store'])->name('accountmanager.store')->middleware(['role:administrator|travelmanager_add']);
//        Route::post('/update', [AccountManagerConroller::class, 'update'])->name('accountmanager.update')->middleware(['role:administrator|travelmanager_edit']);
//        Route::post('/delete_data', [AccountManagerConroller::class, 'delete_data'])->name('accountmanager.delete_data')->middleware(['role:administrator|travelmanager_delete']);
//        Route::get('showed/{id}', [AccountManagerConroller::class, 'showed'])->name('accountmanager.showed')->middleware(['role:administrator|travelmanager_view']);
//        Route::get('printAccountManager/{id}', [AccountManagerConroller::class, 'printAccountManager'])->name('accountmanager.printAccountManager')->middleware(['role:administrator|travelmanager_view']);
//    });


    //dashboard
    Route::group(['prefix' => 'travel', 'middleware' => ['role:administrator' or 'role:travelmanager']], function () {
        Route::get('/dashboard', [TravelDashboardController::class, 'index'])->name('traveldashboard.index')->middleware(['role:administrator|travelmanager_view']);
    });
});


