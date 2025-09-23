<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'discipline_id',
        'name',
        'tag',
        'logo',
        'wins',
        'losses',
    ];

    /* ==========================
     |   RELATIONSHIPS
     ========================== */

    // Team belongs to a discipline
    public function discipline()
    {
        return $this->belongsTo(Discipline::class);
    }

    // Team has many players (users with role player)
    public function players()
    {
        return $this->belongsToMany(User::class, 'team_user')
                    ->withPivot('joined_at')
                    ->withTimestamps();
    }

    // Team has many staff members
    public function staff()
    {
        return $this->belongsToMany(User::class, 'team_staff')
                    ->withPivot('staff_role_id', 'assigned_at')
                    ->withTimestamps();
    }
}
