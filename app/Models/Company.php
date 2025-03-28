<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'location',
    ];

    // الشركة لها العديد من المجمعات السكنية
    public function housings()
    {
        return $this->hasMany(Housing::class, 'company_id');
    }

    // الشركة لها العديد من المستخدمين
    public function users()
    {
        return $this->hasMany(User::class, 'company_id');
    }

    // الشركة قد يكون لها إمدادات
    public function supplies()
    {
        return $this->hasMany(Supply::class, 'company_id');
    }
}
