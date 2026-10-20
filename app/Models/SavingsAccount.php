<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['member_id', 'balance', 'status'])]
class SavingsAccount extends Model
{
    protected function casts(): array
    {
        return [
            'balance' => 'decimal:2',
        ];
    }

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(SavingsTransaction::class)->orderBy('transaction_date', 'desc')->orderBy('id', 'desc');
    }
}
