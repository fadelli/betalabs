<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsuariosTableSeeder::class);
        $this->call(PerfilsTableSeeder::class);
        $this->call(AcoesTableSeeder::class);
        $this->call(PerfilAcoesTableSeeder::class);
        $this->call(UsuarioPerfilTableSeeder::class);
    }
}
