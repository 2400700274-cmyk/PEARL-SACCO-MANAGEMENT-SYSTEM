<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'key', 'value'])]
class Setting extends Model
{
    /**
     * Get a setting value by key, scoped to the current user, with a fallback default.
     */
    public static function getValue($key, $default = null)
    {
        $userId = auth()->check() ? auth()->user()->tenant_id : null;
        
        // If getting sacco_name and it doesn't exist, default to the user's name
        if ($key === 'sacco_name' && $userId && auth()->user()) {
            $default = auth()->user()->name;
        }

        // If getting email and it doesn't exist, default to the user's email
        if ($key === 'email' && $userId && auth()->user()) {
            $default = auth()->user()->email;
        }

        if (!$userId) return $default;

        $setting = static::where('user_id', $userId)->where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }
}
