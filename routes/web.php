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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/admin/register',[RegisterController::class,"create"])->name('admin.register.get');
Route::post('/admin/register',[RegisterController::class,"register"])->name('admin.register.post');

Route::get('/admin/login',[LoginController::class,"show"])->name('admin.login.show');
Route::post('/admin/login',[LoginController::class,"login"])->name('admin.login.post');

Route::get('/admin',[DashboardController::class,"show"])->name('admin.dashboard');
//Route::post();

require __DIR__.'/auth.php';
