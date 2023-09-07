<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\CalendarController;
use App\Http\Controllers\Web\FileController;
use App\Http\Controllers\Web\MailController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'web'], function() {
    Route::get('/auth/login', [AuthController::class, 'login'])->name('web.auth.login');
    Route::get('/calendar', [CalendarController::class, 'index'])->name('web.calendar');
    Route::group(['prefix' => 'mail'], function() {
        Route::get('/', [MailController::class, 'index'])->name('web.email');
        Route::get('/create', [MailController::class, 'create'])->name('web.email.create');
        Route::get('/{id}', [MailController::class, 'show'])->name('web.email.show');
        Route::get('/{id}/forward', [MailController::class, 'forward'])->name('web.email.forward');
    });
    Route::group(['prefix' => 'file'], function() {
        Route::get('/', [FileController::class, 'index'])->name('web.files');
    });
});
