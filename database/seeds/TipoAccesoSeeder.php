<?php

use Illuminate\Database\Seeder;
use App\Tipo_Acceso;

class TipoAccesoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ta = new Tipo_Acceso();
        $ta->nombre = "Acceso normal";
        $ta->save();
        $ta = new Tipo_Acceso();
        $ta->nombre = "Acceso con código";
        $ta->save();
    }
}
