<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeAdminMail;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'sacco_name' => 'required|string|max:255',
            'reg_number' => 'nullable|string|max:255',
            'address' => 'required|string',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Ensure at least a default role exists to prevent foreign key constraints
        $role = Role::firstOrCreate(
            ['slug' => 'administrator'],
            ['name' => 'Administrator', 'description' => 'System Administrator']
        );

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $role->id,
            'status' => 'Active',
        ]);

        // Seed the tenant settings
        \App\Models\Setting::create(['user_id' => $user->id, 'key' => 'sacco_name', 'value' => $validated['sacco_name']]);
        if (!empty($validated['reg_number'])) {
            \App\Models\Setting::create(['user_id' => $user->id, 'key' => 'reg_number', 'value' => $validated['reg_number']]);
        }
        \App\Models\Setting::create(['user_id' => $user->id, 'key' => 'address', 'value' => $validated['address']]);
        \App\Models\Setting::create(['user_id' => $user->id, 'key' => 'email', 'value' => $validated['email']]);

        // Send welcome email to admin
        Mail::to($user->email)->send(new WelcomeAdminMail($user, $validated['sacco_name']));

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', 'Workspace created successfully! Welcome to Kulima Agri-SACCO.');
    }
}
