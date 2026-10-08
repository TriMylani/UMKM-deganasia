<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Cart;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(Address::class);
    }

    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class);
    }
    public function couponTransactions(): HasMany
    {
        return $this->hasMany(CouponTransaction::class);
    }

    public function redemptions(): HasMany
    {
        return $this->hasMany(Redemption::class);
    }
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function conversations(): HasMany
    {
        return $this->hasMany(Conversation::class);
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }
}