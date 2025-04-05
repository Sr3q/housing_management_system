<?php

use App\Http\Controllers\CompanyController;
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
        Route::post('/add/{company_id}', [UserController::class, 'addHousingOfficer']);
        Route::get('get-all',[UserController::class, 'getAllHousingOfficers']);
        //Route::post('/update', [UserController::class, 'updateCompany']);
        Route::delete('/delete/{id}', [UserController::class, 'deleteHousingOfficer']);
    });

    Route::group(['prefix' => 'company'], function () {
        Route::post('/add', [companyController::class, 'addCompany']);
        Route::get('get-all',[companyController::class, 'getAllCompanies']);
        Route::post('/update', [companyController::class, 'updateCompany']);
        Route::delete('/delete/{id}', [companyController::class, 'deleteCompany']);
    });
});
