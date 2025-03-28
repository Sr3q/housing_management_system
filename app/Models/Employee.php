<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'emp_id',
        'english_name',
        'arabic_name',
        'type',
        'sup_id',
        'supervisor_name',
        'nationality',
        'grade',
        'payroll',
        'division_operation',
        'location',
        'organization',
        'position',
        'id_number',
        'iqama_no',
        'profession',
        'iqama_expiry',
        'gender',
        'marital_status',
        'assigned_agency',
        'end_date',
        'date_of_birth',
        'start_date',
        'entry_date_ksa',
        'social_insurance_number',
        'social_insurance_start_date',
        'company_service_length',
        'length_of_yr_mth',
        'age',
        'org',
        'function',
        'department',
        'section',
        'unit',
        'sub_unit',
        'contract_duration',
        'cost_pool',
        'religion',
        'erf_no',
        'start_work',
        'end_work',
    ];

    // علاقة الموظف بالغرف (Many-to-Many) عبر جدول employee_room
    public function rooms()
    {
        return $this->belongsToMany(Room::class, 'employee_room')
            ->withPivot('note', 'entry_date', 'exit_date');
    }

    // علاقة الموظف بالشقق (Many-to-Many) عبر جدول employee_flat
    public function flats()
    {
        return $this->belongsToMany(Flat::class, 'employee_flat')
            ->withPivot('note', 'number_of_family_members', 'entry_date', 'exit_date');
    }
}
