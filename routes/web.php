<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\JenisEventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('forgot', [AuthController::class, 'showForgot'])->name('password.request');
Route::post('forgot', [AuthController::class, 'forgot'])->name('password.email');
Route::post('reset', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::get('/', [WelcomeController::class, 'index']);


Route::get('/event', [EventController::class, 'index']);
Route::get('/jenis', [JenisEventController::class, 'index']);
Route::get('jenis/jEvents', [JenisEventController::class, 'getEvents'])->name('jEvents');
Route::get('jenis/create', [JenisEventController::class, 'create']);
Route::post('/store', [JenisEventController:: class, 'store' ])->name('jenis.store');
