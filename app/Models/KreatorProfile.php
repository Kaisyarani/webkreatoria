<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KreatorProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'about',
        'photo',
        'banner',
        'skills',
        'social_links',
        'experience',
        'education',
    ];

     protected $casts = [
        'skills' => 'array',
        'social_links' => 'array',
        'experience' => 'array',
        'education' => 'array',
    ];

    /**
     * Get the user that owns the profile.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
