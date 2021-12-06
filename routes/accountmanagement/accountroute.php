<?php

use App\Http\Controllers\Backend\AccountManagement\AccountsController;
use App\Http\Controllers\Backend\AccountManagement\AccountsDashboardController;
use App\Http\Controllers\Backend\AccountManagement\AgencyAgreementsController;
use App\Http\Controllers\Backend\AccountManagement\IncentiveDataController;
use App\Http\Controllers\Backend\AccountManagement\TimeCommitmentsController;

//accountmanagement
Route::group(['prefix' => 'accounts', 'middleware' => ['role:administrator' or 'role:accountmanagement']], function () {

    Route::get('/', [AccountsController::class, 'index'])->name('accounts.index')->middleware(['role:administrator|accountmanagement_view']);
    Route::get('/fetch_data', [AccountsController::class, 'fetch_data'])->name('accounts.fetch_data')->middleware(['role:administrator|accountmanagement_view']);
    Route::post('/store', [AccountsController::class, 'store'])->name('accounts.store')->middleware(['role:administrator|accountmanagement_add']);
    Route::post('/update', [AccountsController::class, 'update'])->name('accounts.update')->middleware(['role:administrator|accountmanagement_edit']);
    Route::post('/delete_data', [AccountsController::class, 'delete_data'])->name('accounts.delete_data')->middleware(['role:administrator|accountmanagement_delete']);
    Route::get('showed/{id}', [AccountsController::class, 'showed'])->name('accounts.showed')->middleware(['role:administrator|accountmanagement_view']);
    Route::get('printaccountsmanager/{id}', [AccountsController::class, 'printaccountsmanager'])->name('accounts.printaccountsmanager')->middleware(['role:administrator|accountmanagement_view']);

    Route::group(['prefix' => 'agencyagreement', 'middleware' => ['role:administrator' or 'role:accountmanagement']], function () {

        Route::get('/', [AgencyAgreementsController::class, 'index'])->name('agencyagreement.index')->middleware(['role:administrator|accountmanagement_view']);
        Route::get('/fetch_data', [AgencyAgreementsController::class, 'fetch_data'])->name('agencyagreement.fetch_data')->middleware(['role:administrator|accountmanagement_view']);
        Route::post('/store', [AgencyAgreementsController::class, 'store'])->name('agencyagreement.store')->middleware(['role:administrator|accountmanagement_add']);
        Route::post('/update', [AgencyAgreementsController::class, 'update'])->name('agencyagreement.update')->middleware(['role:administrator|accountmanagement_edit']);
        Route::post('/delete_data', [AgencyAgreementsController::class, 'delete_data'])->name('agencyagreement.delete_data')->middleware(['role:administrator|accountmanagement_delete']);
        Route::get('showed/{id}', [AgencyAgreementsController::class, 'showed'])->name('agencyagreement.showed')->middleware(['role:administrator|accountmanagement_view']);
        Route::get('printagencyagreement/{id}', [AgencyAgreementsController::class, 'printagencyagreement'])->name('agencyagreement.printagencyagreement')->middleware(['role:administrator|accountmanagement_view']);
    });

    Route::group(['prefix' => 'incentivedata', 'middleware' => ['role:administrator' or 'role:accountmanagement']], function () {

        Route::get('/', [IncentiveDataController::class, 'index'])->name('incentivedata.index')->middleware(['role:administrator|accountmanagement_view']);
        Route::get('/fetch_data', [IncentiveDataController::class, 'fetch_data'])->name('incentivedata.fetch_data')->middleware(['role:administrator|accountmanagement_view']);
        Route::post('/store', [IncentiveDataController::class, 'store'])->name('incentivedata.store')->middleware(['role:administrator|accountmanagement_add']);
        Route::post('/update', [IncentiveDataController::class, 'update'])->name('incentivedata.update')->middleware(['role:administrator|accountmanagement_edit']);
        Route::post('/delete_data', [IncentiveDataController::class, 'delete_data'])->name('incentivedata.delete_data')->middleware(['role:administrator|accountmanagement_delete']);
        Route::get('showed/{id}', [IncentiveDataController::class, 'showed'])->name('incentivedata.showed')->middleware(['role:administrator|accountmanagement_view']);
        Route::get('printincentivedata/{id}', [IncentiveDataController::class, 'printincentivedata'])->name('incentivedata.printtimecommitment')->middleware(['role:administrator|accountmanagement_view']);
        Route::get('printincentivedata/{id}', [IncentiveDataController::class, 'printincentivedata'])->name('incentivedata.printtimecommitment')->middleware(['role:administrator|accountmanagement_view']);
        Route::post('/updateincentivedata/{id}', [IncentiveDataController::class, 'updateincentivedata'])->name('incentivedata.updateincentivedata')->middleware(['role:administrator|accountmanagement_add']);
    });

    //scheduler
    Route::get('managerschedule', [AccountsController::class, 'managerschedule'])->name('accounts.managerschedule')->middleware(['role:administrator|accountmanagement_view']);

    //dashboard

    Route::get('/dashboard', [AccountsDashboardController::class, 'index'])->name('accountdashboard.index')->middleware(['role:administrator|accountmanagement_view']);
    Route::get('/dashboard/viewdetails', [AccountsDashboardController::class, 'viewdetails'])->name('accountdashboard.viewdetails')->middleware(['role:administrator|accountmanagement_view']);


});
