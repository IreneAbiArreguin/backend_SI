<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reportes_inundacion', function (Blueprint $table) {
            $table->bigIncrements('id_reporte');
            $table->unsignedInteger('id_usuario')->nullable();
            $table->unsignedSmallInteger('id_municipio')->nullable();
            $table->unsignedTinyInteger('estado_reporte_id');
            $table->string('nivel_afectacion', 50)->nullable();
            $table->string('metodo_origen', 30);
            $table->dateTime('fecha_suceso')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->unsignedTinyInteger('prioridad')->default(2);
            $table->string('calle_principal', 150)->nullable();
            $table->string('cruzamiento1', 150)->nullable();
            $table->string('cruzamiento2', 150)->nullable();
            $table->string('colonia', 100)->nullable();
            $table->string('cp', 10)->nullable();
            $table->text('descripcion')->nullable();
            $table->decimal('latitud', 10, 8);
            $table->decimal('longitud', 11, 8);
            $table->unsignedInteger('verificado_por')->nullable();
            $table->timestamps(); 

            $table->foreign('id_usuario')
                ->references('id_usuario')->on('usuarios')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('id_municipio')
                ->references('id_municipio')->on('municipios')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->foreign('estado_reporte_id')
                ->references('id_estado_reporte')->on('estados_reporte')
                ->onDelete('restrict')
                ->onUpdate('cascade');

            $table->foreign('verificado_por')
                ->references('id_usuario')->on('usuarios')
                ->onDelete('set null')
                ->onUpdate('cascade');

            $table->index(['latitud', 'longitud'], 'idx_reportes_ubicacion');
            $table->index('fecha_suceso', 'idx_reportes_fecha');
            $table->index('prioridad', 'idx_reportes_prioridad');
        });
    }

    public function down()
    {
        Schema::dropIfExists('reportes_inundacion');
    }
};