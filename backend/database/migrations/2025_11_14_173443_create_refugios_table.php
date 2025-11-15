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
        Schema::create('refugios', function (Blueprint $table) {
            $table->increments('id_refugio');
            $table->string('nombre', 150);
            $table->text('direccion');
            $table->integer('capacidad_total')->unsigned();
            $table->integer('capacidad_actual')->unsigned()->default(0);
            $table->smallInteger('id_municipio')->unsigned()->nullable();
            $table->tinyInteger('estado_refugio_id')->unsigned();
            $table->string('telefono_contacto', 30)->nullable();
            $table->string('responsable', 120)->nullable();
            $table->decimal('latitud', 10, 8);
            $table->decimal('longitud', 11, 8);
            $table->timestamps();

            $table->foreign('id_municipio')->references('id_municipio')->on('municipios')
                ->onDelete('set null')->onUpdate('cascade');
            $table->foreign('estado_refugio_id')->references('id_estado_refugio')->on('estados_refugio')
                ->onDelete('restrict')->onUpdate('cascade');
                
            $table->index(['latitud', 'longitud']);
            $table->index(['id_municipio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refugios');
    }
};
