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
        Schema::create('cat_links', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->foreign('category_id')->references('category_id')->on('blogs_categories')->onDelete('cascade');
            $table->unsignedBigInteger('blog_id');
            $table->foreign('blog_id')->references('blog_id')->on('blogs_models')->onDelete('cascade');
            $table->timestamps();
            $table->string('status')->default('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cat__links');
    }
};
