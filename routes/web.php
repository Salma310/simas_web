<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\JenisEventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleUserController;


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
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth');

Route::get('forgot', [AuthController::class, 'showForgot'])->name('password.request');
Route::post('forgot', [AuthController::class, 'forgot'])->name('password.email');
Route::post('reset', [AuthController::class, 'resetPassword'])->name('password.reset');
Route::get('/dashboard', [WelcomeController::class, 'index']);



Route::get('/jenis', [JenisEventController::class, 'index']);

Route::post('jenis/list', [JenisEventController::class, 'list'])->name('jenis.list');
Route::get('jenis/create', [JenisEventController::class, 'create']);
Route::post('/store', [JenisEventController::class, 'store' ])->name('jenis.store');
Route::get('jenis/{id}/edit', [JenisEventController::class, 'edit' ]);
Route::put('jenis/{id}/update', [JenisEventController::class, 'update' ])->name('jenis.update');
Route::get('jenis/{id}/delete', [JenisEventController::class, 'confirm' ]);
Route::delete('jenis/{id}/delete', [JenisEventController:: class, 'delete' ]);


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
    Route::get('/{id}/show_ajax', [EventController::class, 'show_ajax']);
    Route::put('/{id}/update_ajax', [EventController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [EventController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [EventController::class, 'delete_ajax']);
    Route::delete('/{id}', [EventController::class, 'destroy']);
});

Route::get('/profil', [ProfileController::class, 'index'])->name('profil');


Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class, 'index']);
    Route::post('/list', [UserController::class, 'list']);
    Route::post('/', [UserController::class, 'store']);
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);
    Route::post('/ajax', [UserController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [UserController::class, 'show']);
    Route::get('/{id}/edit', [UserController::class, 'edit']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
    Route::delete('/{id}', [UserController::class, 'destroy']);
});
Route::get('/profile', [ProfileController::class, 'profile']);
Route::post('/profile/update', [ProfileController::class, 'updateAvatar']);
Route::post('/profile/update_data_diri', [ProfileController::class, 'updateDataDiri']);
Route::post('/profile/update_password', [ProfileController::class, 'updatePassword']);

Route::group(['prefix' => 'role'], function () {
    Route::get('/', [RoleUserController::class, 'index']);
    Route::post('/list', [RoleUserController::class, 'list']);
    Route::get('/create_ajax', [RoleUserController::class, 'create_ajax']);
    Route::post('/store_ajax', [RoleUserController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [RoleUserController::class, 'show_ajax']);
    Route::get('/{id}/edit_ajax', [RoleUserController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [RoleUserController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [RoleUserController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [RoleUserController::class, 'delete_ajax']);
    Route::get('/export_pdf', [RoleUserController::class, 'export_pdf']);
    Route::delete('/{id}', [RoleUserController::class, 'destroy']);
});
