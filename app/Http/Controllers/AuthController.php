<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        // If user is already authenticated, redirect to dashboard
        if (Auth::check()) {
            return redirect()->intended('/hli-admin/dashboard');
        }
        
        return Inertia::render('Admin/Login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            
            return redirect()->intended('/hli-admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout request (both GET and POST)
     */
    public function logout(Request $request)
    {
        // Always try to logout, even if session is expired
        try {
            Auth::guard('web')->logout();
        } catch (\Exception $e) {
            // Session might already be expired, that's okay
        }

        try {
            $request->session()->invalidate();
        } catch (\Exception $e) {
            // Session might already be invalid, that's okay
        }

        try {
            $request->session()->regenerateToken();
        } catch (\Exception $e) {
            // Session might already be regenerated, that's okay
        }

        return redirect('/hli-admin');
    }

    /**
     * Show the dashboard (protected route)
     */
    public function dashboard()
    {
        return Inertia::render('Admin/Dashboard', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Show the users page (protected route)
     */
    public function users()
    {
        return Inertia::render('Admin/Users', [
            'user' => Auth::user()
        ]);
    }
}
