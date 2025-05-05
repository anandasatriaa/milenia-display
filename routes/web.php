<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DisplayTGRController;
use App\Http\Controllers\DisplayPBController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\TGR\BannerTGRController;
use App\Http\Controllers\Admin\TGR\VideoTGRController;
use App\Http\Controllers\Admin\TGR\RunningtextTGRController;
use App\Http\Controllers\Admin\PB\BannerPBController;
use App\Http\Controllers\Admin\PB\VideoPBController;
use App\Http\Controllers\Admin\PB\RunningtextPBController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/tgr', [DisplayTGRController::class, 'index'])->name('tgr');
Route::get('/tgr/last-update', [DisplayTGRController::class, 'lastUpdate'])->name('tgr.last-update');

Route::get('/pb', [DisplayPBController::class, 'index'])->name('pb');
Route::get('/pb/last-update', [DisplayPBController::class, 'lastUpdate'])->name('pb.last-update');


Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['isLoggedIn'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    Route::get('/admin/tgr/banner', [BannerTGRController::class, 'index'])->name('admin.tgr.banner');
    Route::post('/admin/tgr/banner/store', [BannerTGRController::class, 'store'])->name('admin.tgr.banner.store');
    Route::post('/admin/tgr/banner/update-order', [BannerTGRController::class, 'updateOrder'])->name('admin.tgr.banner.update-order');
    Route::post('/admin/tgr/banner/toggle-status', [BannerTGRController::class, 'toggleStatus'])->name('admin.tgr.banner.toggle-status');
    Route::get('/admin/tgr/banner/{id}/edit', [BannerTGRController::class, 'edit'])->name('admin.tgr.banner.edit');
    Route::put('/admin/tgr/banner/{id}', [BannerTGRController::class, 'update'])->name('admin.tgr.banner.update');
    Route::delete('/admin/tgr/banner/{id}/delete', [BannerTGRController::class, 'destroy'])->name('admin.tgr.banner.delete');

    Route::get('/admin/tgr/video', [VideoTGRController::class, 'index'])->name('admin.tgr.video');
    Route::post('/admin/tgr/video/store', [VideoTGRController::class, 'store'])->name('admin.tgr.video.store');
    Route::post('/admin/tgr/video/update-order', [VideoTGRController::class, 'updateOrder'])->name('admin.tgr.video.update-order');
    Route::post('/admin/tgr/video/toggle-status', [VideoTGRController::class, 'toggleStatus'])->name('admin.tgr.video.toggle-status');
    Route::get('/admin/tgr/video/{id}/edit', [VideoTGRController::class, 'edit'])->name('admin.tgr.video.edit');
    Route::put('/admin/tgr/video/{id}', [VideoTGRController::class, 'update'])->name('admin.tgr.video.update');
    Route::delete('/admin/tgr/video/{id}/delete', [VideoTGRController::class, 'destroy'])->name('admin.tgr.video.delete');

    Route::get('/admin/tgr/runningtext', [RunningtextTGRController::class, 'index'])->name('admin.tgr.runningtext');
    Route::post('/admin/tgr/runningtext/store', [RunningtextTGRController::class, 'store'])->name('admin.tgr.runningtext.store');
    Route::post('/admin/tgr/runningtext/update-order', [RunningtextTGRController::class, 'updateOrder'])->name('admin.tgr.runningtext.update-order');
    Route::post('/admin/tgr/runningtext/toggle-status', [RunningtextTGRController::class, 'toggleStatus'])->name('admin.tgr.runningtext.toggle-status');
    Route::get('/admin/tgr/runningtext/{id}/edit', [RunningtextTGRController::class, 'edit'])->name('admin.tgr.runningtext.edit');
    Route::put('/admin/tgr/runningtext/{id}', [RunningtextTGRController::class, 'update'])->name('admin.tgr.runningtext.update');
    Route::delete('/admin/tgr/runningtext/{id}/delete', [RunningtextTGRController::class, 'destroy'])->name('admin.tgr.runningtext.delete');



    Route::get('/admin/pb/banner', [BannerPBController::class, 'index'])->name('admin.pb.banner');
    Route::post('/admin/pb/banner/store', [BannerPBController::class, 'store'])->name('admin.pb.banner.store');
    Route::post('/admin/pb/banner/update-order', [BannerPBController::class, 'updateOrder'])->name('admin.pb.banner.update-order');
    Route::post('/admin/pb/banner/toggle-status', [BannerPBController::class, 'toggleStatus'])->name('admin.pb.banner.toggle-status');
    Route::get('/admin/pb/banner/{id}/edit', [BannerPBController::class, 'edit'])->name('admin.pb.banner.edit');
    Route::put('/admin/pb/banner/{id}', [BannerPBController::class, 'update'])->name('admin.pb.banner.update');
    Route::delete('/admin/pb/banner/{id}/delete', [BannerPBController::class, 'destroy'])->name('admin.pb.banner.delete');

    Route::get('/admin/pb/video', [VideoPBController::class, 'index'])->name('admin.pb.video');
    Route::post('/admin/pb/video/store', [VideoPBController::class, 'store'])->name('admin.pb.video.store');
    Route::post('/admin/pb/video/update-order', [VideoPBController::class, 'updateOrder'])->name('admin.pb.video.update-order');
    Route::post('/admin/pb/video/toggle-status', [VideoPBController::class, 'toggleStatus'])->name('admin.pb.video.toggle-status');
    Route::get('/admin/pb/video/{id}/edit', [VideoPBController::class, 'edit'])->name('admin.pb.video.edit');
    Route::put('/admin/pb/video/{id}', [VideoPBController::class, 'update'])->name('admin.pb.video.update');
    Route::delete('/admin/pb/video/{id}/delete', [VideoPBController::class, 'destroy'])->name('admin.pb.video.delete');

    Route::get('/admin/pb/runningtext', [RunningtextPBController::class, 'index'])->name('admin.pb.runningtext');
    Route::post('/admin/pb/runningtext/store', [RunningtextPBController::class, 'store'])->name('admin.pb.runningtext.store');
    Route::post('/admin/pb/runningtext/update-order', [RunningtextPBController::class, 'updateOrder'])->name('admin.pb.runningtext.update-order');
    Route::post('/admin/pb/runningtext/toggle-status', [RunningtextPBController::class, 'toggleStatus'])->name('admin.pb.runningtext.toggle-status');
    Route::get('/admin/pb/runningtext/{id}/edit', [RunningtextPBController::class, 'edit'])->name('admin.pb.runningtext.edit');
    Route::put('/admin/pb/runningtext/{id}', [RunningtextPBController::class, 'update'])->name('admin.pb.runningtext.update');
    Route::delete('/admin/pb/runningtext/{id}/delete', [RunningtextPBController::class, 'destroy'])->name('admin.pb.runningtext.delete');
});