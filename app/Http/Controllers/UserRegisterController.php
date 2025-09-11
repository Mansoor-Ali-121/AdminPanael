<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.users.add-user');
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
    public function store(Request $request)
    {
        $ValidateData = $request->validate([

            'username' => 'required|unique:users,username,' . $request->id,
            'email' => 'required|unique:users,email,' . $request->id,
            'password' => 'required|confirmed',
            // 'confirm_password' => 'required|same:password',
            'role' => 'string|nullable',
        ]);

        // Hash the password before storing
        $ValidateData['password'] = Hash::make($ValidateData['password']);
        // Remove confirm_password before saving to DB
        // unset($ValidateData['confirm_password']);


        User::create($ValidateData);
        return redirect()->route('user.add')->with('success', 'User Added Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $users = User::all();
        return view('dashboard.users.show-user', compact('users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::find($id);
        return view('dashboard.users.edit-user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate rules
        $rules = [
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|unique:users,email,' . $id,
            'role' => 'string|nullable',
        ];

        // Agar password field filled ho to validate karo
        if ($request->filled('password')) {
            $rules['password'] = 'confirmed';  // required nahi kyun ke optional hona chahiye
        }

        $validatedData = $request->validate($rules);

        $user = User::findOrFail($id);

        // Agar password diya gaya hai to hash kar ke validatedData me add karo
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($request->password);
        } else {
            unset($validatedData['password']);
        }

        $user->update($validatedData);

        return redirect()->route('user.show')->with('success', 'User Updated Successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.show')->with('success', 'User Deleted Successfully');
    }
}
