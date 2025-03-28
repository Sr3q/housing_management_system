<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'username',
        'name',
        'password',
        'company_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // علاقة المستخدم بالأدوار (Many-to-Many)
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_user');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
}
