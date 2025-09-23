<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
    ];

    /* ==========================
     |   RELATIONSHIPS
     ========================== */

    // A discipline has many teams
    public function teams()
    {
        return $this->hasMany(Team::class);
    }
}
