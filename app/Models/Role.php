<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
    ];

    // علاقة الدور بالمستخدمين (Many-to-Many)
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user');
    }
}
