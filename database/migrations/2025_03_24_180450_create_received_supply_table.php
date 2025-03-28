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
        Schema::create('received_supply', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('flat_id')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedBigInteger('supplies_id');
            // عمود لتحديد هل الإمدادات سُلّمت (true) أم لا تزال مع الموظف (false)
            $table->boolean('returned')->default(false);
            $table->timestamps();

            $table->foreign('flat_id')
                ->references('id')
                ->on('flats');

            // تعريف المفاتيح الخارجية
            $table->foreign('room_id')
                ->references('id')
                ->on('rooms');

            $table->foreign('employee_id')
                ->references('id')
                ->on('employees');

            $table->foreign('supplies_id')
                ->references('id')
                ->on('supplies');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('received_supply');
    }
};
