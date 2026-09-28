<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Member;
use App\Models\Setting;
use App\Mail\WelcomeMemberMail;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::where('user_id', auth()->user()->tenant_id)->orderBy('id', 'desc')->paginate(15);
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'nin' => 'required|string|max:255|unique:members',
            'contact' => 'required|string|max:255',
            'status' => 'required|string|in:Active,Inactive,Suspended',
            'registered_at' => 'required|date',
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('passport-photos', 'public');
        }

        // Auto-generate Member Number: KAS-YYYY-XXXX
        $year = date('Y', strtotime($validated['registered_at']));
        $count = Member::whereYear('registered_at', $year)->count() + 1;
        $validated['member_number'] = 'KAS-' . $year . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
        $validated['user_id'] = auth()->user()->tenant_id;
        $validated['passport_photo_path'] = $path;

        $member = Member::create($validated);
        
        $member->savingsAccounts()->create([
            'balance' => 0,
            'status' => 'Active'
        ]);

        if (Setting::getValue('email_notifications', '1') === '1' && Setting::getValue('notify_member_registration', '1') === '1' && $member->contact) {
            // Assuming $member->contact is an email or we have an email field. Wait, member model only has 'contact' which could be a phone number.
            // Let's check if contact is an email address.
            if (filter_var($member->contact, FILTER_VALIDATE_EMAIL)) {
                Mail::to($member->contact)->send(new WelcomeMemberMail($member));
            }
        }

        return redirect()->route('members.index')->with('success', 'Member registered successfully.');
    }

    public function show(Member $member)
    {
        return view('members.show', compact('member'));
    }

    public function edit(Member $member)
    {
        return view('members.edit', compact('member'));
    }

    public function update(Request $request, Member $member)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'status' => 'required|string|in:Active,Inactive,Suspended',
            'registered_at' => 'required|date',
        ]);

        $member->update($validated);

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->delete();
        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }

    public function openSavingsAccount(Member $member)
    {
        if ($member->savingsAccounts()->count() === 0) {
            $member->savingsAccounts()->create([
                'balance' => 0,
                'status' => 'Active'
            ]);
            return redirect()->route('savings.show', $member->savingsAccounts()->first())->with('success', 'Savings account opened successfully.');
        }
        return back()->with('error', 'Member already has a savings account.');
    }
}
