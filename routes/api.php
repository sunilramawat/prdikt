<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::group(['middleware' => 'api' ], function () {
    
    Route::post('/verified-code',[App\Http\Controllers\API\AuthController::class,'verify']);
    Route::post('/register',[App\Http\Controllers\API\AuthController::class,'register']);
    Route::post('/forgot-password',[App\Http\Controllers\API\AuthController::class,'doForgotPassword']);
    Route::post('/reset-password',[App\Http\Controllers\API\AuthController::class,'doResetPassword']);
    Route::post('/social-login',[App\Http\Controllers\API\AuthController::class,'socialLogin']);
    Route::get('/trems',[App\Http\Controllers\API\AuthController::class,'trems']);
    
    Route::post('/pywebhook',[App\Http\Controllers\API\AuthController::class,'pywebhook']);
    
    Route::get('/generate-csv',[App\Http\Controllers\API\ActvitiesController::class,'generateCsvForHeathData']);


    Route::group(['middleware' => 'JwtMiddleware' ],function () {

        Route::name('user.')->prefix('user')->group( function () {  
           
            Route::get('/profile',[App\Http\Controllers\API\AuthController::class,'getProfile']);

            Route::post('/edit-profile',[App\Http\Controllers\API\AuthController::class,'editProfile']);

            Route::post('/send-reset-delete-otp',[App\Http\Controllers\API\AuthController::class,'sendResetDeleteOtp']);

            Route::post('/delete-or-reset-account',[App\Http\Controllers\API\AuthController::class,'deleteOrResetAccount']);

        }); 


        Route::name('activities.')->prefix('activities')->group( function () {  
            Route::post('/edit',[App\Http\Controllers\API\ActvitiesController::class,'editActvities']);
            Route::post('/add-health-activity',[App\Http\Controllers\API\ActvitiesController::class,'sleepData']);

            Route::post('/add-heart-activity',[App\Http\Controllers\API\ActvitiesController::class,'exerciseData']);

            Route::post('/list',[App\Http\Controllers\API\ActvitiesController::class,'activitiesList']);
           
            
            Route::post('/view',[App\Http\Controllers\API\ActvitiesController::class,'ViewList']);

            Route::post('/sleep-chart',[App\Http\Controllers\API\ActvitiesController::class,'sleepChart']);
            
            Route::post('/checkPy',[App\Http\Controllers\API\ActvitiesController::class,'checkPy']);
            
            Route::post('/get-graph',[App\Http\Controllers\API\ActvitiesController::class,'createGraph']);
            Route::post('/get-graph-sleep',[App\Http\Controllers\API\ActvitiesController::class,'createGraphSleep']);
            
            Route::post('/getlastData',[App\Http\Controllers\API\ActvitiesController::class,'getlastData']);


        }); 


        Route::name('feedback.')->prefix('feedback')->group( function () {  
            
            Route::get('/list',[App\Http\Controllers\API\FeedbackController::class,'list']);
            
            Route::post('/add',[App\Http\Controllers\API\FeedbackController::class,'addFeedback']);
        }); 

        

        
 
    });

});