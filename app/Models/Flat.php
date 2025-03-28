<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flat extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'flat_number',
        'housing_id',
        'area',
        'number_of_rooms',
        'number_of_bathrooms',
        'kitchen',
        'status',
    ];

    // الشقة تنتمي إلى مجمع سكني
    public function housing()
    {
        return $this->belongsTo(Housing::class, 'housing_id');
    }

    // علاقة الشقة بالموظفين (Many-to-Many) عبر جدول employee_flat
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_flat')
            ->withPivot('note', 'number_of_family_members', 'entry_date', 'exit_date');
    }
}
