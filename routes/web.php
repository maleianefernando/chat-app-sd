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

Route::get('/login', [AuthController::class, 'index'])->name('login.page');
Route::post('/signup', [AuthController::class, 'store'])->name('sign.up');

Route::prefix('/chat')->group(function () {
    Route::get('/', function () {
        return Redirect::to('/chat/index');
    });

    Route::get('/index', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/new/{user}/', [ChatController::class, 'store'])->name('chat.new');
    Route::get('/{phone_number}', [ChatController::class, 'show'])->name('chat.specific');
    Route::get('/new_group/{group}', [GroupController::class, 'store'])->name('group.new');
});

Route::get('/sms', function (TwilioService $twilio) {
    $message = $twilio->sendSms('+258845220593', 'Hello world from twilio');

    var_dump($message);
});
