<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'housing_id',
        'monthly_rent',
        'owner_name',
        'owner_representative',
        'contact_number',
        'note',
        'start_date',
        'expiry_date',
        'duration_of_contract',
    ];

    // العقد ينتمي إلى مجمع سكني
    public function housing()
    {
        return $this->belongsTo(Housing::class, 'housing_id');
    }
}
