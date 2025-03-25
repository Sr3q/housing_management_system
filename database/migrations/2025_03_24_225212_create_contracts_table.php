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
        Schema::create('contracts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('housing_id');
            $table->decimal('monthly_rent', 10, 2);
            $table->string('owner_name')->nullable();               // اسم المالك
            $table->string('owner_representative')->nullable();     // اسم ممثل المالك الذي يتم التواصل معه
            $table->string('contact_number')->nullable();           // رقم التواصل
            $table->text('note')->nullable();                       // ملاحظة
            $table->date('start_date')->nullable();                 // تاريخ البدء
            $table->date('expiry_date')->nullable();                // تاريخ الانتهاء
            $table->string('duration_of_contract')->nullable();     // مدة العقد
            $table->timestamps();

            $table->foreign('housing_id')->references('id')->on('housing')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contracts');
    }
};
