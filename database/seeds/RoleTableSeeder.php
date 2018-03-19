<?php

use Illuminate\Database\Seeder;
use App\Role;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = new Role();
        $admin->name = 'Administrador';
        $admin->description = 'Usuario administrador. Jefe de colonos o similar';
        $admin->save();
        $colono = new Role();
        $colono->name = 'Colono';
        $colono->description = 'Usuario normal. Residente del fraccionamiento privado';
        $colono->save();
    }
}
