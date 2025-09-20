<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.users.login');
    }

    public function dashboard()
    {
        return view('dashboard.main-dashboard');
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
   public function login(Request $request)
{
    // Validation: username aur password dono required hain, aur unique nahi chahiye yahan
    $validatedData = $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    // Attempt login
    if (Auth::attempt(['username' => $validatedData['username'], 'password' => $validatedData['password']])) {
        // Authentication passed
        return redirect()->route('admin.home');
    } else {
        // Authentication failed
        return redirect()->back()->withErrors(['username' => 'Invalid credentials'])->withInput();
    }
}


    /**
     * Display the specified resource.
     */
   public function logout(Request $request)
{
    Auth::logout(); // User ko logout karo
    $request->session()->invalidate(); // Session invalidate karo
    $request->session()->regenerateToken(); // CSRF token renew karo

    return redirect()->route('user.login')->with('success', 'Logged out successfully.');
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
