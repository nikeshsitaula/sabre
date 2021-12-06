<?php

use App\Http\Controllers\Backend\Career\CareersController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\Document\DocumentsController;
use App\Http\Controllers\Backend\Education\EducationController;
use App\Http\Controllers\Backend\Employee\EmployeeController;
use App\Http\Controllers\Backend\Experience\ExperiencesController;
use App\Http\Controllers\Backend\Miscz\MisczController;
use App\Http\Controllers\Backend\Training\TrainingsController;
use App\Http\Controllers\LanguageController;

/*
 * Global Routes
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LanguageController::class, 'swap']);

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__ . '/frontend/');
});

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     * These routes can not be hit if the password is expired
     */
    include_route_files(__DIR__ . '/backend/');
});

Route::group(['middleware' => 'admin'], function () {
    include_route_files(__DIR__ . '/travel/');
});

Route::group(['middleware' => 'admin'], function () {
    include_route_files(__DIR__ . '/airlinesmanagement');
});

Route::group(['middleware' => 'admin'], function () {
    include_route_files(__DIR__ . '/booking/');
});

Route::group(['middleware' => 'admin'], function () {
    include_route_files(__DIR__ . '/accountmanagement/');
});

Route::group(['middleware' => 'admin'], function () {
    include_route_files(__DIR__ . '/product/');
});

Route::group(['middleware' => 'admin'], function () {
    include_route_files(__DIR__ . '/sales/');
});

