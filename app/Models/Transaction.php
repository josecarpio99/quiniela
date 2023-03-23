<?php

namespace App\Models;

use App\Enums\TransactionTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transaction extends Model
{
    use HasFactory;

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
        return $this->type === TransactionTypeEnum::Deposit->value;
    }

    public function isWithdraw() : bool
    {
        return $this->type === TransactionTypeEnum::Withdraw->value;
    }

    public function scopeFromDeposits(Builder $query)
    {
        return $query->where('type', TransactionTypeEnum::Deposit->value);
    }

    public function scopeFromWithdraws(Builder $query)
    {
        return $query->where('type', TransactionTypeEnum::Withdraw->value);
    }
}
