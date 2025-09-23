<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class League extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'discipline_id',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /* ==========================
     |   RELATIONSHIPS
     ========================== */

    // League belongs to a discipline
    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    // League has many teams
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'league_team')
                    ->withPivot('points')
                    ->withTimestamps();
    }
}
