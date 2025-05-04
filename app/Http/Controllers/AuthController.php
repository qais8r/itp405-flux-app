<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    
    public function showRegister()
    {
        // Show the registration form
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validate the form data
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:50|unique:users',
            'email'    => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Create a new user
        $user = User::create([
            'name'     => $data['name'],
            'username' => $data['username'],
            'email'    => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Log the user in
        Auth::login($user);

        // Redirect to the desired page
        return redirect()->route('posts.index');
    }

    public function showLogin()
    {
        // Show the login form
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validate the form data
        $credentials = $request->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        // Attempt to log the user in
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            return redirect()->intended(route('posts.index'));
        }

        // If login fails, redirect back with an error message
        return back()->withErrors(['email' => 'Invalid credentials'])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        // Log the user out
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}