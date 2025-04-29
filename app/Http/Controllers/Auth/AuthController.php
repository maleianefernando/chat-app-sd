<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\ChatUser;
use App\Models\User;
use Brick\Math\BigInteger;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function phone_form(Request $request)
    {
        return view('auth.partials.phone');
    }

    public function code_form(Request $request)
    {
        $phone = (int)$request->query('phone');
        return view('auth.partials.code', compact('phone'));
    }

    public function loginPhone(Request $request)
    {
        if (Auth::user()) {
            $user = Auth::user();
            $chatsUser = ChatUser::where('user_id', $user->id);
            return Redirect::route('chat.index', compact('chatsUser'));
        }

        try {
            $request->validate([
                'phone' => 'required|numeric'
            ]);

            $phone = $request->phone;

            $user = User::firstWhere('phone', $phone);
            if ($user === null) {
                $user = User::create([
                    'phone' => $request->phone,
                ]);
            }

            $code = random_int(100000, 999999);
            $user->code = $code;
            $user->save();

            return Redirect::route('login.code', compact('phone'));
            // return view('auth.partials.code', compact('phone'));
        } catch (ValidationException $exeption) {
            return Redirect::back()->withInput();
        }
    }

    public function store(Request $request)
    {
        //
        if (Auth::user()) {
            $user = Auth::user();
            $chatsUser = ChatUser::where('user_id', $user->id);
            return Redirect::route('chat.index', compact('chatsUser'));
        }
        try {

            $request->validate([
                'phone' => 'required|numeric',
                'verification_code' => 'required|numeric||min_digits:6|max_digits:6',
                'username' => 'string',
            ]);

            $phone = $request->phone;

            $user = User::firstWhere('phone', $phone);
            $user->username = $request->username;
            $user->save();

            if ($request->verification_code === $user->code) {
                Auth::login($user);
                $chatsUser = ChatUser::where('user_id', $user->id);
                return Redirect::route('chat.index', compact('chatsUser'));
            } else {
                return Redirect::back()->with('error', 'O seu codigo de verificacao esta incorrecto!!');
            }
        } catch (ValidationException $exception) {
            dd($exception);
            return Redirect::back()->with('error', $exception->getMessage());
        }
        return view('auth.partials.code');
    }

    public function show(Request $request) {}

    public function update(Request $request) {}

    public function destroy(Request $request) {}
}
