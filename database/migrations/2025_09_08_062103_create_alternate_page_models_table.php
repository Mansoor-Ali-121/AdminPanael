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
        Schema::create('alternate_page_models', function (Blueprint $table) {
            $table->id('alternate_id');
            $table->unsignedBigInteger('sitemap_id');
            $table->foreign('sitemap_id')->references('sitemap_id')->on('site_maps')->onDelete('cascade');
            $table->string('hreflang')->nullable();    // nullable added
            $table->string('href')->nullable();        // nullable added
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alternate_page_models');
    }
};
