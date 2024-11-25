<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\EventController;
use App\Http\Controllers\pimpinan\EventpController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\admin\JenisEventController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\RoleUserController;
use App\Http\Controllers\StatistikController;


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
Route::post('reset', [AuthController::class, 'forgot'])->name('password.reset');
Route::get('/dashboard', [WelcomeController::class, 'index']);

Route::get('/notifikasi', [NotifikasiController::class, 'index']);


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
Route::post('/profil/picture', [ProfileController::class, 'updatePicture'])->name('profile.update_picture');
Route::post('/profil/datadiri', [ProfileController::class, 'updateDataDiri'])->name('profile.update_data_diri');
Route::post('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.update_password');


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

/*Route::group(['prefix' => 'event_pimpinan'], function () {
    Route::get('/', [EventpController::class, 'index']);
    Route::post('/list', [EventpController::class, 'list']);
    Route::get('/create', [EventpController::class, 'create']);
    Route::post('/', [EventpController::class, 'store']);
    Route::get('/create_ajax', [EventpController::class, 'create_ajax']);
    Route::post('/ajax', [EventpController::class, 'store_ajax']);
    Route::get('/{id}', [EventpController::class, 'show'])->name('event.show');
    Route::get('/{id}/edit', [EventpController::class, 'edit']);
    Route::put('/{id}', [EventpController::class, 'update']);
    Route::get('/{id}/edit_ajax', [EventpController::class, 'edit_ajax']);
    Route::get('/{id}/show_ajax', [EventpController::class, 'show_ajax']);
    Route::put('/{id}/update_ajax', [EventpController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [EventpController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [EventpController::class, 'delete_ajax']);
    Route::delete('/{id}', [EventpController::class, 'destroy']);
}); */

Route::group(['prefix' => 'event_pimpinan'], function () {
    Route::get('/', [EventpController::class, 'index']);
    Route::post('/list', [EventpController::class, 'list']);
    Route::get('/create', [EventpController::class, 'create']);
    Route::post('/', [EventpController::class, 'store']);
    Route::get('/create_ajax', [EventpController::class, 'create_ajax']);
    Route::post('/ajax', [EventpController::class, 'store_ajax']);
    Route::get('/{id}', [EventpController::class, 'show'])->name('event.show');
    Route::get('/{id}/edit', [EventpController::class, 'edit']);
    Route::put('/{id}', [EventpController::class, 'update']);
    Route::get('/{id}/edit_ajax', [EventpController::class, 'edit_ajax']);
    Route::get('/{id}/show_ajax', [EventpController::class, 'show_ajax']);
    Route::put('/{id}/update_ajax', [EventpController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [EventpController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [EventpController::class, 'delete_ajax']);
    Route::delete('/{id}', [EventpController::class, 'destroy']);
});

Route::group(['prefix' => 'event_non_jti'], function () {
    // Rute untuk Event Non-JTI
    Route::get('/non-jti', [EventController::class, 'indexNonJTI'])->name('event.non-jti.index'); // Daftar event Non-JTI
    Route::get('/non-jti/add', [EventController::class, 'createNonJTI'])->name('event.non-jti.create'); // Form tambah Non-JTI
    Route::post('/non-jti/add', [EventController::class, 'storeNonJTI'])->name('event.non-jti.store'); // Proses tambah Non-JTI
    Route::get('/non-jti/{id}/edit', [EventController::class, 'editNonJTI'])->name('event.non-jti.edit'); // Form edit Non-JTI
    Route::put('/non-jti/{id}', [EventController::class, 'updateNonJTI'])->name('event.non-jti.update'); // Proses edit Non-JTI
});

Route::get('/statistik', [StatistikController::class, 'index']);