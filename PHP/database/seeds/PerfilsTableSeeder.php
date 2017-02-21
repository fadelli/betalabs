<?php

use Illuminate\Database\Seeder;

class PerfilsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Perfil::create([
        	'nome'  	=> 'Admin',
        ]);
    }
}
