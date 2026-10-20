<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EmailVerificationController extends Controller
{
    public function check(Request $request): JsonResponse
    {
        $email = trim($request->input('email', ''));
        $context = $request->input('context', 'general');

        if (empty($email)) {
            return response()->json([
                'status' => 'empty',
                'valid' => false,
                'message' => '',
            ]);
        }

        // 1. Basic format check
        if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json([
                'status' => 'invalid_format',
                'valid' => false,
                'message' => 'Please enter a valid email address (e.g. user@domain.com)',
            ]);
        }

        // 2. Extract domain and check DNS MX / A records
        $domain = substr(strrchr($email, '@'), 1);
        $domainExists = false;

        if (function_exists('checkdnsrr') && ! empty($domain)) {
            // Check for MX records or A records
            $domainExists = @checkdnsrr($domain, 'MX') || @checkdnsrr($domain, 'A');
        } else {
            // Fallback if DNS check is unavailable
            $domainExists = true;
        }

        if (! $domainExists) {
            return response()->json([
                'status' => 'domain_not_found',
                'valid' => false,
                'message' => "The domain '@{$domain}' does not exist or has no active mail server.",
            ]);
        }

        // 3. Database lookup for account existence
        $userExists = User::where('email', $email)->exists();

        if ($context === 'login') {
            if ($userExists) {
                return response()->json([
                    'status' => 'exists',
                    'valid' => true,
                    'in_system' => true,
                    'message' => 'Registered account found ✓',
                ]);
            } else {
                return response()->json([
                    'status' => 'not_found',
                    'valid' => true,
                    'in_system' => false,
                    'message' => 'No user account found with this email.',
                ]);
            }
        } elseif (in_array($context, ['register', 'staff'])) {
            if ($userExists) {
                return response()->json([
                    'status' => 'already_taken',
                    'valid' => false,
                    'in_system' => true,
                    'message' => 'This email is already in use by another account.',
                ]);
            } else {
                return response()->json([
                    'status' => 'available',
                    'valid' => true,
                    'in_system' => false,
                    'message' => 'Email address is valid and domain is verified ✓',
                ]);
            }
        }

        return response()->json([
            'status' => 'valid',
            'valid' => true,
            'domain_exists' => true,
            'in_system' => $userExists,
            'message' => 'Email domain is active and valid ✓',
        ]);
    }
}
