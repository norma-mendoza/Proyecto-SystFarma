<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        //insertamos empleados
        DB::table('empleados')->insert([
            "id" => "1",
            "nombre" => "admin"
        ]);
        DB::table('empleados')->insert([
            "id" => "2",
            "nombre" => "almacenero"
        ]);
        DB::table('empleados')->insert([
            "id" => "3",
            "nombre" => "vendedro"
        ]);

        //insertamos usuarios
        DB::table('users')->insert([
            "id" => "1",
            "usuario" => "admin",
            "password" => bcrypt('admin'),
            "condicion" => "1",
            "idrol" => "1",
        ]);
        DB::table('users')->insert([
            "id" => "2",
            "usuario" => "almacenero",
            "password" => bcrypt('almacenero'),
            "condicion" => "1",
            "idrol" => "3",
        ]);
        DB::table('users')->insert([
            "id" => "3",
            "usuario" => "vendedor",
            "password" => bcrypt('vendedor'),
            "condicion" => "1",
            "idrol" => "2",
        ]);
    }
}