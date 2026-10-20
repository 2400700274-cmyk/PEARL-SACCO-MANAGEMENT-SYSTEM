<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\Sacco;
use App\Models\Setting;
use App\Models\User;
use App\Rules\UgandanNin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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
            'phone' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'nin' => ['nullable', 'string', new UgandanNin],
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($validated) {
            $role = Role::firstOrCreate(
                ['slug' => 'administrator'],
                ['name' => 'Administrator', 'description' => 'SACCO Administrator']
            );

            // Registration requires platform administrator approval - status is Pending
            $user = User::create([
                'name' => $validated['name'],
                'nin' => $validated['nin'] ?? null,
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role_id' => $role->id,
                'status' => 'Pending',
            ]);

            Sacco::create([
                'admin_id' => $user->id,
                'name' => $validated['sacco_name'],
                'registration_number' => $validated['reg_number'] ?? null,
                'address' => $validated['address'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'status' => 'Pending',
            ]);

            // Seed tenant initial settings
            Setting::create(['user_id' => $user->id, 'key' => 'sacco_name', 'value' => $validated['sacco_name']]);
            if (! empty($validated['reg_number'])) {
                Setting::create(['user_id' => $user->id, 'key' => 'reg_number', 'value' => $validated['reg_number']]);
            }
            Setting::create(['user_id' => $user->id, 'key' => 'address', 'value' => $validated['address']]);
            Setting::create(['user_id' => $user->id, 'key' => 'email', 'value' => $validated['email']]);
        });

        return redirect()->route('login')->with('info', 'Your SACCO registration application has been submitted to the Pearl SACCO Management System. Access to system services is restricted until verified and authorized by the platform administrator.');
    }
}
