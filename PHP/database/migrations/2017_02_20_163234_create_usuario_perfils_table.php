<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsuarioPerfilsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario_perfils', function (Blueprint $table) {
            $table->integer('id_perfil')->unsigned();
            $table->integer('id_usuario')->unsigned();

            $table->primary(['id_perfil', 'id_usuario']);

            $table->foreign('id_perfil')->references('id')->on('perfils');
            $table->foreign('id_usuario')->references('id')->on('usuarios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuario_perfils');
    }
}
