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
            $table->integer('id_colono')->unsigned();
            $table->integer('id_tipo_acceso')->unsigned();
            $table->integer('id_status')->unsigned();
            $table->integer('id_codigo')->nullable()->unsigned();
            $table->string('nombre_colono');
            $table->string('domicilio');
            $table->timestamps();
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
