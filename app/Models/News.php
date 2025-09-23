<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'slug',
        'cover_image',
        'author_id',
        'published_at',
    ];

    protected $casts = [
        'title' => 'array',    // multilangue JSON
        'content' => 'array',
        'published_at' => 'datetime',
    ];

    /* ==========================
     |   RELATIONSHIPS
     ========================== */

    // Author of the news
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }
}
