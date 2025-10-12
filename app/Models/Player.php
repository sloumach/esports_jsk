<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'nickname',
        'full_name',
        'country',
    ];

    protected $casts = [
    ];

    /* ==========================
     |   RELATIONSHIPS
     ========================== */

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'player_team')
                    ->withPivot('joined_at', 'left_at')
                    ->withTimestamps();
    }
}
