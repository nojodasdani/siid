<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto', function (Blueprint $table) {
            $table->increments('id');
            $table->char('placa', 10)->unique();
            $table->integer('id_modelo')->unsigned();
            $table->integer('id_color')->unsigned();
            $table->binary('foto_placa')->nullable();
            $table->binary('foto_auto')->nullable();
            $table->timestamps();
        });
        //    <img src="data:image/jpeg;base64,'.base64_encode( $imageBlob ).'"/>
        Schema::table('auto', function (Blueprint $table) {
            $table->foreign('id_modelo')->references('id')->on('modelo');
        });
        Schema::table('auto', function (Blueprint $table) {
            $table->foreign('id_color')->references('id')->on('color');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('auto');
    }
}
