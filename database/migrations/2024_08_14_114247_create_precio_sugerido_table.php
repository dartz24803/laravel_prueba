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
        Schema::create('precio_sugerido', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo')->nullable();
            $table->unsignedBigInteger('id_base');
            $table->decimal('precio_1',10,2)->nullable();
            $table->decimal('precio_2',10,2)->nullable();
            $table->decimal('precio_3',10,2)->nullable();
            $table->integer('estado')->nullable();
            $table->integer('user_reg')->nullable();
            $table->dateTime('fec_reg')->nullable();
            $table->integer('user_act')->nullable();
            $table->dateTime('fec_act')->nullable();
            $table->integer('user_eli')->nullable();
            $table->dateTime('fec_eli')->nullable();
            $table->foreign('id_base','psug_fk_id_bas')->references('id_base')->on('base');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('precio_sugerido');
    }
};
