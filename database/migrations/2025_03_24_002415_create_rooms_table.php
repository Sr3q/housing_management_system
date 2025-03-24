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
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('room_number');  // رقم
            $table->unsignedBigInteger('flat_id')->nullable();
            $table->unsignedBigInteger('housing_id')->nullable();      // رقم البناء (مفتاح خارجي)
            $table->timestamps();

            // ربط رقم البناء بجدول البنايات (buildings)
            $table->foreign('housing_id')->references('id')->on('housing')->onDelete('cascade');
            $table->foreign('flat_id')->references('id')->on('flats')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
