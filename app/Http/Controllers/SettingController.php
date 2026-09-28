<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'sacco_name' => 'nullable|string|max:255',
            'reg_number' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
            'admin_name' => 'nullable|string|max:255',
            'admin_email' => 'nullable|email|max:255',
            'profile_image' => 'nullable|image|max:5120',
            'currency' => 'nullable|string',
            'date_format' => 'nullable|string',
            'timezone' => 'nullable|string',
            'language' => 'nullable|string',
            'notify_loan_approval' => 'nullable|string',
            'notify_member_registration' => 'nullable|string',
            'email_notifications' => 'nullable|string',
            'two_factor_auth' => 'nullable|string',
            'session_timeout' => 'nullable|integer',
            'password_policy' => 'nullable|string',
        ]);

        $userId = auth()->user()->tenant_id;
        
        // Update admin user profile if provided
        if ($request->has('admin_name') && $request->has('admin_email')) {
            $user = auth()->user();
            $user->name = $validated['admin_name'];
            $user->email = $validated['admin_email'];
            
            if ($request->hasFile('profile_image')) {
                $path = $request->file('profile_image')->store('profile-photos', 'public');
                $user->profile_photo_path = $path;
            }
            
            $user->save();
            
            unset($validated['admin_name']);
            unset($validated['admin_email']);
            unset($validated['profile_image']);
        }

        foreach ($validated as $key => $value) {
            Setting::updateOrCreate(
                ['user_id' => $userId, 'key' => $key],
                ['value' => $value]
            );
        }

        return back()->with('success', 'System settings have been updated and securely saved.');
    }
}
