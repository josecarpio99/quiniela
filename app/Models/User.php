<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Enums\TransactionStatusEnum;
use App\Enums\TransactionTypeEnum;
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

    public function deposits() : HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id')->where('type', TransactionTypeEnum::Deposit);
    }

    public function withdrawals() : HasMany
    {
        return $this->hasMany(Transaction::class, 'user_id')->where('type', TransactionTypeEnum::Withdraw);
    }

    public function tickets() : HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    public function balanceHistory() : HasMany
    {
        return $this->hasMany(BalanceHistory::class, 'user_id');
    }

    public function hasEnoughBalance(float|int $amount) : bool
    {
        return $this->balance >= $amount;
    }

    public function hasExceededWithdrawDailyLimit() : bool
    {
        $lastWithdraw = $this->lastWithdraw();
        if ($lastWithdraw) {
            return $lastWithdraw->created_at->diffInDays(now()) < Transaction::MAX_WITHDRAW_PER_DAY;;
        }

        return false;
    }

    public function lastWithdraw() : ?Transaction
    {
        return $this->transactions()
            ->where('type', TransactionTypeEnum::Withdraw)
            ->where('status', '<>', TransactionStatusEnum::Rejected)
            ->whereNotNull('created_at')
            ->latest()
            ->first();
    }

    public function nextTicketIsFree(Quiniela $quiniela) : bool
    {
        $ticketsCount = $this->tickets()
            ->where('quiniela_id', $quiniela->id)
            ->count();

        if ($ticketsCount <= 1) return false;

        return  ($ticketsCount + 1) % 3 === 0;
    }

    public function scopePaginateData($query, $limit)
    {
        if ($limit == 'all') {
            return $query->get();
        }

        return $query->paginate($limit);
    }

}
