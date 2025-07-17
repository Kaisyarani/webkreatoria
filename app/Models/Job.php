<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    // app/Models/Job.php
protected $fillable = [
    'user_id',
    'title',
    'location',
    'type',
    'description',
    'tags',
    'deadline',
];

// Memberitahu Laravel untuk memperlakukan kolom 'tags' sebagai array
protected $casts = [
    'tags' => 'array',
    'deadline' => 'date',
];

// Relasi: Setiap Job dimiliki oleh satu User (perusahaan)
public function user()
{
    return $this->belongsTo(User::class);
}
}
