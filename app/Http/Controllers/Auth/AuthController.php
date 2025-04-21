<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class AuthController extends Controller
{
    public function index (Request $request) {
        return view('auth.partials.phone');
    }

    public function store (Request $request) {
        // var_dump('aa');
        //
        $form_type = $request->input('form_type');
        if($form_type === 'phone') {
            $request->validate([
                'phone' => 'required'
            ]);
            $phone = $request->phone;
            // var_dump($request->input('form_type'));
            return view('auth.partials.code', compact('phone'));
        } else if($form_type === "code") {
            return Redirect::route('chat.index');
            $request->validate([
                'phone' => 'required',
                'verification_code' => 'required|min:6|max:6'
            ]);

        } else {
            return view('auth.partials.phone');
        }
    }

    public function show (Request $request) {

    }

    public function update (Request $request) {

    }

    public function destroy (Request $request) {

    }
}
