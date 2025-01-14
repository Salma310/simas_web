<?php


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\RoleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
Route::get('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
// Route::middleware('auth:sanctum')->get('/user', [LoginController::class, 'getUser'])->name('user');

Route::get('roles', [RoleController::class, 'index']);
Route::post('roles', [RoleController::class, 'store']);
Route::get('roles/{role}', [RoleController::class, 'show']);
Route::put('roles/{role}', [RoleController::class, 'update']);
Route::delete('roles/{role}', [RoleController::class, 'destroy']);

Route::get('users', [App\Http\Controllers\Api\UserController::class, 'index']);
Route::post('users', [App\Http\Controllers\Api\UserController::class, 'store']);
Route::get('users/{user_id}', [App\Http\Controllers\Api\UserController::class, 'show']);
Route::put('users/{user_id}', [App\Http\Controllers\Api\UserController::class, 'update']);
Route::delete('users/{user}', [App\Http\Controllers\Api\UserController::class, 'destroy']);
Route::put('users/change-password/{user}', [App\Http\Controllers\Api\UserController::class, 'changePassword']);
Route::put('users/update-profile/{user}', [App\Http\Controllers\Api\UserController::class, 'updateProfile']);
Route::put('users/update-picture/{user}', [App\Http\Controllers\Api\UserController::class, 'updatePicture']);


Route::get('events/type', [App\Http\Controllers\Api\EventController::class, 'eventType']);
Route::get('events', [App\Http\Controllers\Api\EventController::class, 'index']);
Route::post('events', [App\Http\Controllers\Api\EventController::class, 'store']);
Route::get('events/{event}', [App\Http\Controllers\Api\EventController::class, 'show']);
Route::put('events/{event}', [App\Http\Controllers\Api\EventController::class, 'update']);
Route::delete('events/{event}', [App\Http\Controllers\Api\EventController::class, 'destroy']);
Route::get('/events/user/{user_id}', [App\Http\Controllers\Api\EventController::class, 'getUserEvents']);
Route::get('events/{event}/agenda', [App\Http\Controllers\Api\EventController::class, 'showAgenda']);
Route::patch('/agenda/{id}/status', [App\Http\Controllers\Api\EventController::class, 'updateStatus']);


Route::post("all_data", [App\Http\Controllers\Api\NotifikasiController::class, 'index']);
Route::post("show_data", [App\Http\Controllers\Api\NotifikasiController::class, 'show']);

Route::post("all_roles", [App\Http\Controllers\Api\RoleController::class, 'index']);
Route::post("show_roles", [App\Http\Controllers\Api\RoleController::class, 'show']);


Route::prefix('pimpinan')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('dosen-chart-event', [App\Http\Controllers\Api\PimpinanDashboardController::class, 'getDosenEventChart']);
    });
});


// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\Api\RoleController;

// /*
// |--------------------------------------------------------------------------
// | API Routes
// |--------------------------------------------------------------------------
// |
// | Here is where you can register API routes for your application. These
// | routes are loaded by the RouteServiceProvider and all of them will
// | be assigned to the "api" middleware group. Make something great!
// |
// */

// // Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
// //     return $request->user();
// // });

// Route::post('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
// Route::get('/login', App\Http\Controllers\Api\LoginController::class)->name('login');
// Route::post('/logout', App\Http\Controllers\Api\LogoutController::class)->name('logout');
// // Route::middleware('auth:sanctum')->get('/user', [LoginController::class, 'getUser'])->name('user');

// Route::get('roles', [RoleController::class, 'index']);
// Route::post('roles', [RoleController::class, 'store']);
// Route::get('roles/{role}', [RoleController::class, 'show']);
// Route::put('roles/{role}', [RoleController::class, 'update']);
// Route::delete('roles/{role}', [RoleController::class, 'destroy']);

// Route::get('users', [App\Http\Controllers\Api\UserController::class, 'index']);
// Route::post('users', [App\Http\Controllers\Api\UserController::class, 'store']);
// Route::get('users/{user}', [App\Http\Controllers\Api\UserController::class, 'show']);
// Route::put('users/{user}', [App\Http\Controllers\Api\UserController::class, 'update']);
// Route::delete('users/{user}', [App\Http\Controllers\Api\UserController::class, 'destroy']);

// Route::get('events', [App\Http\Controllers\Api\EventController::class, 'index']);
// Route::post('events', [App\Http\Controllers\Api\EventController::class, 'store']);
// Route::get('events/{event}', [App\Http\Controllers\Api\EventController::class, 'show']);
// Route::put('events/{event}', [App\Http\Controllers\Api\EventController::class, 'update']);
// Route::delete('events/{event}', [App\Http\Controllers\Api\EventController::class, 'destroy']);

// Route::post("all_data", [App\Http\Controllers\Api\NotifikasiController::class, 'index']);
// Route::post("show_data", [App\Http\Controllers\Api\NotifikasiController::class, 'show']);

// Route::post("all_roles", [App\Http\Controllers\Api\RoleController::class, 'index']);
// Route::post("show_roles", [App\Http\Controllers\Api\RoleController::class, 'show']);