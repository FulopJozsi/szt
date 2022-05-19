<?php

use App\Http\Controllers\API\CompanyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\CompanyResource;
use App\Models\Company;

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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::get('/company/{ids}', [CompanyController::class, 'shows']);
Route::get('/company/activity', [CompanyController::class, 'activity']);
Route::get('/company/foundation', [CompanyController::class, 'foundation']);
Route::apiResource('company', CompanyController::class);
