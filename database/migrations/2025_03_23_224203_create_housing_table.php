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
            $table->unsignedBigInteger('company_id')->nullable();
            $table->string('name')->nullable();
            $table->string('location')->nullable();
            $table->unsignedInteger('number_of_flats')->nullable();
            $table->unsignedInteger('number_of_rooms')->nullable();
            $table->unsignedInteger('building_capacity')->nullable();
            $table->string('ownership_type')->nullable();
            $table->enum('type', ['single', 'family'])->default('single');
            $table->enum('status', ['active', 'maintenance', 'inactive'])->default('active');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->softDeletes();


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
