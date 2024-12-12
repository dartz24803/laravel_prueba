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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id('id_tickets');
            $table->unsignedBigInteger('id_usuario_solic');
            $table->integer('id_usuario_soporte')->nullable();
            $table->integer('link')->nullable();
            $table->integer('verif_email')->nullable();
            $table->string('cod_tickets', 20)->nullable();
            $table->unsignedBigInteger('id_tipo_tickets');
            $table->unsignedBigInteger('plataforma');
            $table->unsignedBigInteger('id_prioridad_tickets');
            $table->integer('dificultad');
            $table->string('titulo_tickets', 50)->nullable();
            $table->text('descrip_ticket')->nullable();
            $table->text('coment_ticket')->nullable();
            $table->integer('finalizado_por')->nullable();
            $table->integer('estado')->nullable();
            $table->date('ticket_ini')->nullable();
            $table->date('ticket_fin')->nullable();
            $table->date('f_inicio')->nullable();
            $table->date('f_fin')->nullable();
            $table->date('fecha_vencimiento')->nullable();
            $table->date('f_inicio_real')->nullable();
            $table->date('f_fin_real')->nullable();
            $table->datetime('fec_reg')->nullable();
            $table->integer('user_reg')->nullable();
            $table->datetime('fec_act')->nullable();
            $table->integer('user_act')->nullable();
            $table->datetime('fec_eli')->nullable();
            $table->integer('user_eli')->nullable();

            $table->foreign('id_usuario_solic', 'tickets_fk_id_usuario_solic')->references('id_usuario')->on('users');
            $table->foreign('id_tipo_tickets', 'tickets_fk_id_tipo_tickets')->references('id_tipo_tickets')->on('tipo_tickets');
            $table->foreign('plataforma', 'tickets_fk_plataforma')->references('id_plataforma')->on('plataforma');
            $table->foreign('id_prioridad_tickets', 'tickets_fk_id_prioridad_tickets')->references('id_prioridad_tickets')->on('prioridad_tickets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
