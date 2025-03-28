<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceivedSupply extends Model
{
    protected $table = 'received_supply';

    protected $fillable = [
        'flat_id',
        'room_id',
        'employee_id',
        'supplies_id',
        'returned',
    ];

    // عملية الاستلام تنتمي إلى الإمداد
    public function supply()
    {
        return $this->belongsTo(Supply::class, 'supplies_id');
    }

    // إذا كانت العملية مرتبطة بشقة
    public function flat()
    {
        return $this->belongsTo(Flat::class, 'flat_id');
    }

    // إذا كانت العملية مرتبطة بغرفة
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    // العملية مرتبطة بموظف
    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
