<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    
	protected $fillable = [
			'comentario', 'usuarios_id'
	];
	
	public function usuarios()
	{
		return $this->belongsTo(Usuario::class);
	}
}
