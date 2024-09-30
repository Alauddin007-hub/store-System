<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    // Show the registration form
    public function index()
    {
        return view('backend.auth.register');
    }

    // Handle the registration request
    public function registration(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'user_type' => 'required|in:1,2,3', // Validation for user_type
        ]);

        // Create a new user instance
        $user = new User;
        $user->name = trim($request->name);
        $user->email = trim($request->email);
        $user->password = Hash::make($request->password);
        $user->user_type_id = $request->user_type; // No need for ?? since we validate it now
        $user->remember_token = Str::random(50);
        $user->save();

        // Redirect to home with success message
        return redirect('/')->with('success', 'User Registration Successful');
    }


    // Show the login form
    public function create()
    {
        return view('backend.auth.login');
    }

    // Handle the login request
    public function login(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], true)) {

            // Check if the user is authenticated and has a user_type_id
            if (Auth::check() && Auth::user()->user_type_id) {
                return redirect()->route('dashboard');
            } else {
                // If authenticated but no user_type_id, handle accordingly
                return redirect()->route('login')->with('error', 'User type not found.');
            }
        } else {
            // Authentication failed, redirect back with error message
            return redirect()->back()->with('error', 'Incorrect credentials. Please try again.');
        }
    }


    // Show the forgot password form
    public function forgot()
    {
        return view('backend.auth.forgot_password');
    }

    // Handle the logout request
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
