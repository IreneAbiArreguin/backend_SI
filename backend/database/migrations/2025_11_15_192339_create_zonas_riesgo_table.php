<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('zonas_riesgo', function (Blueprint $table) {

            $table->increments('id_zona');

            $table->string('identificador', 50)->unique();

            $table->unsignedTinyInteger('id_nivel'); 

            $table->json('poligono');

            $table->timestamps();

            $table->foreign('id_nivel')
                  ->references('id_nivel')
                  ->on('niveles_riesgo')
                  ->onDelete('restrict')
                  ->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('zonas_riesgo');
    }
};
