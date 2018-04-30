<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAccesosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accesos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_visitante')->nullable()->unsigned();
            $table->integer('id_colono')->nullable()->unsigned();
            $table->integer('id_tipo_acceso')->unsigned();
            $table->integer('id_status')->unsigned();
            $table->integer('id_codigo')->nullable()->unsigned();
            $table->string('nombre_colono');
            $table->string('domicilio');
            $table->timestamps();
        });
        Schema::table('accesos', function (Blueprint $table) {
            $table->foreign('id_visitante')->references('id')->on('visitante');
        });
        Schema::table('accesos', function (Blueprint $table) {
            $table->foreign('id_colono')->references('id')->on('users');
        });
        Schema::table('accesos', function (Blueprint $table) {
            $table->foreign('id_tipo_acceso')->references('id')->on('tipo_acceso');
        });
        Schema::table('accesos', function (Blueprint $table) {
            $table->foreign('id_status')->references('id')->on('estatus');
        });
        Schema::table('accesos', function (Blueprint $table) {
            $table->foreign('id_codigo')->references('id')->on('codigo');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accesos');
    }
}
