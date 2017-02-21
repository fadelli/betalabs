<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePerfilAcoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perfil_acoes', function (Blueprint $table) {
            $table->integer('id_perfil')->unsigned();
            $table->integer('id_acoes')->unsigned();

            $table->primary(['id_perfil', 'id_acoes']);

            $table->foreign('id_perfil')->references('id')->on('perfils');
            $table->foreign('id_acoes')->references('id')->on('acoes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perfil_acoes');
    }
}
