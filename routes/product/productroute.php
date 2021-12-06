<?php


use App\Http\Controllers\Backend\ProductsManagement\ProductAgreementController;
use App\Http\Controllers\Backend\ProductsManagement\ProductCostController;
use App\Http\Controllers\Backend\ProductsManagement\ProductCostEntryController;
use App\Http\Controllers\Backend\ProductsManagement\ProductDashboardController;
use App\Http\Controllers\Backend\ProductsManagement\ProductDescriptionController;

Route::group(['prefix' => 'products', 'middleware' => ['role:administrator' or 'role:productmanager']], function () {
    Route::get('/', [ProductDescriptionController::class, 'index'])->name('products.index')->middleware(['role:administrator|productmanager_view']);
    Route::get('create', [ProductDescriptionController::class, 'create'])->name('products.create')->middleware(['role:administrator|productmanager_add']);
    Route::post('store', [ProductDescriptionController::class, 'store'])->name('products.store')->middleware(['role:administrator|productmanager_add']);
    Route::get('show/{id}', [ProductDescriptionController::class, 'show'])->name('products.show')->middleware(['role:administrator|productmanager_view']);
    Route::get('edit/{id}', [ProductDescriptionController::class, 'edit'])->name('products.edit')->middleware(['role:administrator|productmanager_edit']);
    Route::put('update/{id}', [ProductDescriptionController::class, 'update'])->name('products.update')->middleware(['role:administrator|productmanager_edit']);
    Route::get('destroy/{id}', [ProductDescriptionController::class, 'destroy'])->name('products.destroy')->middleware(['role:administrator|productmanager_delete']);
    Route::get('list/product', [ProductDescriptionController::class, 'listProduct'])->name('list.products')->middleware(['role:administrator|productmanager_view']);
    Route::get('checkProductExistence', [ProductDescriptionController::class, 'checkProductExistence'])->name('products.checkProductExistence')->middleware(['role:administrator|productmanager_view']);
    Route::get('downloadExcel', [ProductDescriptionController::class, 'downloadExcel'])->name('products.downloadExcel')->middleware(['role:administrator|productmanager_view']);

    Route::group(['prefix' => 'productsagreement', 'middleware' => ['role:administrator' or 'role:productmanager']], function () {
        Route::get('/', [ProductAgreementController::class, 'index'])->name('productsagreement.index')->middleware(['role:administrator|productmanager_view']);
        Route::get('/fetch_data', [ProductAgreementController::class, 'fetch_data'])->name('productsagreement.fetch_data')->middleware(['role:administrator|productmanager_view']);
        Route::post('/store', [ProductAgreementController::class, 'store'])->name('productsagreement.store')->middleware(['role:administrator|productmanager_add']);
        Route::post('/update', [ProductAgreementController::class, 'update'])->name('productsagreement.update')->middleware(['role:administrator|productmanager_edit']);
        Route::post('/delete_data', [ProductAgreementController::class, 'delete_data'])->name('productsagreement.delete_data')->middleware(['role:administrator|productmanager_delete']);
        Route::get('showed/{id}', [ProductAgreementController::class, 'showed'])->name('productsagreement.showed')->middleware(['role:administrator|productmanager_view']);
        Route::get('printproductsagreement/', [ProductAgreementController::class, 'printproductsagreement'])->name('productsagreement.printproductsagreement')->middleware(['role:administrator|productmanager_view']);
    });

    Route::group(['prefix' => 'productscost', 'middleware' => ['role:administrator' or 'role:productmanager']], function () {
        Route::get('/', [ProductCostController::class, 'index'])->name('productscost.index')->middleware(['role:administrator|productmanager_view']);
        Route::get('/fetch_data', [ProductCostController::class, 'fetch_data'])->name('productscost.fetch_data')->middleware(['role:administrator|productmanager_view']);
        Route::post('/store', [ProductCostController::class, 'store'])->name('productscost.store')->middleware(['role:administrator|productmanager_add']);
        Route::post('/update', [ProductCostController::class, 'update'])->name('productscost.update')->middleware(['role:administrator|productmanager_edit']);
        Route::post('/delete_data', [ProductCostController::class, 'delete_data'])->name('productscost.delete_data')->middleware(['role:administrator|productmanager_delete']);
        Route::get('showed/{id}', [ProductCostController::class, 'showed'])->name('productscost.showed')->middleware(['role:administrator|productmanager_view']);
        Route::get('printproductscost/{id}', [ProductCostController::class, 'printproductscost'])->name('productscost.printproductscost')->middleware(['role:administrator|productmanager_view']);
        Route::get('checkAgreement', [ProductCostController::class, 'checkAgreement'])->name('productscost.checkAgreement')->middleware(['role:administrator|productmanager_view']);
        Route::get('filterAgreementDropdown', [ProductCostController::class, 'filterAgreementDropdown'])->name('productscost.filterAgreementDropdown')->middleware(['role:administrator|productmanager_view']);
    });

    Route::group(['prefix' => 'productscostentry', 'middleware' => ['role:administrator' or 'role:productmanager']], function () {
        Route::get('/', [ProductCostEntryController::class, 'index'])->name('productscostentry.index')->middleware(['role:administrator|productmanager_view']);
        Route::get('/fetch_data', [ProductCostEntryController::class, 'fetch_data'])->name('productscostentry.fetch_data')->middleware(['role:administrator|productmanager_view']);
        Route::post('/store', [ProductCostEntryController::class, 'store'])->name('productscostentry.store')->middleware(['role:administrator|productmanager_add']);
        Route::post('/update', [ProductCostEntryController::class, 'update'])->name('productscostentry.update')->middleware(['role:administrator|productmanager_edit']);
        Route::post('/delete_data', [ProductCostEntryController::class, 'delete_data'])->name('productscostentry.delete_data')->middleware(['role:administrator|productmanager_delete']);
        Route::get('showed/{id}', [ProductCostEntryController::class, 'showed'])->name('productscostentry.showed')->middleware(['role:administrator|productmanager_view']);
        Route::get('printproductscostentry/{id}', [ProductCostEntryController::class, 'printproductscostentry'])->name('productscostentry.printproductscostentry')->middleware(['role:administrator|productmanager_view']);
        Route::get('checkTravel', [ProductCostEntryController::class, 'checkTravel'])->name('productscostentry.checkTravel')->middleware(['role:administrator|productmanager_view']);
        Route::get('filterTravelDropdown', [ProductCostEntryController::class, 'filterTravelDropdown'])->name('productscostentry.filterTravelDropdown')->middleware(['role:administrator|productmanager_view']);
    });

    //dashboard
    Route::group(['prefix' => 'products', 'middleware' => ['role:administrator' or 'role:productmanager']], function () {
        Route::get('/productdashboard', [ProductDashboardController::class, 'index'])->name('productdashboard.index')->middleware(['role:administrator|productmanager_view']);
    });

});
