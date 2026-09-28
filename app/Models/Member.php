<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'member_number', 'name', 'nin', 'contact', 'status', 'registered_at', 'passport_photo_path'])]
class Member extends Model
{
    protected function casts(): array
    {
        return [
            'registered_at' => 'date',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function savingsAccounts(): HasMany
    {
        return $this->hasMany(SavingsAccount::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }
}
