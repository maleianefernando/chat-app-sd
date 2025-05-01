<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index () {
        $user = Auth::user();
        $chats = $user->chats()->get();
        return view('chat.index', compact('chats'));
    }

    public function store ($user) {
        $user = "Dosha";
        return view('chat.opened-chat', compact('user'));
    }

    public function show ($phone_number) {
        $chat = 0;
        return view('chat.opened-chat', compact('chat'));
    }

    public function update () {

    }

    public function destroy () {

    }
}
