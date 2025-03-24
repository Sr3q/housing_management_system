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
        Schema::create('housing', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id')->nullable(); // مرجع إلى جدول الشركات (nullable)
            $table->string('name')->nullable();       // اسم الإقامة
            $table->string('city')->nullable();                     // المدينة
            $table->string('location')->nullable();                 // الموقع
            // اشياء يمكن حسابها
//            $table->unsignedInteger('number_of_flats')->nullable(); // عدد الشقق
//            $table->unsignedInteger('number_of_rooms')->nullable(); // عدد الغرف
//            $table->unsignedInteger('building_capacity')->nullable(); // سعة المبنى
            $table->string('ownership_type')->nullable();           // نوع الملكية
            $table->string('owner_name')->nullable();               // اسم المالك
            $table->string('owner_representative')->nullable();     // اسم ممثل المالك الذي يتم التواصل معه
            $table->string('contact_number')->nullable();           // رقم التواصل
            $table->text('note')->nullable();                       // ملاحظة
            $table->date('start_date')->nullable();                 // تاريخ البدء
            $table->date('expiry_date')->nullable();                // تاريخ الانتهاء
            $table->string('duration_of_contract')->nullable();     // مدة العقد
            $table->timestamps();

            // قيد المفتاح الخارجي مع السماح بالـ null
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housing');
    }
};
