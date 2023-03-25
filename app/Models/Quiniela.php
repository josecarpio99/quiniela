<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Quiniela extends Model
{
    use HasFactory;

    protected $casts = [
        'close_at' => 'datetime',
        'prize'    => 'array',
    ];

    public function games()
    {
        return $this->belongsToMany(Game::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function picks(): HasManyThrough
    {
        return $this->hasManyThrough(Pick::class, Ticket::class);
    }

    public function gamesMatch(array $gameIds) : bool
    {
        return $this->games->pluck('id')->sort()->join('') === collect($gameIds)->sort()->join('');
    }
}
