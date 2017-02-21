<?php

use Illuminate\Database\Seeder;

class PerfilAcoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\PerfilAcoes::create([
        	'id_perfil'  	=> '1',
        	'id_acoes'  	=> '1',
        ]);
    }
}
