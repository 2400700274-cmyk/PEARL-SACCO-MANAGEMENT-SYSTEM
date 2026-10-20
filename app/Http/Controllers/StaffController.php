<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeStaffMail;
use App\Models\Role;
use App\Models\Setting;
use App\Models\User;
use App\Rules\UgandanNin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Password;

class StaffController extends Controller
{
    public function index()
    {
        $tenantId = auth()->user()->tenant_id;
        $staff = User::where('parent_id', $tenantId)->with('role')->get();

        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        $roles = Role::whereIn('slug', ['loan-officer', 'cashier'])->get();

        return view('staff.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'nin' => ['required', 'string', new UgandanNin, 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Password::defaults()],
            'role_id' => ['required', 'exists:roles,id'],
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('profile-photos', 'public');
        }

        $user = User::create([
            'name' => $validated['name'],
            'nin' => strtoupper(preg_replace('/\s+/', '', $validated['nin'])),
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
            'parent_id' => auth()->user()->tenant_id,
            'status' => 'Active',
            'profile_photo_path' => $path,
        ]);

        $saccoName = Setting::getValue('sacco_name', 'Pearl SACCO Management System', auth()->user()->tenant_id);

        Mail::to($user->email)->send(new WelcomeStaffMail($user, $validated['password'], $saccoName));

        return redirect()->route('staff.index')->with('success', 'Staff account created successfully. An email has been sent to them with their login details.');
    }
}
