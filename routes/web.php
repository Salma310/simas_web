<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MyEventController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\dosen\MyEventController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\NotifikasiController;
use App\Http\Controllers\admin\EventController;

use App\Http\Controllers\dosen\EventdController;
use App\Http\Controllers\admin\ProfileController;
use App\Http\Controllers\admin\RoleUserController;
use App\Http\Controllers\pimpinan\EventpController;
use App\Http\Controllers\admin\JenisEventController;


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
    Route::get('/{id}/edit_ajax', [EventController::class, 'edit_ajax']);
    Route::get('/{id}/show_ajax', [EventController::class, 'show_ajax']);
    Route::put('/{id}/update_ajax', [EventController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [EventController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [EventController::class, 'delete_ajax']);
    Route::get('/{id}', [EventController::class, 'show']);
    Route::get('/{id}/edit', [EventController::class, 'edit']);
    Route::put('/{id}', [EventController::class, 'update']);
    Route::delete('/{id}', [EventController::class, 'destroy']);
    Route::get('/{id}/export_pdf', [EventController::class, 'export_pdf']);
});

Route::get('/profil', [ProfileController::class, 'index'])->name('profil');
Route::post('/profil/picture', [ProfileController::class, 'updatePicture'])->name('profile.update_picture');
Route::post('/profil/datadiri', [ProfileController::class, 'updateDataDiri'])->name('profile.update_data_diri');
Route::post('/profil/password', [ProfileController::class, 'updatePassword'])->name('profile.update_password');


