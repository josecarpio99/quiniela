<?php

namespace App\Models;

use App\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

    public const MIN_WITHDRAW_AMOUNT = 10;
    public const MIN_DEPOSIT_AMOUNT = 2;
    public const MAX_WITHDRAW_PER_DAY = 1;

    protected $casts = [
        'amount' => 'float',
        'date'   => 'datetime'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function isDeposit() : bool
    {
        return $this->type === TransactionTypeEnum::Deposit;
    }

    public function isWithdraw() : bool
    {
        return $this->type === TransactionTypeEnum::Withdraw;
    }

    public function scopeFromDeposits(Builder $query)
    {
        return $query->where('type', TransactionTypeEnum::Deposit);
    }

    public function scopeFromWithdraws(Builder $query)
    {
        return $query->where('type', TransactionTypeEnum::Withdraw);
    }

    public function scopeWhereUser(Builder $query, User|int $user)
    {
        $userId = is_int($user) ? $user : $user->id;

        return $query->where('user_id', $userId);
    }
}
