<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\Member;
use App\Models\Role;
use App\Models\Sacco;
use App\Models\SavingsAccount;
use App\Models\Setting;
use App\Models\User;
use App\Rules\UgandanNin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SaccoController extends Controller
{
    public function index()
    {
        $metrics = [
            'total_saccos' => Sacco::count(),
            'active_saccos' => Sacco::where('status', 'Active')->count(),
            'pending_saccos' => Sacco::where('status', 'Pending')->count(),
            'total_members' => Member::count(),
            'total_savings' => SavingsAccount::sum('balance'),
            'total_loans' => Loan::where('status', 'Active')->sum('balance'),
        ];

        $saccos = Sacco::with(['admin'])->withCount('members')->orderBy('id', 'desc')->paginate(15);

        return view('saccos.index', compact('metrics', 'saccos'));
    }

    public function create()
    {
        return view('saccos.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'registration_number' => 'nullable|string|max:255',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:255',
            'admin_name' => 'required|string|max:255',
            'admin_email' => 'required|string|email|max:255|unique:users,email',
            'admin_nin' => ['nullable', 'string', new UgandanNin],
            'password' => 'required|string|min:8|confirmed',
        ]);

        DB::transaction(function () use ($validated) {
            $role = Role::firstOrCreate(
                ['slug' => 'administrator'],
                ['name' => 'Administrator', 'description' => 'SACCO Administrator']
            );

            $admin = User::create([
                'name' => $validated['admin_name'],
                'email' => $validated['admin_email'],
                'nin' => $validated['admin_nin'] ?? null,
                'password' => Hash::make($validated['password']),
                'role_id' => $role->id,
                'status' => 'Active',
            ]);

            $sacco = Sacco::create([
                'admin_id' => $admin->id,
                'name' => $validated['name'],
                'registration_number' => $validated['registration_number'] ?? null,
                'address' => $validated['address'],
                'email' => $validated['admin_email'],
                'phone' => $validated['phone'] ?? null,
                'status' => 'Active',
                'approved_at' => now(),
            ]);

            Setting::create(['user_id' => $admin->id, 'key' => 'sacco_name', 'value' => $validated['name']]);
            Setting::create(['user_id' => $admin->id, 'key' => 'address', 'value' => $validated['address']]);
            Setting::create(['user_id' => $admin->id, 'key' => 'email', 'value' => $validated['admin_email']]);
        });

        return redirect()->route('saccos.index')->with('success', 'SACCO registered and activated successfully in Pearl SACCO Management System.');
    }

    public function show(Sacco $sacco)
    {
        $sacco->load(['admin.staff.role']);
        $membersCount = Member::where('user_id', $sacco->admin_id)->count();
        $totalSavings = SavingsAccount::whereHas('member', fn ($q) => $q->where('user_id', $sacco->admin_id))->sum('balance');
        $activeLoans = Loan::whereHas('member', fn ($q) => $q->where('user_id', $sacco->admin_id))->where('status', 'Active')->sum('balance');

        return view('saccos.show', compact('sacco', 'membersCount', 'totalSavings', 'activeLoans'));
    }

    public function approve(Sacco $sacco)
    {
        $sacco->update([
            'status' => 'Active',
            'approved_at' => now(),
        ]);

        if ($sacco->admin) {
            $sacco->admin->update(['status' => 'Active']);
        }

        return back()->with('success', "SACCO '{$sacco->name}' has been approved and granted system access.");
    }

    public function toggleStatus(Sacco $sacco)
    {
        $newStatus = $sacco->status === 'Active' ? 'Suspended' : 'Active';
        $sacco->update(['status' => $newStatus]);

        if ($sacco->admin) {
            $sacco->admin->update(['status' => $newStatus]);
        }

        return back()->with('success', "SACCO '{$sacco->name}' status changed to {$newStatus}.");
    }
}
