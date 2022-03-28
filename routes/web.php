<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\UserController;

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

// Login
Route::get('/anm/login', [LoginController::class, 'index']);
Route::post('/anm/login', [LoginController::class, 'authenticate']);

// Register
Route::post('/anm/register', [UserController::class, 'store']);

Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [UserController::class, 'index']);

    // Logout
    Route::post('/anm/logout', [LoginController::class, 'logout']);
    // List route group Administrator
    Route::middleware(['ceklogin:Admin'])->group(function () {

        Route::get('/anm/dashboard', [DashboardController::class, 'index']);
    });
});
