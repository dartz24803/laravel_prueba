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
        Schema::table('tracking_token', function (Blueprint $table) {
            $table->dropUnique(['base']);
            $table->unique('token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tracking_token', function (Blueprint $table) {
            $table->unique('base');
            $table->dropUnique(['token']);
        });
    }
};
