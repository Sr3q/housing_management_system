<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supply extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'image_path',
        'expiry_date',
    ];

    // الإمداد يعود إلى الشركة (nullable)
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    // الإمداد يمكن أن يكون مرتبطًا بعمليات الاستلام
    public function receivedSupplies()
    {
        return $this->hasMany(ReceivedSupply::class, 'supplies_id');
    }
}
