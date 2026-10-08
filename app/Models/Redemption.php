<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Redemption extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'admin_id',
        'coupon_quantity',
        'reward_quantity',
        'reward_name',
        'note',
        'redeemed_at',
    ];

    protected $casts = [
        'coupon_quantity' => 'integer',
        'reward_quantity' => 'integer',
        'redeemed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}