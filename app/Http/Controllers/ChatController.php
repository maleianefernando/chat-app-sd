<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index () {
        return view('chat.index');
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
