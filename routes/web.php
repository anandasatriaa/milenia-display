<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DisplayTGRController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\TGR\BannerTGRController;
use App\Http\Controllers\Admin\TGR\VideoTGRController;
use App\Http\Controllers\Admin\TGR\RunningtextTGRController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/tgr', [DisplayTGRController::class, 'index'])->name('tgr');

Route::get('/pb', function () {
    return view('display-pb');
})->name('pb');


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
});