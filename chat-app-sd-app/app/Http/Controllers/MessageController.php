<?php

namespace App\Http\Controllers;

use App\Events\SentMessage;
use App\Models\Message;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class MessageController extends Controller
{
    public function index () {

    }

    public function store (Request $request) {
        $user = Auth::user();
        // dd($user->id);
        try {
            $message = Message::create([
                'chat_id' => $request->input('chat-id'),
                'user_id' => $user->id,
                'content' => $request->input('message'),
            ]);
            // dd();
            event(new SentMessage($message));
            
            return Redirect::back();
        } catch (Exception $ex) {
            dd($ex);
        }
    }

    public function update () {}
    public function delete () {}
}
