<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('calle')) {
            Schema::create('calle', function (Blueprint $table) {
                $table->increments('id');
                $table->string('calle');
            });
        }
        if (!Schema::hasTable('numero')) {
            Schema::create('numero', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_calle')->unsigned();
                $table->string('numero');
            });
            Schema::table('numero', function (Blueprint $table) {
                $table->foreign('id_calle')->references('id')->on('calle');
            });
            Schema::table('users', function (Blueprint $table) {
                $table->foreign('id_numero')->references('id')->on('numero');
            });
        }
        if (!Schema::hasTable('color')) {
            Schema::create('color', function (Blueprint $table) {
                $table->increments('id');
                $table->string('color');
            });
        }
        if (!Schema::hasTable('marca')) {
            Schema::create('marca', function (Blueprint $table) {
                $table->increments('id');
                $table->string('marca');
                $table->string('imagen')->default('marcas/imagen.jpg');
            });
        }
        if (!Schema::hasTable('modelo')) {
            Schema::create('modelo', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('id_marca')->unsigned();
                $table->string('modelo');
            });
            Schema::table('modelo', function (Blueprint $table) {
                $table->foreign('id_marca')->references('id')->on('marca');
            });
        }
        if (!Schema::hasTable('tipo_visitante')) {
            Schema::create('tipo_visitante', function (Blueprint $table) {
                $table->increments('id');
                $table->string('tipo');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
}
