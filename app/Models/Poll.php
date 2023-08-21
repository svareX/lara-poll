<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Poll extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'ends_at',
    ];

    protected $appends = [
        'voted',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(PollOption::class);
    }

    public function getVotedAttribute(): bool
    {
        if ($this->options()->whereHas('users', function ($query) {
            $query->where('user_id', auth()->id());
        })->count() > 0) {
            return true;
        }
        return false;
    }
}
