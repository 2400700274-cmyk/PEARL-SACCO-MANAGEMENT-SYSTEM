<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['user_id', 'key', 'value'])]
class Setting extends Model
{
    /**
     * Get a setting value by key, scoped to the current user, with a fallback default.
     */
    public static function getValue($key, $default = null)
    {
        $user = auth()->user();
        $userId = $user ? $user->tenant_id : null;

        if (! $userId) {
            return $default;
        }

        $setting = static::where('user_id', $userId)->where('key', $key)->first();
        if ($setting && ! empty($setting->value)) {
            return $setting->value;
        }

        if ($key === 'sacco_name') {
            if ($user && $user->sacco) {
                return $user->sacco->name;
            }
            if ($user && $user->isSuperAdmin()) {
                return 'Pearl SACCO Management System';
            }

            return $default ?: 'Pearl SACCO Management System';
        }

        if ($key === 'email' && $user) {
            return $user->email;
        }

        return $default;
    }
}
