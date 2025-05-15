<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    return Redirect::route('login');
});

Route::prefix('/login')->group(function () {
    Route::get('/', function () {
        return Redirect::route('login.phone');
    })->name('login');

    Route::get('/phone', [AuthController::class, 'phone_form'])->name('login.phone');
    Route::get('/code', [AuthController::class, 'code_form'])->name('login.code');
});

Route::post('/signup/phone', [AuthController::class, 'loginPhone'])->name('signup.phone');
Route::post('/signup/code', [AuthController::class, 'store'])->name('signup.code');

Route::middleware(['web', 'auth'])->group(function () {
    Route::prefix('/chat')->group(function () {
        Route::get('/', function () {
            return Redirect::route('chat.index');
        });

        Route::get('/index', [ChatController::class, 'index'])->name('chat.index');
        Route::get('/{chat_id}', [ChatController::class, 'show'])->name('chat.specific');
        Route::post('/new/{user_phone}/', [ChatController::class, 'store'])->name('chat.new');
        Route::get('/new_group/{group}', [GroupController::class, 'store'])->name('group.new');
    });

    Route::prefix('/msg')->group(function () {
        Route::post('/send', [MessageController::class, 'store'])->name('message.send');
    });
});

Route::get('/sms', function (TwilioService $twilio) {
    $message = $twilio->sendSms('+258845220593', 'Hello world from twilio');

    var_dump($message);
});
