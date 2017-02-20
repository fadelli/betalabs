<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Usuario;
use App\Comentario;

class HomeController extends Controller
{
	public function __construct(Usuario $user, Comentario $comentarios){
		session_start();
		$this->user = $user;
		$this->comentarios = $comentarios;
	}
    public function index(){
    	dd($_SESSION);
		return 'teste';
	}
}
