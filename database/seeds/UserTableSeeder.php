<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Role;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrador = Role::find(1);
        $colono = Role::find(2);
        $admin = new User();
        $admin->name = 'Prueba Administrador';
        $admin->email = 'administrador@123.com';
        $admin->password = bcrypt('secret');
        $admin->visto = 1;
        //$admin->id_numero = 10;
        $admin->save();
        $admin->roles()->attach($administrador);
        $col = new User();
        $col->name = 'Prueba Colono';
        $col->email = 'colono@123.com';
        $col->password = bcrypt('secret');
        $col->visto = 1;
        //$col->id_numero = 154;
        $col->save();
        $col->roles()->attach($colono);
    }
}
