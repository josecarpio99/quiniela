<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\TransactionStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function transactionsCreated() : HasMany
    {
        return $this->hasMany(Transaction::class, 'created_by');
    }

    public function transactions() : HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id');
    }

    public function canWithdrawAmount(float|int $amount) : bool
    {
        return $this->balance >= $amount;
    }

    public function hasExceededWithdrawDailyLimit() : bool
    {
        $lastWithdraw = $this->lastWithdraw();

        if ($lastWithdraw) {
            return $lastWithdraw->created_at->diffInDays(now()) < Transaction::MAX_WITHDRAW_PER_DAY;;
        }

        return true;
    }

    public function lastWithdraw() : Transaction
    {
        return $this->transactions()
            ->where('status', '<>', TransactionStatusEnum::Rejected)
            ->latest()
            ->first();
    }
}
