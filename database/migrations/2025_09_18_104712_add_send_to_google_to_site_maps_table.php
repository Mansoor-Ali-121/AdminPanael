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
        Schema::table('site_maps', function (Blueprint $table) {
                    $table->string('send_to_google')->default('no')->after('url');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_maps', function (Blueprint $table) {
        $table->dropColumn('send_to_google');
        });
    }
};
