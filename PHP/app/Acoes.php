<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Acoes extends Model
{
    //protected $table = 'acoes';
    public $timestamps = false;

    public function roles($userId){
    	$collection = $this
    		->select(['acoes.chave'])
    		->join('perfil_acoes', 'perfil_acoes.id_acoes', '=', 'acoes.id' )
    		->join('perfils', 'perfils.id', '=', 'perfil_acoes.id_perfil' )
    		->join('usuario_perfils', 'usuario_perfils.id_perfil', '=', 'perfils.id' )
    		->join('usuarios', 'usuarios.id', '=', 'usuario_perfils.id_usuario' )
    		->where('usuarios.id', $userId)
    		->groupby('acoes.id')
    		->get();

    	$roles = [];
    	foreach ($collection as $item) {
    		$roles[] = $item->chave;
    	}
    	return $roles;

    }


}
