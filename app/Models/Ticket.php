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

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
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

    public function scopeFree(Builder $query)
    {
        return $query->where('price', 0);
    }

    public function scopeFreeCount(Builder $query)
    {
        return $query->free()->count();
    }

    public function scopePaid(Builder $query)
    {
        return $query->where('price', '>', 0);
    }

    public function scopePaidCount(Builder $query)
    {
        return $query->paid()->count();
    }

    protected static function booted() : void
    {
        static::creating(function(Ticket $ticket) {
            $ticket->number_id = bin2hex(random_bytes(5));
        });
    }
}
