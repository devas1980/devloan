<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\rolecontroller;
use App\Http\Controllers\LoanController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register',[RegisteredUserController::class,'store']);
Route::post('/login',[RegisteredUserController::class,'login']);
Route::post('/role',[rolecontroller::class,'store']);
Route::post('/loan_apply',[LoanController::class,'loan_apply']);
Route::post('/loan_approve',[LoanController::class,'loan_approve']);
Route::post('/adminlogin',[LoanController::class,'adminlogin']);

