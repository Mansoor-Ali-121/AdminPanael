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
        Schema::create('services_models', function (Blueprint $table) {
            $table->id();
            $table->string('service_name');
            $table->string('service_slug')->unique();
            // $table->string('actual_slug')->nullable(); // Uncomment if needed later
            $table->string('booking_link');
            $table->string('booking_page');
            $table->text('description');
            $table->string('service_image'); // Store image path or filename
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services_models');
    }
};
