<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'member_id',
    'principal_amount',
    'interest_rate',
    'duration_months',
    'due_date',
    'total_payable',
    'balance',
    'penalty_amount',
    'collateral_description',
    'collateral_value',
    'guarantor_name',
    'guarantor_contact',
    'guarantor_nin',
    'status',
    'approved_at',
])]
class Loan extends Model
{
    protected function casts(): array
    {
        return [
            'principal_amount' => 'decimal:2',
            'interest_rate' => 'decimal:2',
            'duration_months' => 'integer',
            'due_date' => 'date',
            'total_payable' => 'decimal:2',
            'balance' => 'decimal:2',
            'penalty_amount' => 'decimal:2',
            'collateral_value' => 'decimal:2',
            'approved_at' => 'datetime',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function repayments(): HasMany
    {
        return $this->hasMany(Repayment::class);
    }

    public function getEffectiveTotalAttribute(): float
    {
        return (float) ($this->total_payable + ($this->penalty_amount ?? 0));
    }

    public function getAmountPaidAttribute(): float
    {
        return max(0, (float) ($this->effective_total - $this->balance));
    }

    public function getProgressPercentAttribute(): int
    {
        $total = $this->effective_total;
        if ($total <= 0) {
            return 0;
        }

        $paid = $this->amount_paid;
        $pct = (int) round(($paid / $total) * 100);

        return min(100, max(0, $pct));
    }

    public function getIsOverdueAttribute(): bool
    {
        if ($this->status !== 'Active' || $this->balance <= 0 || ! $this->due_date) {
            return false;
        }

        return Carbon::today()->gt($this->due_date);
    }

    public function getDaysOverdueAttribute(): int
    {
        if (! $this->is_overdue || ! $this->due_date) {
            return 0;
        }

        return (int) Carbon::today()->diffInDays($this->due_date);
    }
}
