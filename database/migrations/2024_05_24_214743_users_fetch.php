<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {/*
        DB::table('users')->insert([
            [
                'id' => 139,
                'usuario_codigo' => '70451069',
                'usuario_password' => '$2y$10$8tEWkmHZ/fd6hf3OHGakyuvTdO6YfGox.07/LTlnzkbWsRxoWvD7S',
                'estado' => 1,
            ],
            [
                'id' => 2698,
                'usuario_codigo' => '71722048',
                'usuario_password' => '$2y$10$8tEWkmHZ/fd6hf3OHGakyuvTdO6YfGox.07/LTlnzkbWsRxoWvD7S',
                'estado' => 1,
            ],
        ]);*/
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
