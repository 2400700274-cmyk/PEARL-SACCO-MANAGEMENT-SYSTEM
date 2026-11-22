<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['user_id', 'member_number', 'name', 'nin', 'contact', 'next_of_kin_name', 'next_of_kin_contact', 'next_of_kin_relationship', 'next_of_kin_address', 'status', 'registered_at', 'passport_photo_path'])]
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

    public function userAccount()
    {
        return $this->hasOne(User::class, 'member_id');
    }

    public function savingsAccounts(): HasMany
    {
        return $this->hasMany(SavingsAccount::class);
    }

    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    public function getTotalSavingsBalanceAttribute(): float
    {
        return (float) $this->savingsAccounts()->where('status', 'Active')->sum('balance');
    }

    public function getActiveLoanBalanceAttribute(): float
    {
        return (float) $this->loans()->where('status', 'Active')->sum('balance');
    }

    public function getAvailableLoanLimitAttribute(): float
    {
        $savingsLimit = $this->total_savings_balance * 3;

        return (float) max(0, $savingsLimit - $this->active_loan_balance);
    }
}
