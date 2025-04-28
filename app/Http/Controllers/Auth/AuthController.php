<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function index (Request $request) {
        return view('auth.partials.phone');
    }

    public function store (Request $request) {
        //
        $form_type = $request->input('form_type');
        try{
            if($form_type === 'phone') {
                $request->validate([
                    'phone' => 'required'
                ]);
                $phone = $request->phone;
                return view('auth.partials.code', compact('phone'));
            } else if($form_type === "code") {
                $request->validate([
                    'phone' => 'required',
                    'verification_code' => 'required|min:6|max:6'
                ]);

                $user = User::firstWhere('phone', $request->phone);
                // $userChats = 

                return Redirect::route('chat.index');
            }
        }catch (Exception $exception) {

        }
        return view('auth.partials.phone');
    }

    public function show (Request $request) {

    }

    public function update (Request $request) {

    }

    public function destroy (Request $request) {

    }
}
