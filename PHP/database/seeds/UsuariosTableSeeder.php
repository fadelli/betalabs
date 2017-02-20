<?php

use Illuminate\Database\Seeder;

class UsuariosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         App\Usuario::create([
        	'name'  	=> 'Admin Betalabs',
        	'email'  	=> 'thiagofadelli1985@gmail.com',
        	'password'	=> bcrypt('betalabs'),
         	'foto'		=> 'imagens/avatar_padrao.jpg'
        ]);
    }
}
