<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return redirect()->route('login')->with('info', 'Public SACCO registration is disabled. SACCO workspaces are provisioned and onboarded exclusively by Pearl SACCO Central Administration. Please contact administration for onboarding inquiries.');
    }

    public function register(Request $request)
    {
        return redirect()->route('login')->with('info', 'Public SACCO registration is disabled. SACCO workspaces are provisioned exclusively by Pearl SACCO Central Administration.');
    }
}
