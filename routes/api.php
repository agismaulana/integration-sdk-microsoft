<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Chat\ChatController;
use App\Http\Controllers\Chat\MailController;
use App\Http\Controllers\Files\DriveController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Users\ContactController;
use App\Http\Controllers\Users\PeopleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function() {
    Route::webhooks('subsriptions/success', 'subscriptions-success');

    /**
     * Users Route API
     *
     *
     * */

    // Route People API
    Route::get('users/', [PeopleController::class, 'index'])->name('microsoft.users');
    Route::get('users/{userId}', [PeopleController::class, 'show'])->name('microsoft.users.detail');
    Route::patch('users/{userId}', [PeopleController::class, 'update'])->name('microsoft.users.update');
    // Route::get('users/')

    Route::get('mails', [MailController::class, 'index'])->name('microsoft.mails');
    Route::get('mails/{mailId}', [MailController::class, 'show'])->name('micrososft.mails.show');
    Route::post('mails/send', [MailController::class, 'sendMail'])->name('microsoft.mails.send');

    // Route Contact API
    Route::get('users/contacts', [ContactController::class, 'index'])->name('microsoft.users.contact');


    // Calendar Route API
    Route::get('calendar', [CalendarController::class, 'index'])->name('microsoft.calendar');
    Route::get('calendar/{id}', [CalendarController::class, 'show'])->name('microsoft.calendar.show');
    Route::post('calendar/create', [CalendarController::class, 'create'])->name('microsoft.calendar.create');
    Route::patch('calendar/{id}/update', [CalendarController::class, 'update'])->name('microsoft.calendar.update');
    Route::delete('calendar/{id}/delete', [CalendarController::class, 'delete'])->name('microsoft.calendar.delete');

    // Drive Route API
    Route::get('drive', [DriveController::class, 'index'])->name('microsoft.drive');
    Route::get('drive/{id}', [DriveController::class, 'show'])->name('microsoft.drive.show');
    Route::get('drive/current/items', [DriveController::class, 'itemsByCurrentRootFolder'])->name('microsoft.drive.listitemsbycurrentfolder');
    Route::get('drive/current/items/{itemId}', [DriveController::class, 'getDriveItems'])->name('microsoft.drive.current.item.detail');

    //Chat Route API
    Route::get('chats', [ChatController::class, 'index'])->name('microsoft.chat');
    Route::get('chats/{chatId}', [ChatController::class, 'show'])->name('microsoft.chat.detail');
    Route::get('chats/{chatId}/messages', [ChatController::class, 'allMessages'])->name('microsoft.chat.user');
    Route::post('chats/{chatId}/messages', [ChatController::class, 'sendMessages'])->name('microsoft.chat.user.send');
    Route::patch('chats/{chatId}/messages/{messageId}', [ChatController::class, 'updateSendMessage'])->name('microsoft.chat.user.update');
    Route::delete('users/{userId}/chats/{chatId}/messages/{messageId}', [ChatController::class, 'deleteMessage'])->name('microsoft.chat.user.delete');

    // Contact Route API
    // Route::get('/')

    //Notification Route Api
    Route::get('subcriptions', [NotificationController::class, 'listSubscriptions'])->name('microsoft.subcription');
    Route::post('subcriptions/create', [NotificationController::class, 'createSubscriptions'])->name('microsoft.subscription.create');

    Route::get('me', [ProfileController::class, 'me'])->name('microsoft.me');
    Route::get('me/mail', [ProfileController::class, 'mail'])->name('microsoft.me.mail');
    Route::post('me/mail/send', [ProfileController::class, 'sendMail'])->name('microsoft.me.mail.send');
});
