<?php

use Illuminate\Database\Seeder;
use App\Tipo_Codigo;

class TipoCodigoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tc = new Tipo_Codigo();
        $tc->nombre = "Personal";
        $tc->save();
        $tc = new Tipo_Codigo();
        $tc->nombre = "Evento";
        $tc->save();
    }
}
