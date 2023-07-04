<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PassportAuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Middleware\IsAdmin;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('register', [PassportAuthController::class, 'register'])->name('register');
Route::post('login', [PassportAuthController::class, 'login'])->name('login');
Route::middleware(['auth:api'])->group(function () {
    Route::resource('posts', PostController::class);

    Route::prefix('settings')->group(function () {
        Route::put('/', [UserSettingsController::class, 'update'])->name('settings.update');
        Route::get('/', [UserSettingsController::class, 'index'])->name('settings.index');
    });
});
Route::group(['middleware' => [ 'admin']], function () {
    Route::resource('admin', AdminController::class);
});
