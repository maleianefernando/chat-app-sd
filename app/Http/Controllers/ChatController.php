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

    public function store ($user_phone) {
        $user = Auth::user();
        $other_side_user = User::where('phone', $user_phone)->first();

        if($other_side_user != null){

        }
        $user = "Dosha";
        return view('chat.opened-chat', compact('user'));
    }

    public function show ($chat_id) {
        $user = Auth::user();

        $chats = $user->chats()->get();
        $chat = Chat::find($chat_id);
        $chat_users = $chat->users()->get();
        $other_side_user = null;
        if($chat->is_group == false){
            foreach($chat_users as $chat_user) {
                $other_side_user = $user->id === $chat_user->user_id ? $other_side_user : $chat_user;
            }
        }

        $messages = $chat->messages()->get();

        return view('chat.opened-chat', compact('chats', 'chat', 'chat_users', 'other_side_user', 'messages', 'user'));
    }

    public function update () {

    }

    public function destroy () {

    }
}
