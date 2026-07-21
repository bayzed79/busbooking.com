<?php

namespace App\Http\Controllers;

use App\Models\Userinfo;

use Illuminate\Http\Request;
use Auth;
use Session;

class UserController extends Controller
{
    public function register(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email|unique:userinfos',
            'password' => 'required|min:8',
        ]);

        // Create a new user record
        $user = new Userinfo();
        $user->firstname = $validatedData['firstname'];
        $user->lastname = $validatedData['lastname'];
        $user->email = $validatedData['email'];
        $user->password = bcrypt($validatedData['password']);
        $user->save();

        // Optionally, you can log in the user here
        // Auth::login($user);

        Session::flash('msg', 'Registration successful!');
        return redirect('/showdata');
    }


    public function log_in(Request $request)
    {
        // Retrieve the email and password from the request
        $credentials = $request->only('email', 'password');

        // Attempt to authenticate the user
        if (Auth::attempt($credentials)) {
            // Authentication successful
            echo "Authenticated"; // Redirect to the intended page after login
        }

        // Authentication failed, redirect back with an error message
        echo "Not Authenticated";
    }



}
