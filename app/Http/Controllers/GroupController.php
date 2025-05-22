<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\ChatUser;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'ids' => 'required|string',
                'group-name' => 'required|string'
            ]);

            $user = Auth::user();
            $ids = explode(',', $data['ids']);

            $chat = Chat::create([
                'is_group' => true,
                'name' => $data['group-name'],
                'created_by' => $user->id,
            ]);

            ChatUser::create([
                'user_id' => $user->id,
                'chat_id' => $chat->id,
            ]);

            foreach ($ids as $user_id) {
                ChatUser::create([
                    'user_id' => (int)$user_id,
                    'chat_id' => $chat->id,
                ]);
            }

            return Redirect::to('/chat/'.$chat->id);
        } catch (Exception $e) {
            return back();
        }
        // return view('chat.opened-chat', compact('group'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
