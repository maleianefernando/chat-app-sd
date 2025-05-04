<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = User::all();
        $chats = $user->chats()->get();
        return view('chat.index', compact('chats', 'users'));
    }

    public function store($user_phone)
    {
        $user = Auth::user();
        $users = User::all();
        $other_side_user = User::where('phone', $user_phone)->first();

        $chats = $user->chats()->get();
        $chat = null;

        if($other_side_user) {
            foreach($chats as $each_chat) {
                $check_user = ChatUser::where('chat_id', $each_chat->id)->where('user_id', $other_side_user->id)->first();
                if($check_user){
                    $chat = Chat::find($check_user->chat_id)->first();
                    $chat_users = $chat->users()->get();
                    $messages = $chat->messages()->get();

                    return view('chat.opened-chat', compact('chats', 'chat', 'chat_users', 'other_side_user', 'messages', 'user', 'users'));
                }
            }

            $chat = Chat::create([
                'is_group' => false,
                'name' => '',
                'created_by' => $user->id,
            ]);
            $messages = $chat->messages()->get();

            // $chat_users = ChatUser::create([
            //     'chat_id' => $chat->id,
            //     'user_id' => $user->id
            // ]);
                        // $chat_users = ChatUser::create([
            //     'chat_id' => $chat->id,
            //     'user_id' => $other_side_user->id
            // ]);

            return view('chat.opened-chat', compact('chats', 'chat', 'other_side_user', 'messages', 'user', 'users'));
        }
    }

    public function show($chat_id)
    {
        $user = Auth::user();
        $users = User::all();

        $chats = $user->chats()->get();
        $chat = Chat::find($chat_id);
        $chat_users = $chat->users()->get();
        $other_side_user = null;
        if ($chat->is_group == false) {
            foreach ($chat_users as $chat_user) {
                $other_side_user = $user->id === $chat_user->user_id ? $other_side_user : $chat_user;
            }
        }

        $messages = $chat->messages()->get();

        return view('chat.opened-chat', compact('chats', 'chat', 'chat_users', 'other_side_user', 'messages', 'user', 'users'));
    }

    public function update() {}

    public function destroy() {}
}