Route::group(['prefix' => 'user'], function(){
    Route::get('/', [UserController::class, 'index']);
    Route::post('/list', [UserController::class, 'list']);
    Route::get('/create_ajax', [UserController::class, 'create_ajax']);
    Route::post('/ajax', [UserController::class, 'store_ajax']);
    Route::get('/{id}/show_ajax', [UserController::class, 'show']);
    Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);
    Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']);
    // Route::post('/', [UserController::class, 'store']);
    // Route::get('/{id}/edit', [UserController::class, 'edit']);
    // Route::put('/{id}', [UserController::class, 'update']);
    // Route::delete('/{id}', [UserController::class, 'destroy']);
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
    Route::get('/{id}', [EventpController::class, 'show']);
    Route::get('/{id}/edit', [EventpController::class, 'edit']);
    Route::put('/{id}', [EventpController::class, 'update']);
    Route::get('/{id}/edit_ajax', [EventpController::class, 'edit_ajax']);
    Route::get('/{id}/show_ajax', [EventpController::class, 'show_ajax'])->name('event.show');
    Route::put('/{id}/update_ajax', [EventpController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [EventpController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [EventpController::class, 'delete_ajax']);
    Route::delete('/{id}', [EventpController::class, 'destroy']);
}); */

Route::group(['prefix' => 'event_dosen'], function () {
    Route::get('/', [EventdController::class, 'index']);
    Route::post('/list', [EventdController::class, 'list']);
    Route::get('/create', [EventController::class, 'create']);
    Route::post('/', [EventdController::class, 'store']);
    Route::get('/create_ajax', [EventdController::class, 'create_ajax']);
    Route::post('/ajax', [EventdController::class, 'store_ajax']);
    Route::get('/{id}', [EventdController::class, 'show_ajax'])->name('dosen.event.show');
    Route::get('/{id}/edit', [EventdController::class, 'edit']);
    Route::put('/{id}', [EventdController::class, 'update']);
    Route::get('/{id}/edit_ajax', [EventdController::class, 'edit_ajax']);

    Route::get('/{id}/show_ajax', [EventdController::class, 'show_ajax']);
    Route::put('/{id}/update_ajax', [EventdController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [EventdController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [EventdController::class, 'delete_ajax']);
    Route::delete('/{id}', [EventdController::class, 'destroy']);
    Route::middleware(['auth', 'event.participant'])->group(function () {
        Route::get('/{id}/agenda', [App\Http\Controllers\dosen\AgendaController::class, 'agendaAGT'])->name('event.agendaAGT')
            ->middleware('event.jabatan:participant');

            Route::get('/{id}/agendaPIC', [App\Http\Controllers\dosen\AgendaController::class, 'index'])->name('event.agenda')
            ->middleware('event.jabatan:pic');
    });
    Route::post('/{id}/agendaPIC/list', [App\Http\Controllers\dosen\AgendaController::class, 'list'])->name('agenda.list');
    Route::post('/{id}/agenda/listAGT', [App\Http\Controllers\dosen\AgendaController::class, 'listAGT'])->name('agenda.listAGT');
    Route::get('/{id}/agenda/{id_agenda}/showAGT', [App\Http\Controllers\dosen\AgendaController::class, 'showAGT'])->name('agenda.showAGT');
    Route::post('/{id}/agenda/{id_agenda}/uploadProgress', [App\Http\Controllers\dosen\AgendaController::class, 'uploadProgress'])->name('agenda.uploadProgress');
    Route::post('/{id}/agenda/{id_agenda}/updateStatus', [App\Http\Controllers\dosen\AgendaController::class, 'updateStatus']);
    Route::post('/{id}/agenda/{id_agenda}/download/{id_document}', [App\Http\Controllers\dosen\AgendaController::class, 'download_Document'])->name('document.download');
    Route::get('/{id}/agendaPIC/create', [App\Http\Controllers\dosen\AgendaController::class, 'create'])->name('agenda.create');
    Route::post('/{id}/agendaPIC/store', [App\Http\Controllers\dosen\AgendaController::class, 'store'])->name('agenda.store');
    Route::get('/{id}/agendaPIC/{id_agenda}/edit', [App\Http\Controllers\dosen\AgendaController::class, 'edit'])->name('agenda.edit');
    Route::put('/{id}/agendaPIC/{id_agenda}/update', [App\Http\Controllers\dosen\AgendaController::class, 'update'])->name('agenda.update');
    Route::get('/{id}/agendaPIC/{id_agenda}/delete', [App\Http\Controllers\dosen\AgendaController::class, 'confirm'])->name('agenda.delete');
    Route::delete('/{id}/agendaPIC/{id_agenda}/delete', [App\Http\Controllers\dosen\AgendaController::class, 'delete']);
    Route::delete('/{id}/agendaPIC/{id_agenda}/document/{document_id}', [App\Http\Controllers\dosen\AgendaController::class, 'deleteDocument'])->name('agenda.deleteDocument');
    Route::post('/{id}/agendaPIC/generate-all-points', [App\Http\Controllers\dosen\AgendaController::class, 'generateAllPoints'])
    ->name('agenda.generate-all-points');
});
Route::group(['prefix' => 'event_pimpinan'], function () {
    Route::get('/', [EventpController::class, 'index']);
    Route::post('/list', [EventpController::class, 'list']);
    Route::get('/create', [EventpController::class, 'create']);
    Route::post('/', [EventpController::class, 'store']);
    Route::get('/create_ajax', [EventpController::class, 'create_ajax']);
    Route::post('/ajax', [EventpController::class, 'store_ajax']);
    Route::get('/{id}', [EventpController::class, 'show_ajax'])->name('event.show');
    Route::get('/{id}/edit', [EventpController::class, 'edit']);
    Route::put('/{id}', [EventpController::class, 'update']);
    Route::get('/{id}/edit_ajax', [EventpController::class, 'edit_ajax']);
    Route::get('/{id}/show_ajax', [EventpController::class, 'show_ajax']);
    Route::put('/{id}/update_ajax', [EventpController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [EventpController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [EventpController::class, 'delete_ajax']);
    Route::delete('/{id}', [EventpController::class, 'destroy']);
});

Route::get('/statistik', [StatistikController::class, 'index']);
Route::get('notifikasi_event/{id}', [NotifikasiController::class, 'indexEvent'])->name('notifikasi_event.show');
Route::get('notifikasi_pimpinan/{id}', [NotifikasiController::class, 'indexPimpinan'])->name('notifikasi_pimpinan.show');
// Route::get('/notifications/mark-as-read/{id}', [NotifikasiController::class, 'markAsRead'])->name('notifications.markAsRead');
// Route::post('/notifications/mark-as-read', [NotifikasiController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
Route::get('markAsRead', function() {
    auth()->user()->unreadNotifications->markAsRead();
    return redirect()->back();
})->name('markAsRead');


Route::group(['prefix' => 'myevent'], function () {
    Route::get('/', [MyEventController::class, 'index']);
    Route::post('/list', [MyEventController::class, 'list']);
    Route::get('/create_ajax', [MyEventController::class, 'create_ajax']);
    Route::post('/ajax', [MyEventController::class, 'store_ajax']);
    Route::get('/{id}/edit_ajax', [MyEventController::class, 'edit_ajax']);
    Route::get('/{id}/show_ajax', [MyEventController::class, 'show_ajax']);
    Route::put('/{id}/update_ajax', [MyEventController::class, 'update_ajax']);
    Route::get('/{id}/delete_ajax', [MyEventController::class, 'confirm_ajax']);
    Route::delete('/{id}/delete_ajax', [MyEventController::class, 'delete_ajax']);
    Route::get('/agenda', [MyEventController::class, 'agenda']);
    Route::post('/agenda/list', [MyEventController::class, 'agenda_list']);
    Route::get('/agenda/show', [MyEventController::class, 'agenda_show']);
    Route::get('/{id}/agenda', [MyEventController::class, 'agenda_show']);
    Route::get('/{id}/agenda/edit', [MyEventController::class, 'agenda_edit']);
    Route::get('/{id}/agenda/update', [MyEventController::class, 'agenda_update']);
    Route::get('/{id}/agenda/delete', [MyEventController::class, 'agenda_delconfirm']);
    Route::get('/{id}/agenda/delete', [MyEventController::class, 'agenda_delete']);
    // Route::get('/non-jti', [MyEventController::class, 'indexNonJTI'])->name('non-jti.index'); // Daftar event Non-JTI
    Route::get('/non-jti/add', [MyEventController::class, 'createNonJTI'])->name('non-jti.create'); // Form tambah Non-JTI
    Route::post('/non-jti/add', [MyEventController::class, 'storeNonJTI'])->name('non-jti.store'); // Proses tambah Non-JTI
    Route::get('/non-jti/{id}/detail', [MyEventController::class, 'detailNonJTI'])->name('non-jti.detail'); // Form detail Non-JTI

});


// Route::group(['prefix' => 'agenda'], function () {
//     Route::get('/', [AgendaController::class, 'index']);
//     Route::post('/list', [AgendaController::class, 'list']);
//     Route::get('/create_ajax', [AgendaController::class, 'create_ajax']);
//     Route::post('/ajax', [AgendaController::class, 'store_ajax']);
//     Route::get('/{id}/edit_ajax', [AgendaController::class, 'edit_ajax']);
//     Route::get('/{id}/show_ajax', [AgendaController::class, 'show_ajax']);
//     Route::put('/{id}/update_ajax', [AgendaController::class, 'update_ajax']);
//     Route::get('/{id}/delete_ajax', [AgendaController::class, 'confirm_ajax']);
//     Route::delete('/{id}/delete_ajax', [AgendaController::class, 'delete_ajax']);
// });
Route::get('/statistik', [StatistikController::class, 'index']);
