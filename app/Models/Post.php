<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
    'user_id',
    'title',
    'image',
    'description',
    'category',
];

// Relasi: Setiap Post dimiliki oleh satu User
public function user()
{
    return $this->belongsTo(User::class);
}

public function comments()
{
        return $this->hasMany(Comment::class);
}

public function likes()
{
    return $this->belongsToMany(User::class, 'likes');
}

}
