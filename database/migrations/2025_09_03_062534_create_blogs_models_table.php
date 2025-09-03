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
        Schema::create('blogs_models', function (Blueprint $table) {
            $table->id('blog_id');
            $table->string('blog_title');
            $table->text('blog_description');
            $table->string('blog_slug')->unique();
            $table->longText('blog_content');
            $table->string('blog_tags');
            $table->string('blog_image');
            $table->string('image_alt_text');
            $table->string('meta_title');
            $table->text('meta_description');
            $table->date('shedule_date')->nullable();
            $table->time('shedule_time')->nullable();
            $table->string('status')->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs_models');
    }
};
