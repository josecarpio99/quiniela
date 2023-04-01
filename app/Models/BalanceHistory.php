<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BalanceHistory extends Model
{
    use HasFactory;

    protected $table = 'user_balance_history';

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
