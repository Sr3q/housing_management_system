<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'room_number',
        'flat_id',
        'housing_id',
        'capacity',
        'status',
    ];

    // الغرفة تنتمي إلى شقة (اختياري)
    public function flat()
    {
        return $this->belongsTo(Flat::class, 'flat_id');
    }

    // الغرفة تنتمي إلى مجمع سكني (اختياري)
    public function housing()
    {
        return $this->belongsTo(Housing::class, 'housing_id');
    }

    // علاقة الغرفة بالموظفين (Many-to-Many) عبر جدول employee_room
    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_room')
            ->withPivot('note', 'entry_date', 'exit_date');
    }
}
