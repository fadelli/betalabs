<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Usuario;
use App\Comentario;

class HomeController extends Controller
{
	public function __construct(Usuario $user, Comentario $comentarios){
		$this->user = $user;
		$this->comentarios = $comentarios;
	}
    public function index(){
    	$comentarios = $this->comentarios->all();
		return view('admin.index' , compact('comentarios'));
	}

	public function excluirComentario($id){
		$delete = $this->comentarios->find($id)->delete();
		return redirect()->route('admin');
	}

	public function excluirTodosComentarios(){
		
		$delete = DB::table('comentarios')->delete();
		
		return redirect()->route('admin');
	}

}
