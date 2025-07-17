<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
   protected $fillable = [
    'name',
    'email',
    'password',
    'account_type', // Tambahkan ini
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

     public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function lastMessage()
{
    return $this->hasOne(Message::class, 'sender_id')->latestOfMany();
}

    /**
     * Relasi: Satu User memiliki banyak Job (jika dia perusahaan).
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Relasi: Satu User memiliki satu KreatorProfile.
     */
    public function kreatorProfile()
    {
        return $this->hasOne(KreatorProfile::class);
    }

    /**
     * Relasi: Satu User memiliki satu PerusahaanProfile.
     */
    public function perusahaanProfile()
    {
        return $this->hasOne(PerusahaanProfile::class);
    }

    public function likes()
    {
    return $this->belongsToMany(User::class, 'likes');
    }

}
