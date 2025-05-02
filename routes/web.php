<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\GroupController;
use Illuminate\Support\Facades\Route;
use App\Services\TwilioService;
use Illuminate\Support\Facades\Redirect;

Route::get('/', function () {
    return Redirect::route('login.page');
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
        Route::get('/new/{chat_id}/', [ChatController::class, 'store'])->name('chat.new');
        Route::get('/{chat_id}', [ChatController::class, 'show'])->name('chat.specific');
        Route::get('/new_group/{group}', [GroupController::class, 'store'])->name('group.new');
    });
});

Route::get('/sms', function (TwilioService $twilio) {
    $message = $twilio->sendSms('+258845220593', 'Hello world from twilio');

    var_dump($message);
});
