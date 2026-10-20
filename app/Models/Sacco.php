<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['admin_id', 'name', 'registration_number', 'address', 'email', 'phone', 'status', 'notes', 'approved_at'])]
class Sacco extends Model
{
    protected function casts(): array
    {
        return [
            'approved_at' => 'datetime',
        ];
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function members(): HasMany
    {
        return $this->hasMany(Member::class, 'user_id', 'admin_id');
    }

    public function staff(): HasMany
    {
        return $this->hasMany(User::class, 'parent_id', 'admin_id');
    }
}
