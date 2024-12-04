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
        Schema::create('biotime_temp', function (Blueprint $table) {
            $table->id();
            $table->string('emp_code')->nullable();
            $table->dateTime('punch_time')->nullable();
            $table->string('work_code',20)->nullable();
            $table->index(['emp_code'], 'btem_idx_emp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('biotime_temp');
    }
};
