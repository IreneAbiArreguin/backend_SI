<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('historico_reportes', function (Blueprint $table) {
            $table->bigIncrements('id_historico');
            $table->unsignedBigInteger('id_reporte'); 
            $table->unsignedInteger('id_usuario')->nullable(); 
            $table->unsignedTinyInteger('estado_anterior')->nullable();
            $table->unsignedTinyInteger('estado_nuevo');
            $table->text('comentario')->nullable();
            $table->dateTime('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));

            $table->foreign('id_reporte')
                ->references('id_reporte')->on('reportes_inundacion')
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreign('id_usuario')
                ->references('id_usuario')->on('usuarios') 
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->index('id_reporte', 'idx_historico_reporte');
            $table->index('id_usuario', 'idx_historico_usuario');
            $table->index('created_at', 'idx_historico_fecha');
        });
    }

    public function down()
    {
        Schema::dropIfExists('historico_reportes');
    }
};