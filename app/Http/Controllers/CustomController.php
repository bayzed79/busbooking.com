<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\admin;
use Illuminate\Support\Facades\Hash;

class CustomController extends Controller
{
    public function custom_registerPost(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8',
        ]);

        $admin = new admin([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);
        $check = $admin->save();
        if ($check) {
            Session::flash('success', 'Admin registration successful. Please log in.');
            return redirect()->route('admin_login.view');
        }
        Session::flash('error', 'Registration failed. Please try again.');
        return redirect()->back()->withInput();
    }
    
    public function custom_register()
    {
        return view('admin.register');
    }
    
    public function custom_loginPost(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $admin = admin::where('email', $request->email)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            $cust = [
                'id' => $admin->id,
                'email' => $admin->email,
                'name' => $admin->name ?? 'Admin',
            ];
            session()->put('admin_user', $cust);
            Session::flash('success', 'Admin login successful');
            return redirect()->route('admin.dashboard');
        }

        Session::flash('error', 'Invalid admin credentials');
        return redirect()->back()->withInput();
    }
    
    public function custom_login()
    {
        return view('admin.login');
    }
    
    public function custom_logout()
    {
        session()->forget('admin_user');
        session()->forget('user');
        Session::flash('success', 'Logged out successfully');
        return redirect()->route('home');
    }
    
    public function dashboard()
    {
        return view('admin.dashboard');
    }
}
