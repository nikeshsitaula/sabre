<?php

use App\Http\Controllers\Backend\SalesManagement\SalesController;
use App\Http\Controllers\Backend\SalesManagement\SmaDashboardController;
use App\Http\Controllers\Backend\SalesManagement\SmaOtherCostController;
use App\Http\Controllers\Backend\SalesManagement\SmaPrizeController;

Route::group(['prefix' => 'sales', 'middleware' => ['role:administrator' or 'role:salesmanager']], function () {
    Route::get('/', [SalesController::class, 'index'])->name('sales.index')->middleware(['role:administrator|salesmanager_view']);
    Route::get('create', [SalesController::class, 'create'])->name('sales.create')->middleware(['role:administrator|salesmanager_add']);
    Route::post('store', [SalesController::class, 'store'])->name('sales.store')->middleware(['role:administrator|salesmanager_add']);
    Route::get('show/{id}', [SalesController::class, 'show'])->name('sales.show')->middleware(['role:administrator|salesmanager_view']);
    Route::get('edit/{id}', [SalesController::class, 'edit'])->name('sales.edit')->middleware(['role:administrator|salesmanager_edit']);
    Route::put('update/{id}', [SalesController::class, 'update'])->name('sales.update')->middleware(['role:administrator|salesmanager_edit']);
    Route::get('destroy/{id}', [SalesController::class, 'destroy'])->name('sales.destroy')->middleware(['role:administrator|salesmanager_delete']);
    Route::get('list/sales', [SalesController::class, 'listSales'])->name('list.sales')->middleware(['role:administrator|salesmanager_view']);
    Route::get('checkSalesExistence', [SalesController::class, 'checkSalesExistence'])->name('sales.checkSalesExistence')->middleware(['role:administrator|salesmanager_view']);
    Route::get('downloadExcel', [SalesController::class, 'downloadExcel'])->name('sales.downloadExcel')->middleware(['role:administrator|salesmanager_view']);
    Route::get('daterange', [SalesController::class, 'daterange'])->name('sales.daterange')->middleware(['role:administrator|salesmanager_view']);

    Route::group(['prefix' => 'smaprize', 'middleware' => ['role:administrator' or 'role:salesmanager']], function () {
        Route::get('/', [SmaPrizeController::class, 'index'])->name('smaprize.index')->middleware([ 'role:administrator|salesmanager_view' ]);
        Route::get('/fetch_data', [SmaPrizeController::class, 'fetch_data'])->name('smaprize.fetch_data')->middleware([ 'role:administrator|salesmanager_view' ]);
        Route::post('/store', [SmaPrizeController::class, 'store'])->name('smaprize.store')->middleware([ 'role:administrator|salesmanager_add' ]);
        Route::post('/update', [SmaPrizeController::class, 'update'])->name('smaprize.update')->middleware([ 'role:administrator|salesmanager_edit' ]);
        Route::post('/delete_data', [SmaPrizeController::class, 'delete_data'])->name('smaprize.delete_data')->middleware([ 'role:administrator|salesmanager_delete' ]);
        Route::get('showed/{id}', [SmaPrizeController::class, 'showed'])->name('smaprize.showed')->middleware([ 'role:administrator|salesmanager_view' ]);
        Route::get('printsmaprize/{id}', [SmaPrizeController::class, 'printsmaprize'])->name('smaprize.printsmaprize')->middleware([ 'role:administrator|salesmanager_view' ]);
    });

    Route::group(['prefix' => 'smaothercost', 'middleware' => ['role:administrator' or 'role:salesmanager']], function () {
        Route::get('/', [SmaOtherCostController::class, 'index'])->name('smaothercost.index')->middleware([ 'role:administrator|salesmanager_view' ]);
        Route::get('/fetch_data', [SmaOtherCostController::class, 'fetch_data'])->name('smaothercost.fetch_data')->middleware([ 'role:administrator|salesmanager_view' ]);
        Route::post('/store', [SmaOtherCostController::class, 'store'])->name('smaothercost.store')->middleware([ 'role:administrator|salesmanager_add' ]);
        Route::post('/update', [SmaOtherCostController::class, 'update'])->name('smaothercost.update')->middleware([ 'role:administrator|salesmanager_edit' ]);
        Route::post('/delete_data', [SmaOtherCostController::class, 'delete_data'])->name('smaothercost.delete_data')->middleware([ 'role:administrator|salesmanager_delete' ]);
        Route::get('showed/{id}', [SmaOtherCostController::class, 'showed'])->name('smaothercost.showed')->middleware([ 'role:administrator|salesmanager_view' ]);
        Route::get('checkTravelID', [SmaOtherCostController::class, 'checkTravelID'])->name('smaothercost.checkTravelID')->middleware(['role:administrator|salesmanager_view']);
        Route::get('filterTravelDropdown', [SmaOtherCostController::class, 'filterTravelDropdown'])->name('smaothercost.filterTravelDropdown')->middleware(['role:administrator|salesmanager_view']);
        Route::get('printsmaothercost/{id}', [SmaOtherCostController::class, 'printsmaothercost'])->name('smaothercost.printsmaothercost')->middleware([ 'role:administrator|salesmanager_view' ]);
    });

    //dashboard
    Route::group(['prefix' => 'sales', 'middleware' => ['role:administrator' or 'role:salesmanager']], function () {
        Route::get('/smadashboard', [SmaDashboardController::class, 'index'])->name('smadashboard.index')->middleware(['role:administrator|salesmanager_view']);
    });
});
