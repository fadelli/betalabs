<?php

use Illuminate\Database\Seeder;

class AcoesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\Acoes::create([
        	'nome'  	=> 'Admin',
        	'chave'  	=> 'Admin_Sistema',
        ]);
    }
}
