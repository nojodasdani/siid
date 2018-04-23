<?php

use Illuminate\Database\Seeder;
use App\Estatus;

class EstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $s = new Estatus();
        $s->nombre = "Dentro";
        $s->save();
        $s = new Estatus();
        $s->nombre = "Fuera";
        $s->save();
    }
}
