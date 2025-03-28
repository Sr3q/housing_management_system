<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'housing_id',
        'file_name',
        'file_path',
        'mime_type',
        'file_size',
    ];

    // المرفق يعود لمجمع سكني
    public function housing()
    {
        return $this->belongsTo(Housing::class, 'housing_id');
    }
}
