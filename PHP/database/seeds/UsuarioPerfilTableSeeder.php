<?php

use Illuminate\Database\Seeder;

class UsuarioPerfilTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         App\UsuarioPerfil::create([
        	'id_perfil'  	=> '1',
        	'id_usuario'  	=> '1',
        ]);
    }
}
