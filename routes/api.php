<?php

use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\HousingController;
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
        Route::post('/add', [CompanyController::class, 'addCompany']);
        Route::get('get-all',[CompanyController::class, 'getAllCompanies']);
        Route::post('/update/{id}', [CompanyController::class, 'updateCompany']);
        Route::delete('/delete/{id}', [CompanyController::class, 'deleteCompany']);
    });
});

Route::group(['middleware' => ['auth:sanctum', 'housing.officer']], function (){
    Route::group(['prefix' => 'housing'], function () {
        Route::post('/add', [HousingController::class, 'addHousing']);
        Route::get('get-all/{company_id}',[HousingController::class, 'getAllHousing']);
        Route::post('/update/{id}', [HousingController::class, 'updateHousing']);
        Route::delete('/delete/{id}', [HousingController::class, 'deleteHousing']);
    });

    Route::group(['prefix' => 'contract'], function () {
        Route::post('/add', [ContractController::class, 'addContract']);
        Route::get('get-all/{housing_id}',[ContractController::class, 'getAllContracts']);
        Route::post('/update/{id}', [ContractController::class, 'updateContract']);
        Route::delete('/delete/{id}', [ContractController::class, 'deleteContract']);
    });

    Route::group(['prefix' => 'attachment'], function () {
        Route::post('/add', [AttachmentController::class, 'addAttachment']);
        Route::get('get-all/{housing_id}',[AttachmentController::class, 'getAllAttachments']);
        Route::post('/update/{id}', [AttachmentController::class, 'updateAttachment']);
        Route::delete('/delete/{id}', [AttachmentController::class, 'deleteAttachment']);
    });
});
