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
            $table->string('owner_name')->nullable();
            $table->string('owner_representative')->nullable();
            $table->string('contact_number')->nullable();
            $table->text('note')->nullable();
            $table->date('start_date')->nullable();
            $table->date('expiry_date')->nullable();
            $table->string('duration_of_contract')->nullable();
            $table->timestamps();

            $table->foreign('housing_id')->references('id')->on('housing');
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
