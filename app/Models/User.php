<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * RELATIONSHIP: A user (with role 'doctor') has one Doctor profile.
     */
    public function doctor()
    {
        // This assumes your 'doctors' table has a 'user_id' column
        return $this->hasOne(Doctor::class, 'user_id');
    }
    

    
}