//Employee
Route::group(['prefix' => 'employee', 'middleware' => ['role:administrator' or 'role:employeemanager']], function () {
    Route::get('/', [EmployeeController::class, 'index'])->name('employee.index')->middleware([ 'role:administrator|employeemanager_view' ]);
    Route::get('create', [EmployeeController::class, 'create'])->name('employee.create')->middleware([ 'role:administrator|employeemanager_add' ]);
    Route::post('store', [EmployeeController::class, 'store'])->name('employee.store')->middleware([ 'role:administrator|employeemanager_add' ]);
    Route::get('show/{id}', [EmployeeController::class, 'show'])->name('employee.show')->middleware([ 'role:administrator|employeemanager_view' ]);
    Route::get('edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit')->middleware([ 'role:administrator|employeemanager_edit' ]);
    Route::put('update/{id}', [EmployeeController::class, 'update'])->name('employee.update')->middleware([ 'role:administrator|employeemanager_edit' ]);
    Route::get('destroy/{id}', [EmployeeController::class, 'destroy'])->name('employee.destroy')->middleware([ 'role:administrator|employeemanager_delete' ]);
    Route::get('list/employee', [EmployeeController::class, 'listEmployees'])->name('list.employee')->middleware([ 'role:administrator|employeemanager_view' ]);
    Route::get('checkEmployeeExistence', [EmployeeController::class, 'checkEmployeeExistence'])->name('employee.checkEmployeeExistence')->middleware([ 'role:administrator|employeemanager_view' ]);
    Route::get('downloadExcel', [EmployeeController::class, 'downloadExcel'])->name('employee.downloadExcel')->middleware([ 'role:administrator|employeemanager_view' ]);

    //Experience
//    Route::group(['prefix'=>'experience','middleware' => 'admin'], function () {
//        Route::get('/', [ExperiencesController::class, 'index'])->name('experience.index');
//        Route::get('create', [ExperiencesController::class, 'create'])->name('experience.create');
//        Route::post('store', [ExperiencesController::class, 'store'])->name('experience.store');
//        Route::get('show/{id}', [ExperiencesController::class, 'show'])->name('experience.show');
//        Route::get('edit/{id}', [ExperiencesController::class, 'edit'])->name('experience.edit');
//        Route::put('update/{id}', [ExperiencesController::class, 'update'])->name('experience.update');
//        Route::get('destroy/{id}', [ExperiencesController::class,'destroy'])->name('experience.destroy');
//        Route::get('list/experience/{emp_no}', [ExperiencesController::class, 'listExperiences'])->name('list.experience');
//        Route::get('search/{emp_no}', [ExperiencesController::class, 'search'])->name('experience.search');
//        Route::get('showed/{id}', [ExperiencesController::class, 'showed'])->name('experience.showed');
//
//    });
    Route::group(['prefix' => 'experience', 'middleware' => ['role:administrator' or 'role:employeemanager']], function () {
        Route::get('/', [ExperiencesController::class, 'index'])->name('experience.index')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('/fetch_data', [ExperiencesController::class, 'fetch_data'])->name('experience.fetch_data')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::post('/store', [ExperiencesController::class, 'store'])->name('experience.store')->middleware([ 'role:administrator|employeemanager_add' ]);
        Route::post('/update', [ExperiencesController::class, 'update'])->name('experience.update')->middleware([ 'role:administrator|employeemanager_edit' ]);
        Route::post('/delete_data', [ExperiencesController::class, 'delete_data'])->name('experience.delete_data')->middleware([ 'role:administrator|employeemanager_delete' ]);
        Route::get('showed/{id}', [ExperiencesController::class, 'showed'])->name('experience.showed')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('printExperience/{id}', [ExperiencesController::class, 'printExperience'])->name('experience.printExperience')->middleware([ 'role:administrator|employeemanager_view' ]);
    });
    Route::group(['prefix' => 'career', 'middleware' => ['role:administrator' or 'role:employeemanager']], function () {
        Route::get('/', [CareersController::class, 'index'])->name('career.index')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('/fetch_data', [CareersController::class, 'fetch_data'])->name('career.fetch_data')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::post('/store', [careersController::class, 'store'])->name('career.store')->middleware([ 'role:administrator|employeemanager_add' ]);
        Route::post('/update', [CareersController::class, 'update'])->name('career.update')->middleware([ 'role:administrator|employeemanager_edit' ]);
        Route::post('/delete_data', [CareersController::class, 'delete_data'])->name('career.delete_data')->middleware([ 'role:administrator|employeemanager_delete' ]);
        Route::get('showed/{id}', [CareersController::class, 'showed'])->name('career.showed')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('printCareer/{id}', [CareersController::class, 'printCareer'])->name('career.printCareer')->middleware([ 'role:administrator|employeemanager_view' ]);
    });
    Route::group(['prefix' => 'education', 'middleware' => ['role:administrator' or 'role:employeemanager']], function () {
        Route::get('/', [EducationController::class, 'index'])->name('education.index')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('/fetch_data', [EducationController::class, 'fetch_data'])->name('education.fetch_data')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::post('/store', [EducationController::class, 'store'])->name('education.store')->middleware([ 'role:administrator|employeemanager_add' ]);
        Route::post('/update', [EducationController::class, 'update'])->name('education.update')->middleware([ 'role:administrator|employeemanager_edit' ]);
        Route::post('/delete_data', [EducationController::class, 'delete_data'])->name('education.delete_data')->middleware([ 'role:administrator|employeemanager_delete' ]);
        Route::get('showed/{id}', [EducationController::class, 'showed'])->name('education.showed')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('printEducation/{id}', [EducationController::class, 'printEducation'])->name('education.printEducation')->middleware([ 'role:administrator|employeemanager_view' ]);
    });

    Route::group(['prefix' => 'training', 'middleware' => ['role:administrator' or 'role:employeemanager']], function () {
        Route::get('/', [TrainingsController::class, 'index'])->name('training.index')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('/fetch_data', [TrainingsController::class, 'fetch_data'])->name('training.fetch_data')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::post('/store', [TrainingsController::class, 'store'])->name('training.store')->middleware([ 'role:administrator|employeemanager_add' ]);
        Route::post('/update', [TrainingsController::class, 'update'])->name('training.update')->middleware([ 'role:administrator|employeemanager_edit' ]);
        Route::post('/delete_data', [TrainingsController::class, 'delete_data'])->name('training.delete_data')->middleware([ 'role:administrator|employeemanager_delete' ]);
        Route::get('showed/{id}', [TrainingsController::class, 'showed'])->name('training.showed')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('printTraining/{id}', [TrainingsController::class, 'printTraining'])->name('training.printTraining')->middleware([ 'role:administrator|employeemanager_view' ]);
    });

    //Miscz
    Route::group(['prefix' => 'miscz', 'middleware' => ['role:administrator' or 'role:employeemanager']], function () {
        Route::get('/', [MisczController::class, 'index'])->name('miscz.index')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('/fetch_data', [MisczController::class, 'fetch_data'])->name('miscz.fetch_data')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::post('/store', [MisczController::class, 'store'])->name('miscz.store')->middleware([ 'role:administrator|employeemanager_add' ]);
        Route::post('/update', [MisczController::class, 'update'])->name('miscz.update')->middleware([ 'role:administrator|employeemanager_edit' ]);
        Route::post('/delete_data', [MisczController::class, 'delete_data'])->name('miscz.delete_data')->middleware([ 'role:administrator|employeemanager_delete' ]);
        Route::get('showed/{id}', [MisczController::class, 'showed'])->name('miscz.showed')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('printMiscz/{id}', [MisczController::class, 'printMiscz'])->name('miscz.printMiscz')->middleware([ 'role:administrator|employeemanager_view' ]);
    });

    //Documents
    Route::group(['prefix' => 'document', 'middleware' => ['role:administrator' or 'role:employeemanager']], function () {
        Route::get('/', [DocumentsController::class, 'index'])->name('document.index')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('create', [DocumentsController::class, 'create'])->name('document.create')->middleware([ 'role:administrator|employeemanager_add' ]);
        Route::post('store', [DocumentsController::class, 'store'])->name('document.store')->middleware([ 'role:administrator|employeemanager_add' ]);
        Route::get('show/{id}', [DocumentsController::class, 'show'])->name('document.show')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('edit/{id}', [DocumentsController::class, 'edit'])->name('document.edit')->middleware([ 'role:administrator|employeemanager_edit' ]);
        Route::put('update/{id}', [DocumentsController::class, 'update'])->name('document.update')->middleware([ 'role:administrator|employeemanager_edit' ]);
        Route::get('destroy/{id}', [DocumentsController::class, 'destroy'])->name('document.destroy')->middleware([ 'role:administrator|employeemanager_delete' ]);
        Route::get('list/document', [DocumentsController::class, 'listDocuments'])->name('list.document')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('search/{emp_no}', [DocumentsController::class, 'search'])->name('document.search')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('showed/{id}', [DocumentsController::class, 'showed'])->name('document.showed')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('showimage/{emp_no}', [DocumentsController::class, 'showimage'])->name('document.showimage')->middleware([ 'role:administrator|employeemanager_view' ]);
        Route::get('deleteImage/{id}', [DocumentsController::class, 'deleteImage'])->name('document.deleteImage')->middleware([ 'role:administrator|employeemanager_delete' ]);
        Route::post('addImage/{id}', [DocumentsController::class, 'addImage'])->name('document.addImage')->middleware([ 'role:administrator|employeemanager_add' ]);
        Route::get('printDocument/{id}', [DocumentsController::class, 'printDocument'])->name('document.printDocument')->middleware([ 'role:administrator|employeemanager_view' ]);

    });
    //dashboard
    Route::group(['prefix' => 'employee', 'middleware' => ['role:administrator' or 'role:employeemanager']], function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware([ 'role:administrator|employeemanager_view' ]);
    });

});


