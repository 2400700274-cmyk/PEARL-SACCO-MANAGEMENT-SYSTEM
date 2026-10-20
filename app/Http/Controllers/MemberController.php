<?php

namespace App\Http\Controllers;

use App\Mail\WelcomeMemberMail;
use App\Models\Member;
use App\Models\Setting;
use App\Rules\UgandanNin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
            'nin' => ['required', 'string', new UgandanNin, 'unique:members,nin'],
            'contact' => 'required|string|max:255',
            'next_of_kin_name' => 'required|string|max:255',
            'next_of_kin_contact' => 'required|string|max:255',
            'next_of_kin_relationship' => 'required|string|max:255',
            'next_of_kin_address' => 'nullable|string|max:255',
            'status' => 'required|string|in:Active,Inactive,Suspended',
            'registered_at' => 'required|date',
            'photo' => ['nullable', 'image', 'max:2048'],
        ]);

        $path = null;
        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('passport-photos', 'public');
        }

        // Auto-generate Member Number: PSM-YYYY-XXXX
        $year = date('Y', strtotime($validated['registered_at']));
        $count = Member::whereYear('registered_at', $year)->count() + 1;
        $validated['member_number'] = 'PSM-'.$year.'-'.str_pad($count, 4, '0', STR_PAD_LEFT);
        $validated['user_id'] = auth()->user()->tenant_id;
        $validated['nin'] = strtoupper(preg_replace('/\s+/', '', $validated['nin']));
        $validated['passport_photo_path'] = $path;

        $member = Member::create($validated);

        $member->savingsAccounts()->create([
            'balance' => 0,
            'status' => $member->status === 'Active' ? 'Active' : 'Inactive',
        ]);

        if (Setting::getValue('email_notifications', '1') === '1' && Setting::getValue('notify_member_registration', '1') === '1' && $member->contact) {
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
            'nin' => ['required', 'string', new UgandanNin, 'unique:members,nin,'.$member->id],
            'contact' => 'required|string|max:255',
            'next_of_kin_name' => 'required|string|max:255',
            'next_of_kin_contact' => 'required|string|max:255',
            'next_of_kin_relationship' => 'required|string|max:255',
            'next_of_kin_address' => 'nullable|string|max:255',
            'status' => 'required|string|in:Active,Inactive,Suspended',
            'registered_at' => 'required|date',
        ]);

        $validated['nin'] = strtoupper(preg_replace('/\s+/', '', $validated['nin']));

        $member->update($validated);

        // Keep savings account status aligned if member is suspended or inactive
        if ($member->status !== 'Active') {
            $member->savingsAccounts()->update(['status' => 'Inactive']);
        } else {
            $member->savingsAccounts()->update(['status' => 'Active']);
        }

        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }

    public function openSavingsAccount(Member $member)
    {
        if ($member->status !== 'Active') {
            return back()->with('error', "Cannot open a savings account for an inactive or suspended member (Status: {$member->status}).");
        }

        if ($member->savingsAccounts()->count() === 0) {
            $member->savingsAccounts()->create([
                'balance' => 0,
                'status' => 'Active',
            ]);

            return redirect()->route('savings.show', $member->savingsAccounts()->first())->with('success', 'Savings account opened successfully.');
        }

        return back()->with('error', 'Member already has a savings account.');
    }
}
