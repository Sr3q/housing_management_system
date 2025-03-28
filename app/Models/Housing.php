<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Housing extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'location',
        'number_of_flats',
        'number_of_rooms',
        'building_capacity',
        'ownership_type',
        'type',
        'status',
        'note',
    ];

    // العلاقة مع الشركة (مالك/مدير)
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // المجمع يحتوي على شقق
    public function flats()
    {
        return $this->hasMany(Flat::class, 'housing_id');
    }

    // المجمع يحتوي على غرف
    public function rooms()
    {
        return $this->hasMany(Room::class, 'housing_id');
    }

    // المجمع يحتوي على عقود
    public function contracts()
    {
        return $this->hasMany(Contract::class, 'housing_id');
    }

    // المجمع مرتبط بالمرفقات (attachments)
    public function attachments()
    {
        return $this->hasMany(Attachment::class, 'housing_id');
    }
}
