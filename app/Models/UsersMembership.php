<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class UsersMembership extends Authenticatable
{
    use Notifiable;

    protected $table = 'users_membership';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
