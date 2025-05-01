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
        // $users = User::with('chats')->get();
        // dd(Auth::user());
        $user = Auth::user();
        $single_chat = null;

        // $chats = ChatUser::where('user_id', $user->id)->get();
        $chats = $user->chats()->get();
        foreach($chats as $chat) {
            // dd($chat);
            // $single_chat = Chat::find($chat->chat_id);
            if(! $chat->is_group){
                dd($chat->messages());
            }
        }
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
