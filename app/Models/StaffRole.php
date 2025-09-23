<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffRole extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    /* ==========================
     |   RELATIONSHIPS
     ========================== */

    // StaffRole can be linked to many users in teams
    public function staff()
    {
        return $this->hasManyThrough(
            User::class,
            Team::class,
            'id',              // Local key on teams
            'id',              // Local key on users
            'id',              // Local key on staff_roles
            'discipline_id'    // Foreign key on teams
        );
    }
}
