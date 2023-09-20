<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\CalendarController;
use App\Http\Controllers\Web\GroupController;
use App\Http\Controllers\Web\MailController;
use App\Http\Controllers\Web\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return ['Laravel' => app()->version()];
});

require __DIR__.'/auth.php';
Route::group(['prefix' => 'web'], function() {
    Route::group(['prefix' => 'auth'], function() {
        Route::get('login', [AuthController::class, 'login'])->name('web.auth.login');
    });

    Route::group(['prefix' => 'users'], function() {
        Route::get('my', [UserController::class, 'my'])->name('web.users.my');
    });

    Route::group(['prefix' => 'mails'], function() {
        Route::get('/', [MailController::class, 'index'])->name('web.mails.index');
        Route::get('/create', [MailController::class, 'create'])->name('web.mails.create');
        Route::get('/mailbox', [MailController::class, 'checkMailbox'])->name('web.mails.mailbox');
        Route::get('/{mailId}', [MailController::class, 'show'])->name('web.mails.show');
    });

    Route::group(['prefix' => 'calendars'], function() {
        Route::get('/', [CalendarController::class, 'index'])->name('web.calendars.index');
    });

    Route::group(['prefix' => 'groups'], function() {
        Route::get('/', [GroupController::class, 'index'])->name('web.groups.index');
        Route::get('/create', [GroupController::class, 'create'])->name('web.groups.create');
        Route::get('/{groupId}/add', [GroupController::class, 'add'])->name('web.groups.add');
        Route::get('/{groupId}/detail', [GroupController::class, 'detail'])->name('web.groups.detail');
        Route::get('/{groupId}/edit', [GroupController::class, 'edit'])->name('web.groups.edit');
    });
});
