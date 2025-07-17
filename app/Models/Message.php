<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'read_at',
    ];

    // Tambahkan relasi ke user pengirim
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'sender_id');
    }
}
