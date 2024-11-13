<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\JenisEventController;

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

Route::get('/', [WelcomeController::class, 'index']);


Route::get('/event', [EventController::class, 'index']);
Route::get('/jenis', [JenisEventController::class, 'index']);
Route::get('jenis/jEvents', [JenisEventController::class, 'getEvents'])->name('jEvents');
Route::get('jenis/create', [JenisEventController::class, 'create']);
Route::post('/ajax', [LevelController:: class, 'store' ])->name('jenis.store');
