<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVisitantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitante', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_auto')->unsigned();
            $table->integer('id_tipo_visitante')->unsigned();
            $table->string('nombre');
            $table->string('ultima_visita')->nullable();
            $table->boolean('permitido')->default(1);
            $table->text('descripcion')->nullable();
            $table->binary('foto_cara')->nullable();
            $table->timestamps();
        });
        //    <img src="data:image/jpeg;base64,'.base64_encode( $imageBlob ).'"/>
        Schema::table('visitante', function (Blueprint $table) {
            $table->foreign('id_auto')->references('id')->on('auto');
        });
        Schema::table('visitante', function (Blueprint $table) {
            $table->foreign('id_tipo_visitante')->references('id')->on('tipo_visitante');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('visitante');
    }
}
