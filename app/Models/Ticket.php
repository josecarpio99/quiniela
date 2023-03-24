<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function quiniela()
    {
        return $this->belongsTo(Quiniela::class);
    }

    public function picks()
    {
        return $this->hasMany(Pick::class);
    }

    public function scopeWhereUser(Builder $query, User|int $user)
    {
        $userId = is_int($user) ? $user : $user->id;

        return $query->where('user_id', $userId);
    }
}
