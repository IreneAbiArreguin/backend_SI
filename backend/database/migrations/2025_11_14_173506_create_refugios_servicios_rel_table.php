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
        Schema::create('refugios_servicios_rel', function (Blueprint $table) {
            $table->increments('id_rel');
            $table->integer('id_refugio')->unsigned();
            $table->integer('id_servicio')->unsigned();
            $table->boolean('disponible')->default(true);
            $table->timestamps();

            $table->foreign('id_refugio')->references('id_refugio')->on('refugios')
                ->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('id_servicio')->references('id_servicio')->on('refugios_servicios')
                ->onDelete('restrict')->onUpdate('cascade');
                
            $table->unique(['id_refugio', 'id_servicio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refugios_servicios_rel');
    }
};
