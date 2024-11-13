<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\JenisEventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfilController;

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
// Route::post('/ajax', [LevelController:: class, 'store' ])->name('jenis.store');


Route::group(['prefix' => 'event'], function () {
    Route::get('/', [EventController::class, 'index']);              
    Route::post('/list', [EventController::class, 'list']);          
    Route::get('/create', [EventController::class, 'create']);      
    Route::post('/', [EventController::class, 'store']);            
    Route::get('/create_ajax', [EventController::class, 'create_ajax']); 
    Route::post('/ajax', [EventController::class, 'store_ajax']); 
    Route::get('/{id}', [EventController::class, 'show']);           
    Route::get('/{id}/edit', [EventController::class, 'edit']);     
    Route::put('/{id}', [EventController::class, 'update']);         
    Route::get('/{id}/edit_ajax', [EventController::class, 'edit_ajax']); 
    Route::put('/{id}/update_ajax', [EventController::class, 'update_ajax']); 
    Route::get('/{id}/delete_ajax', [EventController::class, 'confirm_ajax']); 
    Route::delete('/{id}/delete_ajax', [EventController::class, 'delete_ajax']); 
    Route::delete('/{id}', [EventController::class, 'destroy']); 
});

Route::get('/profil', [ProfilController::class, 'index'])->name('profil');

    

