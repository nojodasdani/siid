<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('telefono');
            $table->integer('id_numero')->unsigned()->nullable();
            $table->boolean('acceso_sistema')->default(0);
            $table->boolean('acceso_fraccionamiento')->default(1);
            $table->boolean('visto')->default(0);
            $table->boolean('aceptado')->default(0);
            $table->boolean('acepta_visitas')->default(1);
            $table->boolean('activo')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
        //Schema::dropIfExists('tipo_visitante');
        //Schema::dropIfExists('modelo');
        //Schema::dropIfExists('marca');
        //Schema::dropIfExists('color');
        //Schema::dropIfExists('numero');
        //Schema::dropIfExists('calle');
    }
}
