<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->string('room_number');
            $table->unsignedBigInteger('flat_id')->nullable();
            $table->unsignedBigInteger('housing_id')->nullable();
            $table->integer('capacity')->default(1);
            $table->enum('status', ['vacant', 'occupied', 'maintenance'])->default('vacant');
            $table->enum('type', ['living', 'storehouse', 'bathroom', 'kitchen', 'laundry'])->default('living');
            $table->timestamps();

            $table->softDeletes();

            $table->foreign('housing_id')->references('id')->on('housing');
            $table->foreign('flat_id')->references('id')->on('flats');
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
