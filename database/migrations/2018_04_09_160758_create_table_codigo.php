<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCodigo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('codigo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_usuario')->unsigned();
            $table->string('contenido', 255)->unique();
            $table->integer('usos_restantes')->default(1);
            $table->boolean('vigente')->default(1);
            $table->integer('id_tipo_codigo')->unsigned();
            $table->string('nombre_visitante');
            $table->string('domicilio');
            $table->string('imagen');
            $table->timestamps();
        });
        Schema::table('codigo', function (Blueprint $table) {
            $table->foreign('id_usuario')->references('id')->on('users');
        });
        Schema::table('codigo', function (Blueprint $table) {
            $table->foreign('id_tipo_codigo')->references('id')->on('tipo_codigo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('codigo', function (Blueprint $table) {
            //
        });
    }
}
