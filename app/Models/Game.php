<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    use HasFactory;

    protected $casts = [
        'start_at' => 'datetime'
    ];

    public function homeTeam()
    {
        return $this->belongsTo(Team::class, 'home_team');
    }

    public function awayTeam()
    {
        return $this->belongsTo(Team::class, 'away_team');
    }
}
