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
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('housing_id'); // Foreign key to accommodations
            $table->string('file_name');    // Original file name
            $table->string('file_path');    // Path where the file is stored
            $table->string('mime_type')->nullable();  // File MIME type (optional)
            $table->unsignedBigInteger('file_size')->nullable(); // File size in bytes (optional)
            $table->timestamps();

            // Add the foreign key constraint
            $table->foreign('housing_id')
                ->references('id')
                ->on('housing');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
