<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'location',
        'start_date',
        'end_date',
        'banner',
        'created_by',
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /* ==========================
     |   RELATIONSHIPS
     ========================== */

    // User who created the event
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
