<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
