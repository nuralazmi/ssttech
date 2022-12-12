<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\InformationController;
use App\Http\Controllers\ReportController;
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
Route::post('/login', [AuthController::class, 'login']);
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::resource('contacts', ContactController::class);
    Route::post('contacts/information/{contact_id}', [InformationController::class, 'add']);
    Route::delete('contacts/information/{contact_id}', [InformationController::class, 'remove']);
    Route::get('reports/people/location/{city_id}', [ReportController::class, 'getPeopleByLocation']);
    Route::get('reports/phones/location/{city_id}', [ReportController::class, 'getPhonesByLocation']);
});
Route::get('/contacts', [ContactController::class, 'index']);
