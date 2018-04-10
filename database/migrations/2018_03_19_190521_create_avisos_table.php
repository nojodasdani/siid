<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvisosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aviso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('texto', 255)->unique();
            $table->boolean('visible')->default(1);
            $table->integer('creado_por')->unsigned();
            $table->timestamps();
        });
        Schema::table('aviso', function (Blueprint $table) {
            $table->foreign('creado_por')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aviso');
    }
}
