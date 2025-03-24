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
        Schema::create('flats', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('flat_number');  // رقم الشقة
            $table->unsignedBigInteger('housing_id');      // رقم البناء (مفتاح خارجي)
            $table->timestamps();

            // ربط رقم البناء بجدول البنايات (buildings)
            $table->foreign('housing_id')->references('id')->on('housing')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flats');
    }
};
