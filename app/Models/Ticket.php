<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
