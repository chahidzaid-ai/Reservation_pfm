<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'is_active',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public const ROLE_GUEST = 'guest';
    public const ROLE_USER = 'user';
    public const ROLE_MANAGER = 'manager';
    public const ROLE_ADMIN = 'admin';

    public function managedResources()
    {
        return $this->hasMany(Resource::class, 'manager_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
