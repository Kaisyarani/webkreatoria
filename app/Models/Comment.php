<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'post_id', 'body'];

    // Relasi ke User (pembuat komentar)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke Post (postingan yang dikomentari)
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
