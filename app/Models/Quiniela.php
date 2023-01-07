<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiniela extends Model
{
    use HasFactory;

    protected $dates = ['close_at'];

    public function games()
    {
        return $this->belongsToMany(Game::class);
    }
}
