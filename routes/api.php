<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\FlatController;
use App\Http\Controllers\HousingController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\SupplyController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);


////////////////////////// admin ///////////////////////////////////////
Route::group(['middleware' => ['auth:sanctum', 'admin']], function () {

    Route::group(['prefix' => 'admin'], function () {
        Route::post('/add', [UserController::class, 'addAdmin']);
        Route::get('get-all',[UserController::class, 'getAllAdmins']);
        //Route::post('/update', [UserController::class, 'updateCompany']);
        Route::delete('/delete/{id}', [UserController::class, 'deleteAdmin']);
    });

    Route::group(['prefix' => 'housing-officer'], function () {
        Route::post('/add', [UserController::class, 'addHousingOfficer']);
        Route::get('get-all',[UserController::class, 'getAllHousingOfficers']);
        //Route::post('/update', [UserController::class, 'updateCompany']);
        Route::delete('/delete/{id}', [UserController::class, 'deleteHousingOfficer']);
    });

    Route::group(['prefix' => 'company'], function () {
        Route::post('/add', [CompanyController::class, 'add']);
        Route::get('get-all',[CompanyController::class, 'getAll']);
        Route::post('/update/{id}', [CompanyController::class, 'update']);
        Route::delete('/delete/{id}', [CompanyController::class, 'delete']);
    });
});

///////////////////////////////housing officer and admin////////////////////////////

Route::group(['middleware' => ['auth:sanctum', 'housing.officer']], function (){
    Route::group(['prefix' => 'housing'], function () {
        Route::post('/add', [HousingController::class, 'add']);
        Route::get('get-all/{company_id}',[HousingController::class, 'getAll']);
        Route::post('/update/{id}', [HousingController::class, 'update']);
        Route::delete('/delete/{id}', [HousingController::class, 'delete']);
    });

    Route::group(['prefix' => 'contract'], function () {
        Route::post('/add', [ContractController::class, 'add']);
        Route::get('get-all/{housing_id}',[ContractController::class, 'getAll']);
        Route::post('/update/{id}', [ContractController::class, 'update']);
        Route::delete('/delete/{id}', [ContractController::class, 'delete']);
    });

    Route::group(['prefix' => 'attachment'], function () {
        Route::post('/add', [AttachmentController::class, 'add']);
        Route::get('get-all/{housing_id}',[AttachmentController::class, 'getAll']);
        Route::post('/update/{id}', [AttachmentController::class, 'update']);
        Route::delete('/delete/{id}', [AttachmentController::class, 'delete']);
    });

    Route::group(['prefix' => 'flat'], function () {
        Route::post('/add', [FlatController::class, 'add']);
        Route::get('get-all/{housing_id}',[FlatController::class, 'getAll']);
        Route::post('/update/{id}', [FlatController::class, 'update']);
        Route::delete('/delete/{id}', [FlatController::class, 'delete']);
    });

    Route::group(['prefix' => 'room'], function () {
        Route::post('/add', [RoomController::class, 'add']);
        Route::get('get-all/{housing_id}/{flat_id}',[RoomController::class, 'getAll']);
        Route::post('/update/{id}', [RoomController::class, 'update']);
        Route::delete('/delete/{id}', [RoomController::class, 'delete']);
    });

    Route::group(['prefix' => 'supply'], function () {
        Route::post('/add', [SupplyController::class, 'add']);
        Route::get('get-all/{company_id}',[SupplyController::class, 'getAll']);
        Route::post('/update/{id}', [SupplyController::class, 'update']);
        Route::delete('/delete/{id}', [SupplyController::class, 'delete']);
        Route::delete('/delete-image/{id}', [SupplyController::class, 'deleteImage']);
    });
});
