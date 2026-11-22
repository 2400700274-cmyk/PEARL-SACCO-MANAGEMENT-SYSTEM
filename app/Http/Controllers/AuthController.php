<?php

namespace App\Http\Controllers;

use App\Models\Sacco;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function showLoginForm(Request $request): View
    {
        $saccos = Sacco::query()
            ->where('status', 'Active')
            ->orderBy('name')
            ->get(['id', 'name']);
        $isMemberLogin = $request->query('portal') === 'member';

        return view('auth.login', compact('saccos', 'isMemberLogin'));
    }

    public function login(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'sacco_id' => ['nullable', 'integer', Rule::exists('saccos', 'id')->where('status', 'Active')],
        ]);

        if (Auth::attempt([
            'email' => $validated['email'],
            'password' => $validated['password'],
        ], $request->boolean('remember'))) {
            $user = Auth::user();

            if ($user->status === 'Pending') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Your SACCO registration is pending review and authorization by the Pearl SACCO Management System administrator. Access to system services is restricted until approved.',
                ])->onlyInput('email');
            }

            if ($user->status === 'Suspended') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'This account has been suspended. Access to Pearl SACCO Management System services has been temporarily revoked.',
                ])->onlyInput('email');
            }

            if ($user->status === 'Inactive') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'This account is currently inactive. Please contact your SACCO or platform administrator.',
                ])->onlyInput('email');
            }

            if ($user->isMember()) {
                $memberSaccoId = $user->member
                    ? Sacco::query()
                        ->where('admin_id', $user->member->user_id)
                        ->where('status', 'Active')
                        ->value('id')
                    : null;

                if ($memberSaccoId === null || (int) $memberSaccoId !== (int) ($validated['sacco_id'] ?? 0)) {
                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()->withErrors([
                        'sacco_id' => 'Select the SACCO linked to your member account.',
                    ])->onlyInput('email', 'sacco_id');
                }
            }

            $request->session()->regenerate();

            if ($user->isSuperAdmin()) {
                return redirect()->intended(route('saccos.index'));
            }

            if ($user->isMember()) {
                return redirect()->intended(route('member.dashboard'));
            }

            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
