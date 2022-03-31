<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/',[App\Http\Controllers\Admin\Auth\AuthController::class,'index'])->name('login');
Route::post('do-login',[App\Http\Controllers\Admin\Auth\AuthController::class,'create'])->name('doLogin');
Route::get('logout',[App\Http\Controllers\Admin\Auth\AuthController::class,'logout'])->name('logout');
Route::get('forgot-password',[App\Http\Controllers\Admin\Auth\AuthController::class,'forgotPassword'])->name('forgot_password');
Route::post('do-forgot-password',[App\Http\Controllers\Admin\Auth\AuthController::class,'doForgotPassword'])->name('doForgotPassword');
Route::get('reset-password/{token}',[App\Http\Controllers\Admin\Auth\AuthController::class,'resetPassword'])->name('reset_password');
Route::post('do-reset-password',[App\Http\Controllers\Admin\Auth\AuthController::class,'doResetPassword'])->name('doResetPassword');

Route::middleware('auth')->group(function () {
    
    Route::get('/dashboard', [App\Http\Controllers\Admin\Dashboard\DashboardController::class, 'index'])->name('dashboard.index');

    //Categories Related Routes


    Route::name('category.')->prefix('category')->group( function () {   

        Route::get('/', [App\Http\Controllers\Admin\Category\CategoryController::class, 'index'])->name('index');

        Route::get('add', [App\Http\Controllers\Admin\Category\CategoryController::class, 'create'])->name('create');

        Route::post('store', [App\Http\Controllers\Admin\Category\CategoryController::class, 'store'])->name('store');


        Route::get('edit/{id}', [App\Http\Controllers\Admin\Category\CategoryController::class, 'edit'])->name('edit');


        Route::post('update', [App\Http\Controllers\Admin\Category\CategoryController::class, 'update'])->name('update');

        Route::get('delete/{id}', [App\Http\Controllers\Admin\Category\CategoryController::class, 'delete'])->name('delete');

        Route::get('detail/{id}', [App\Http\Controllers\Admin\Category\CategoryController::class, 'detail'])->name('detail');
        
        Route::get('search',[App\Http\Controllers\Admin\Category\CategoryController::class,'search'])->name('search');

    });


    //Sub Categories Related Routes


    Route::name('subcategory.')->prefix('subcategory')->group( function () {   

        Route::get('/', [App\Http\Controllers\Admin\SubCategory\SubCategoryController::class, 'index'])->name('index');

        Route::get('add', [App\Http\Controllers\Admin\SubCategory\SubCategoryController::class, 'create'])->name('create');

        Route::post('store', [App\Http\Controllers\Admin\SubCategory\SubCategoryController::class, 'store'])->name('store');


        Route::get('edit/{id}', [App\Http\Controllers\Admin\SubCategory\SubCategoryController::class, 'edit'])->name('edit');


        Route::post('update', [App\Http\Controllers\Admin\SubCategory\SubCategoryController::class, 'update'])->name('update');


        Route::get('delete/{id}', [App\Http\Controllers\Admin\SubCategory\SubCategoryController::class, 'delete'])->name('delete');



        Route::get('detail/{id}', [App\Http\Controllers\Admin\SubCategory\SubCategoryController::class, 'detail'])->name('detail');

         Route::get('search',[App\Http\Controllers\Admin\SubCategory\SubCategoryController::class,'search'])->name('search');
    }); 




    //Occupation Related Routes


    Route::name('occupation.')->prefix('occupation')->group( function () {   

        Route::get('/', [App\Http\Controllers\Admin\Occuption\OccuptionController::class, 'index'])->name('index');

        Route::get('add', [App\Http\Controllers\Admin\Occuption\OccuptionController::class, 'create'])->name('create');

        Route::post('store', [App\Http\Controllers\Admin\Occuption\OccuptionController::class, 'store'])->name('store');


        Route::get('edit/{id}', [App\Http\Controllers\Admin\Occuption\OccuptionController::class, 'edit'])->name('edit');


        Route::post('update', [App\Http\Controllers\Admin\Occuption\OccuptionController::class, 'update'])->name('update');


        Route::get('delete/{id}', [App\Http\Controllers\Admin\Occuption\OccuptionController::class, 'delete'])->name('delete');

        Route::get('detail/{id}', [App\Http\Controllers\Admin\Occuption\OccuptionController::class, 'detail'])->name('detail');

         Route::get('search',[App\Http\Controllers\Admin\Occuption\OccuptionController::class,'search'])->name('search');
    }); 



    //Sub Occupation Related Routes


    Route::name('suboccupation.')->prefix('suboccupation')->group( function () {   

        Route::get('/', [App\Http\Controllers\Admin\SubOccupation\SubOccupationController::class, 'index'])->name('index');

        Route::get('add', [App\Http\Controllers\Admin\SubOccupation\SubOccupationController::class, 'create'])->name('create');

        Route::post('store', [App\Http\Controllers\Admin\SubOccupation\SubOccupationController::class, 'store'])->name('store');


        Route::get('edit/{id}', [App\Http\Controllers\Admin\SubOccupation\SubOccupationController::class, 'edit'])->name('edit');


        Route::post('update', [App\Http\Controllers\Admin\SubOccupation\SubOccupationController::class, 'update'])->name('update');


        Route::get('delete/{id}', [App\Http\Controllers\Admin\SubOccupation\SubOccupationController::class, 'delete'])->name('delete');



        Route::get('detail/{id}', [App\Http\Controllers\Admin\SubOccupation\SubOccupationController::class, 'detail'])->name('detail');

         Route::get('search',[App\Http\Controllers\Admin\SubOccupation\SubOccupationController::class,'search'])->name('search');
    }); 

    // Users Related Routes


    Route::name('users.')->prefix('users')->group( function () {   

        Route::get('/', [App\Http\Controllers\Admin\User\UsersController::class, 'index'])->name('index');


        Route::get('edit/{id}', [App\Http\Controllers\Admin\User\UsersController::class, 'edit'])->name('edit');


        Route::post('update', [App\Http\Controllers\Admin\User\UsersController::class, 'update'])->name('update');



        Route::get('delete/{id}', [App\Http\Controllers\Admin\User\UsersController::class, 'delete'])->name('delete');


        Route::get('detail/{id}', [App\Http\Controllers\Admin\User\UsersController::class, 'detail'])->name('detail');


        Route::get('change-status/{id}/{status}', [App\Http\Controllers\Admin\User\UsersController::class, 'changeStatus']);


        Route::get('search',[App\Http\Controllers\Admin\User\UsersController::class,'search'])->name('search');

        Route::get('Usercsv/{id}', [App\Http\Controllers\Admin\User\UsersController::class, 'Usercsv']);
        Route::get('Sleepcsv/{id}', [App\Http\Controllers\Admin\User\UsersController::class, 'Sleepcsv']);
        Route::get('Heartcsv/{id}', [App\Http\Controllers\Admin\User\UsersController::class, 'Heartcsv']);
       
       
    }); 


    //Healths Related Routes


    Route::name('health.')->prefix('health')->group( function () {   

        Route::get('/', [App\Http\Controllers\Admin\Health\HealthController::class, 'index'])->name('index');

        Route::get('useractivity/{id}', [App\Http\Controllers\Admin\Health\HealthController::class, 'useractivity'])->name('useractivity');

        Route::get('add', [App\Http\Controllers\Admin\Health\HealthController::class, 'create'])->name('create');

        Route::post('store', [App\Http\Controllers\Admin\Health\HealthController::class, 'store'])->name('store');


        Route::get('edit/{id}', [App\Http\Controllers\Admin\Health\HealthController::class, 'edit'])->name('edit');


        Route::post('update', [App\Http\Controllers\Admin\Health\HealthController::class, 'update'])->name('update');

        Route::get('delete/{id}', [App\Http\Controllers\Admin\Health\HealthController::class, 'delete'])->name('delete');

        Route::get('detail/{id}', [App\Http\Controllers\Admin\Health\HealthController::class, 'detail'])->name('detail');
        
        Route::get('search',[App\Http\Controllers\Admin\Health\HealthController::class,'search'])->name('search');

    });


    //Log Related Routes


    Route::name('log.')->prefix('log')->group( function () {   

        Route::get('/', [App\Http\Controllers\Admin\Log\LogController::class, 'index'])->name('index');
       
        Route::get('userlog/{id}', [App\Http\Controllers\Admin\Log\LogController::class, 'userlog'])->name('userlog');
        Route::get('add', [App\Http\Controllers\Admin\Log\LogController::class, 'create'])->name('create');

        Route::post('store', [App\Http\Controllers\Admin\Log\LogController::class, 'store'])->name('store');


        Route::get('edit/{id}', [App\Http\Controllers\Admin\Log\LogController::class, 'edit'])->name('edit');


        Route::post('update', [App\Http\Controllers\Admin\Log\LogController::class, 'update'])->name('update');

        Route::get('delete/{id}', [App\Http\Controllers\Admin\Log\LogController::class, 'delete'])->name('delete');

        Route::get('detail/{id}', [App\Http\Controllers\Admin\Log\LogController::class, 'detail'])->name('detail');
        
        Route::get('search',[App\Http\Controllers\Admin\Log\LogController::class,'search'])->name('search');

    });


});
