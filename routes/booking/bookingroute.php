<?php


use App\Http\Controllers\Backend\Booking\BookingsController;
use App\Http\Controllers\Backend\Booking\IncentivesController;
use App\Http\Controllers\Backend\Booking\RevenuesController;

//booking

Route::group(['prefix' => 'booking', 'middleware' => ['role:administrator' or 'role:bookingmanager']], function () {
    Route::get('/', [BookingsController::class, 'index'])->name('booking.index')->middleware([ 'role:administrator|bookingmanager_view' ]);
    Route::get('/fetch_data', [BookingsController::class, 'fetch_data'])->name('booking.fetch_data')->middleware([ 'role:administrator|bookingmanager_view' ]);
    Route::post('/store', [BookingsController::class, 'store'])->name('booking.store')->middleware([ 'role:administrator|bookingmanager_add' ]);
    Route::post('/update', [BookingsController::class, 'update'])->name('booking.update')->middleware([ 'role:administrator|bookingmanager_edit' ]);
    Route::post('/delete_data', [BookingsController::class, 'delete_data'])->name('booking.delete_data')->middleware([ 'role:administrator|bookingmanager_delete' ]);
    Route::get('show/{id}', [BookingsController::class, 'show'])->name('booking.show')->middleware([ 'role:administrator|bookingmanager_view' ]);
    Route::get('uploadExcelForm', [BookingsController::class, 'uploadExcelForm'])->name('booking.uploadExcelForm')->middleware([ 'role:administrator|bookingmanager_add' ]);
    Route::post('/uploadExcel', [BookingsController::class, 'uploadExcel'])->name('booking.uploadExcel')->middleware([ 'role:administrator|bookingmanager_add' ]);
    Route::get('/search', [BookingsController::class, 'search'])->name('booking.search')->middleware([ 'role:administrator|bookingmanager_view' ]);
    Route::get('/print', [BookingsController::class, 'print'])->name('booking.print')->middleware([ 'role:administrator|bookingmanager_view' ]);
    Route::get('/exportexcel', [BookingsController::class, 'exportexcel'])->name('booking.exportexcel')->middleware([ 'role:administrator|bookingmanager_view' ]);
    Route::get('/exportexcel', [BookingsController::class, 'exportexcel'])->name('booking.exportexcel')->middleware([ 'role:administrator|bookingmanager_view' ]);

//Ievenue
    Route::group(['prefix' => 'revenue', 'middleware' => ['role:administrator' or 'role:bookingmanager']], function () {
        Route::get('/', [RevenuesController::class, 'index'])->name('revenue.index')->middleware([ 'role:administrator|bookingmanager_view' ]);
        Route::get('/fetch_data', [RevenuesController::class, 'fetch_data'])->name('revenue.fetch_data')->middleware([ 'role:administrator|bookingmanager_view' ]);
        Route::post('/store', [RevenuesController::class, 'store'])->name('revenue.store')->middleware([ 'role:administrator|bookingmanager_add' ]);
        Route::post('/update', [RevenuesController::class, 'update'])->name('revenue.update')->middleware([ 'role:administrator|bookingmanager_edit' ]);
        Route::post('/delete_data', [RevenuesController::class, 'delete_data'])->name('revenue.delete_data')->middleware([ 'role:administrator|bookingmanager_delete' ]);
        Route::get('show/{id}', [RevenuesController::class, 'show'])->name('revenue.show')->middleware([ 'role:administrator|bookingmanager_view' ]);
        Route::get('uploadExcelForm', [RevenuesController::class, 'uploadExcelForm'])->name('revenue.uploadExcelForm')->middleware([ 'role:administrator|bookingmanager_add' ]);
        Route::post('/uploadExcel', [RevenuesController::class, 'uploadExcel'])->name('revenue.uploadExcel')->middleware([ 'role:administrator|bookingmanager_add' ]);
        Route::get('/search', [RevenuesController::class, 'search'])->name('revenue.search')->middleware([ 'role:administrator|bookingmanager_view' ]);
        Route::get('/print', [RevenuesController::class, 'print'])->name('revenue.print')->middleware([ 'role:administrator|bookingmanager_view' ]);
        Route::get('/exportexcel', [RevenuesController::class, 'exportexcel'])->name('revenue.exportexcel')->middleware([ 'role:administrator|bookingmanager_view' ]);

    });

//Incentive
    Route::group(['prefix' => 'incentive', 'middleware' => ['role:administrator' or 'role:bookingmanager']], function () {
        Route::get('/', [IncentivesController::class, 'index'])->name('incentive.index')->middleware([ 'role:administrator|bookingmanager_view' ]);
        Route::get('/fetch_data', [IncentivesController::class, 'fetch_data'])->name('incentive.fetch_data')->middleware([ 'role:administrator|bookingmanager_view' ]);
        Route::post('/store', [IncentivesController::class, 'store'])->name('incentive.store')->middleware([ 'role:administrator|bookingmanager_add' ]);
        Route::post('/update', [IncentivesController::class, 'update'])->name('incentive.update')->middleware([ 'role:administrator|bookingmanager_edit' ]);
        Route::post('/delete_data', [IncentivesController::class, 'delete_data'])->name('incentive.delete_data')->middleware([ 'role:administrator|bookingmanager_delete' ]);
        Route::get('show/{id}', [IncentivesController::class, 'show'])->name('incentive.show')->middleware([ 'role:administrator|bookingmanager_view' ]);
        Route::get('uploadExcelForm', [IncentivesController::class, 'uploadExcelForm'])->name('incentive.uploadExcelForm')->middleware([ 'role:administrator|bookingmanager_view' ]);
        Route::post('/uploadExcel', [IncentivesController::class, 'uploadExcel'])->name('incentive.uploadExcel')->middleware([ 'role:administrator|bookingmanager_view' ]);
        Route::get('/search', [IncentivesController::class, 'search'])->name('incentive.search')->middleware([ 'role:administrator|bookingmanager_view' ]);
        Route::get('/print', [IncentivesController::class, 'print'])->name('incentive.print')->middleware([ 'role:administrator|bookingmanager_view' ]);
        Route::get('/exportexcel', [IncentivesController::class, 'exportexcel'])->name('incentive.exportexcel')->middleware([ 'role:administrator|bookingmanager_view' ]);

    });


});


