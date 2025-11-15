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
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id_usuario');
            $table->string('nombre', 50);
            $table->string('apellido', 50);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->string('telefono', 20)->nullable();
            $table->string('ubicacion', 100)->nullable();
            $table->decimal('latitud', 10, 8)->nullable();
            $table->decimal('longitud', 11, 8)->nullable();
            $table->timestamp('email_verificado_at')->nullable();
            $table->tinyInteger('id_rol')->unsigned();
            $table->rememberToken();
            $table->timestamps();

            $table->foreign('id_rol')->references('id_rol')->on('roles')
                ->onDelete('restrict')->onUpdate('cascade');
                
            $table->index(['latitud', 'longitud']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
