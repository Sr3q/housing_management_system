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
            $table->string('location')->nullable();                 // الموقع
            $table->unsignedInteger('number_of_flats')->nullable(); // عدد الشقق
            $table->unsignedInteger('number_of_rooms')->nullable(); // عدد الغرف
            $table->unsignedInteger('building_capacity')->nullable(); // سعة المبنى
            $table->string('ownership_type')->nullable();           // نوع الملكية
            $table->enum('type', ['single', 'family'])->default('single');
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            $table->text('note')->nullable();                       // ملاحظة
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
