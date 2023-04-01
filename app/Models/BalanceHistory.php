<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BalanceHistory extends Model
{
    use HasFactory;

    const LIMIT_RECORDS_PER_USER = 20;

    protected $table = 'user_balance_history';

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected static function booted(): void
    {
        static::created(function (BalanceHistory $balanceHistory) {
            $userLatestBalanceHistory = self::where('user_id', $balanceHistory->user_id)
                ->latest()
                ->get();

            // Delete oldest
            if ($userLatestBalanceHistory->count() > self::LIMIT_RECORDS_PER_USER) {
                $userLatestBalanceHistoryIds = $userLatestBalanceHistory->take(self::LIMIT_RECORDS_PER_USER)
                    ->pluck('id')
                    ->toArray();

                self::where('user_id', $balanceHistory->user_id)
                    ->whereNotIn('id', $userLatestBalanceHistoryIds)
                    ->delete();
            }
        });
    }
}
