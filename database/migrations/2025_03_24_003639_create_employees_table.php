<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emp_id')->nullable();
            $table->string('english_name')->nullable();
            $table->string('arabic_name')->nullable();
            $table->string('type')->nullable();
            $table->unsignedBigInteger('sup_id')->nullable();
            $table->string('supervisor_name')->nullable();
            $table->string('nationality')->nullable();
            $table->string('grade')->nullable();
            $table->string('payroll')->nullable();
            $table->string('division_operation')->nullable();
            $table->string('location')->nullable();
            $table->string('organization')->nullable();
            $table->string('position')->nullable();
            $table->string('id_number')->nullable();
            $table->string('iqama_no')->nullable();
            $table->string('profession')->nullable();
            $table->date('iqama_expiry')->nullable();
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('assigned_agency')->nullable();
            $table->date('end_date')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('start_date')->nullable();
            // تاريخ الدخول للمملكة: Entry Date in Kingdom
            $table->date('entry_date_ksa')->nullable();
            // رقم التأمينات الإجتماعية: Social Insurance Number
            $table->string('social_insurance_number')->nullable();
            // تاريخ بداية التأمينات الإجتماعية: Social Insurance Start Date
            $table->date('social_insurance_start_date')->nullable();
            $table->string('company_service_length')->nullable();
            $table->string('length_of_yr_mth')->nullable();
            $table->integer('age')->nullable();
            $table->string('org')->nullable();
            $table->string('function')->nullable();
            $table->string('department')->nullable();
            $table->string('section')->nullable();
            $table->string('unit')->nullable();
            $table->string('sub_unit')->nullable();
            $table->string('contract_duration')->nullable();
            $table->string('cost_pool')->nullable();
            $table->string('religion')->nullable();
            $table->string('erf_no')->nullable();

            $table->string('start_work')->nullable();
            $table->string('end_work')->nullable();

            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
