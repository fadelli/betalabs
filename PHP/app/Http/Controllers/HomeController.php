<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use App\Usuario;
use App\Comentario;
use App\config;
use File;


class HomeController extends Controller
{
	private $user;
	private  $comentarios;
	public function __construct(Usuario $user, Comentario $comentarios){
		$this->user = $user;
		$this->comentarios = $comentarios;
	}

    public function index(){
    	
    	$comentarios = json_decode( $this->getComentarios());
    	
    	return view('home.index', compact('comentarios')  );
    }

    public function auth(Request $req) 
    {
    	$credenciais = ['email' => $req->email, 'password' => $req->password];

        if ( Auth::attempt($credenciais, true) ){
            $this->user = auth()->user();
            $respota = [
                'status' => true,
                'dados' => [
                    'id'    	=> $this->user->id,
                	'nome'   	=> $this->user->name,
                    'email'     => $this->user->email,
                    'token'     => $this->user->remember_token,
                	'foto'     	=> $this->user->foto
                ] 
            ];  
            return json_encode($respota);
        }else {
        	$respota = [
                'status' => false,
                'dados' => false
            ];  
            return json_encode($respota);
        }
    }
    
    public function setFotoUsuario(Request $req){
    	$user = $this->user->where('id',$req->idUser)->where('remember_token',$req->token);
    	if($user){
    		
    		if(Input::file('fotoUser')){
    			$imagem = Input::file('fotoUser');
    			
    			$extensao = strtolower($imagem->getClientOriginalExtension());
    			if($extensao == 'jpg' || $extensao == 'png'){
    				File::move($imagem, public_path().'/imagem-usuarios/id_usuario'.$req->idUser.$extensao);
    				$fotoUser = 'imagem-usuarios/id_usuario'.$req->idUser.$extensao;
    				$update = $user->update([
    						'foto' => $fotoUser,
    				]);
    				if($update){
    					return redirect('/?foto_user=true&extensao='.$extensao); //json_encode(['status' => true,'dados' => ['foto'  => $fotoUser,]]);
    				}else {
    					return redirect('/?foto_user=false'); //json_encode(['status' => false]);
    				}
    			}else {
    				return redirect('/?foto_user=false'); //json_encode(['status' => false]);
    			}
			}
    	}else {
    		return redirect('/?foto_user=false'); //json_encode(['status' => false]);
    	}
    }

    public function cadastrarUsuario(Request $req) {
    	
    	$emailUser = $this->user->where('email', $req->email)->count();
    	if( $emailUser != '0'){
    		return json_encode(['status' => false, 'email' => true]);
    	}else{
    		
    		$insert = $this->user->create([
    				'name' 		=> $req->name,
    				'email' 	=> $req->email,
    				'foto'		=> 'imagens/avatar_padrao.jpg',
    				'password' 	=> bcrypt($req->password),
    		]);
    		if($insert){
    			return json_encode(['status' => true]);
    		}else {
    			return json_encode(['status' => false]);
    		}
    	}
    }
    
    public function excluirComentario(Request $req){    	
    	$comentario = $this->comentarios->find($req->idComentario);
    	$user = $comentario->usuarios;
    	
    	if($user->remember_token == $req->token && $user->id == $req->idUser){
    		$delete = $comentario->delete();
    		if($delete){
    			return json_encode(['status' => true]);
    		}else {
    			return json_encode(['status' => false]);
    		}
    	}else {
    		return json_encode(['status' => false]);
    	}
    	
    }
    public function editarComentario(Request $req){
    	$comentario = $this->comentarios->find($req->idComentario);
    	$user = $comentario->usuarios;
    	 
    	if($user->remember_token == $req->token && $user->id == $req->idUser){
    		$update = $comentario->update(['comentario' => $req->comentario ]);
    		if($update){
    			return json_encode(['status' => true]);
    		}else {
    			return json_encode(['status' => false]);
    		}
    	}else {
    		return json_encode(['status' => false]);
    	}
    }
    
    public function editarUsuario(Request $req) {
    	
    		$user = $this->user->where('id',$req->idUser)->where('remember_token',$req->token);
    		if($user){
    			if($req->password != "senhapadrao!@#"){
    				$update = $user->update([
    						'name' => $req->name,
    						'email' => $req->email,
    						'password' => bcrypt($req->password),
    				]);
    			}else {
    				$update = $user->update([
    						'name' => $req->name,
    						'email' => $req->email
    				]);
    			}
	    		if($update){
	    			return json_encode([
	    				'status' => true,
    					'dados' => [
    							'nome'   	=> $req->name,
    							'email'     => $req->email
    					]
	    			]);
	    		}else {
	    			return json_encode(['status' => false]);
	    		}
    		}else {
    			return json_encode(['status' => false]);
    		}
    }
    
    public function getUsuario(Request $req) {
    	 
    	$user = $this->user->find($req->idUser);
    	if($user){
    		 $respota = [
                'status' => true,
                'dados' => [
                    'idUser'    => $user->id, 
                    'email'     => $user->email,
                    'token'     => $user->remember_token
                ] 
            ];  
            return json_encode($respota);
    	}else {
    		$respota = [
    				'status' => false,
    				'dados' => false
    		];
    		return json_encode($respota);
    	}
    }
    
    public function getComentarios(){
    	
    	$comentarios = DB::table('comentarios')->leftJoin('usuarios', 'usuarios.id', '=', 'comentarios.usuarios_id')->select('comentarios.*', 'usuarios.foto', 'usuarios.name')->get();
    	$newComentarios = array();
		    	
    	foreach ($comentarios as $comentario => $value){
    		$newComentarios[$comentario]['id'] = $comentarios[$comentario]->id;
    		$newComentarios[$comentario]['comentario'] = $comentarios[$comentario]->comentario;
    		$newComentarios[$comentario]['data'] = date('d/m/Y H:i', strtotime($comentarios[$comentario]->updated_at));
    		$newComentarios[$comentario]['nome'] = $comentarios[$comentario]->name;
    		$newComentarios[$comentario]['usuarios_id'] = $comentarios[$comentario]->usuarios_id;
    		$newComentarios[$comentario]['foto'] = $comentarios[$comentario]->foto;
    	}
    	
    	return json_encode( $newComentarios);
    }
    
    public function getComentarioId($id){
    	 
    	$coment = $this->comentarios->find($id);
    	
    	if($coment){
    		$newComentarios['id'] = $coment->id;
    		$newComentarios['comentario'] = $coment->comentario;
    		$newComentarios['dataCriacao'] = date('d/m/Y H:i', strtotime($coment->created_at));
    		$newComentarios['dataAtualizacao'] = date('d/m/Y H:i', strtotime($coment->updated_at));
    		return json_encode( $newComentarios);
    	}
    	return json_encode(['status' => false]);
    }
    
    public function cadastrarComentario(Request $req) {
    	$user = $this->user->where('id',$req->idUser)->where('remember_token',$req->token);
    	if($user){
    		$insert = $this->comentarios->create([
    				'comentario' => $req->comentario,
    				'usuarios_id' => $req->idUser,
    		]);
    		if($insert){
    			return json_encode(['status' => true]);
    		}else {
    			return json_encode(['status' => false]);
    		}
    	}
    }
}
