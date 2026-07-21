<?php

namespace App\Http\Controllers;

use App\Models\forgot_password;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Session;

class ForgotPasswordManager extends Controller
{
    //
    public function forgot_password()
    {
        return view("auth.forgot_password");

    }
    public function forgot_passwordPost(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $token = Str::random(30);
        $forgot = new forgot_password();
        $forgot->email = $request->email;
        $forgot->token = $token;
        $forgot->save();
        Mail::send('auth.email', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email)->subject('Reset Password');
        });
        return view('temporary');

    }
    public function resetPassword($token)
    {
        return view('auth.newpass', compact('token'));
    }
    public function resetPasswordPost(Request $request)
    {
        $validatedData = request()->validate([
            'password' => 'required|min:8|confirmed',
        ]);
        $forgot = forgot_password::where('email', $request->input('email'))
            ->where('token', $request->input('token'));
        if ($forgot->exists()) {
            $user = User::where('email', $request->email)->first();
            $user->password = bcrypt($validatedData['password']);
            $user->save();
            $forgot->delete();
            return view('loginview');
        }
        return redirect()->back()->withErrors(['email' => 'Invalid email or token or reset password request has already used']);


    }
}
