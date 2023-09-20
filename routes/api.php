<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Chat\MailController;
use App\Http\Controllers\Users\CalendarController;
use App\Http\Controllers\Users\GroupController;
use App\Http\Controllers\Users\UserController;
use Illuminate\Http\Request;
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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function() {
    Route::group(['prefix' => 'auth'], function(){
        Route::post('login', [AuthController::class, 'login']);
        Route::post('token-microsoft', [AuthController::class, 'setMicrosoftToken'])->name('api.microsoft.token.set');
    });

    Route::group(['prefix' => 'users'], function() {
        Route::get('my', [UserController::class, 'my'])->name('api.users.my');
        Route::get('license', [UserController::class, 'license'])->name('api.users.license');
        Route::get('organization', [UserController::class, 'organization'])->name('api.users.organization');
        Route::get('mailboxSettings', [UserController::class, 'mailboxSettings'])->name('api.users.mailboxSettings');
    });

    Route::group(['prefix' => 'calendars'], function() {
        Route::get('/', [CalendarController::class, 'index'])->name('api.calendars');
    });

    Route::group(['prefix' => 'mails'], function() {
        Route::get('/', [MailController::class, 'index'])->name('api.mails.index');
        Route::get('/mailbox', [MailController::class, 'getMailBox'])->name('api.mails.mailbox.check');
    });

    Route::group(['prefix' => 'groups'], function() {
        Route::get('/', [GroupController::class, 'index'])->name('api.group.index');
        Route::post('/create', [GroupController::class, 'add'])->name('api.group.add');
        Route::get('/{groupId}', [GroupController::class, 'detail'])->name('api.group.detail');
        Route::get('/{groupId}/members', [GroupController::class, 'listMember'])->name('api.group.member');
        Route::post('/{groupId}/members/add', [GroupController::class, 'addMember'])->name('api.group.member.add');
    });
});
