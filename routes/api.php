<?php

use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Files\DriveController;
use App\Http\Controllers\ProfileController;
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

    Route::get('me', [ProfileController::class, 'me'])->name('microsoft.me');
    Route::get('mail', [ProfileController::class, 'mail'])->name('microsoft.mail');
    Route::post('mail/send', [ProfileController::class, 'sendMail'])->name('microsoft.mail.send');
});
