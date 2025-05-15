<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon;

class ChatController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $users = User::all();
        $chats = $user->chats()->get();
        $chat_names = [];
        $user_id_to_check_online = [];

        foreach ($chats as $this_chat) {
            if ($this_chat->is_group == true) {
                $chat_names["" . $this_chat->id] = $this_chat->name;
                $user_id_to_check_online[] = null;
            } else {
                $this_chat_users = $this_chat->users()->get();
                foreach ($this_chat_users as $ct_user) {
                    if ($user->id !== $ct_user->id) {
                        $usr = User::find($ct_user->id);
                        $chat_names["" . $this_chat->id] = $usr->username == null ? $usr->phone : $usr->username;
                        $user_id_to_check_online[] = $usr->id;
                    }
                }
            }
        }
        // dd($user_id_to_check_online);
        // dd($chat_names);

        return view('chat.index', compact('chats', 'chat_names', 'user_id_to_check_online', 'users', 'user'));
    }

    public function store($user_phone)
    {
        $user = Auth::user();
        $users = User::all();
        $other_side_user = User::where('phone', $user_phone)->first();

        $chats = $user->chats()->get();
        $chat = null;

        $chat_names = [];
        $user_id_to_check_online = [];
        foreach ($chats as $this_chat) {
            if ($this_chat->is_group == true) {
                $chat_names["" . $this_chat->id] = $this_chat->name;
                $user_id_to_check_online[] = null;
            } else {
                $this_chat_users = $this_chat->users()->get();
                foreach ($this_chat_users as $ct_user) {
                    if ($user->id !== $ct_user->id) {
                        $usr = User::find($ct_user->id);
                        $chat_names["" . $this_chat->id] = $usr->username == null ? $usr->phone : $usr->username;
                        $user_id_to_check_online[] = $usr->id;
                    }
                }
                // dd($user_id_to_check_online);
            }
        }

        $message_usernames = [];
        if ($other_side_user) {
            foreach ($chats as $each_chat) {
                $check_user = ChatUser::where('chat_id', $each_chat->id)->where('user_id', $other_side_user->id)->first();
                if ($check_user) {
                    $chat = Chat::where('id', $check_user->chat_id)->first();
                    $chat_users = $chat->users()->get();
                    $messages = $chat->messages()->get();
                    foreach ($messages as $msg) {
                        $__user__ = User::find($msg->user_id);
                        $message_usernames[] = [
                            "username" => $__user__->username,
                            "phone" => $__user__->phone
                        ];
                    }

                    return view('chat.opened-chat', compact('chats', 'chat', 'chat_users', 'chat_names', 'user_id_to_check_online', 'other_side_user', 'messages', 'message_usernames', 'user', 'users'));
                }
            }

            $chat = Chat::create([
                'is_group' => false,
                'name' => '',
                'created_by' => $user->id,
            ]);

            ChatUser::create([
                'chat_id' => $chat->id,
                'user_id' => $user->id
            ]);

            ChatUser::create([
                'chat_id' => $chat->id,
                'user_id' => $other_side_user->id
            ]);

            $messages = $chat->messages()->get();
            foreach ($messages as $msg) {
                $__user__ = User::find($msg->user_id);
                $message_usernames[] = ["username" => $__user__->username, "phone" => $__user__->phone];
            }

            return view('chat.opened-chat', compact('chats', 'chat', 'chat_names', 'other_side_user', 'messages', 'message_usernames', 'user', 'users'));
        }
    }

    public function show($chat_id)
    {
        $user = Auth::user();
        $users = User::all();

        $chats = $user->chats()->get();
        $chat = Chat::find($chat_id);
        $chat_users = $chat->users()->get();
        $chat_names = [];
        $user_id_to_check_online = [];
        $other_side_user = null;

        if ($chat->is_group == false) {
            foreach ($chat_users as $chat_user) {
                // dd($chat_user);
                $other_side_user = $user->id == $chat_user->id ? $other_side_user : $chat_user;
            }
        }

        foreach ($chats as $this_chat) {
            if ($this_chat->is_group == true) {
                $chat_names["" . $this_chat->id] = $this_chat->name;
                $user_id_to_check_online[] = null;
            } else {
                $this_chat_users = $this_chat->users()->get();
                foreach ($this_chat_users as $ct_user) {
                    if ($user->id !== $ct_user->id) {
                        $usr = User::find($ct_user->id);
                        $chat_names["" . $this_chat->id] = $usr->username == null ? $usr->phone : $usr->username;
                        $user_id_to_check_online[] = $usr->id;
                    }
                }
            }
        }

        $messages = $chat->messages()->get();
        $message_usernames = [];
        foreach ($messages as $msg) {
            $__user__ = User::find($msg->user_id);
            $message_usernames[] = ["username" => $__user__->username, "phone" => $__user__->phone];
        }

        // dd($user_id_to_check_online);
        return view('chat.opened-chat', compact('chats', 'chat', 'chat_users', 'chat_names', 'user_id_to_check_online', 'other_side_user', 'messages', 'message_usernames', 'user', 'users'));
    }

    public function update() {}

    public function destroy() {}
}
