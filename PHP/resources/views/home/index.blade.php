@extends('templates.template')

@section('content')
	<div id="mascara"></div>
	<div class="container-fluid">
		<div class="headerHome">
			<div class="container">
				<div class="row">
					<div class="logo">
						<img src="imagens/logo.jpg" alt="">
					</div>
					<div class="headerBemVindo yesLogin">
						<h2></h2>
						<h3 data-toggle="modal" data-target="#modalFormEditar"> - <strong>Meus Dados</strong></h3>
					</div>

					<div class="btnHeader noLogin">
						<a href="" class="btnCadastrar" data-toggle="modal" data-target="#modalFormCadastrar">Cadastre-se</a>
						<a href="" id="btnEntrar" class="btnEntrar">Entrar</a>
					</div>
					
					<!--form login-->
					<div id="formLogin" class="formstyle1">
					    <form method="POST" action="/auth/login">
					    	<div class="modal-body">
							    {!! csrf_field() !!}
							    <div class="input-group">
							        <span class="input-group-addon">Email:</span>
							        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Digite seu email">
							    </div>
							    <div class="input-group">
							        <span class="input-group-addon">Senha:</span>
							        <input type="password" class="form-control" name="password" id="password" placeholder="Digite sua senha">
							    </div>
							</div>
						    <div class="modal-footer">
						    	<button class="navbar-inverse" type="submit">Entrar</button>
						    </div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="barDivider navbar-inverse">
			<div class="container">
				<div class="menuHeader">
					<a class="ativo" href="#">Comentários</a>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid">
		<div class="container comentarios">
			<!--formulario para excluir comentarios-->
			<div id="formExcluirCometario">
				<form action="/excluir/comentario" method="post">
			    	{!! csrf_field() !!}
					<input type="hidden" name="idUser" value="">
					<input type="hidden" name="token" value="">
					<input type="hidden" name="idComentario" value="">
				</form>
			</div>
			<div class="formCometario">
				<form action="/cadastrar/comentario" method="post"> 
			    	{!! csrf_field() !!}
			    	<div class="input-group">
						<textarea class="form-control" name="comentario" disabled="" placeholder="Comente aqui... "></textarea>
					</div>
					<input type="hidden" name="idUser" value="">
					<input type="hidden" name="token" value="">
					<button type="submit" class="btn btn-default" disabled=""><i class="fa fa-commenting" aria-hidden="true"> Comentar</i>
					</button>
				</form>
			</div>

			<div id="myComentarios">
		    	@forelse ($comentarios as $comentario)
			    	<div class="itemComentario">
			    		<input type="hidden" class="idComentario" value="{{$comentario->id}}">
			    		<input type="hidden" class="idUserComentario" value="{{$comentario->usuarios_id}}">
		    			<div class="ComentarioL">
		    				<img class="fotoUsuerComentario" src="{{ $comentario->foto }}" alt="foto">	
		    			</div>
		    			<div class="ComentarioR">
		    				<h3 class="nomeAutor" >{{ $comentario->nome }}</h3>
			    			<h3 class="dataComentario">{{ $comentario->data }}</h3>
			    		</div>
			    		<div class="descricaoComentario">{{ $comentario->comentario }}</div>
			    	</div>
				@empty
			    	<div class="itemComentario">
			    		<p>Ainda não temos nenhum comentário.</p>
			    	</div>
				@endforelse
		    </div>
		</div>
	</div>
    

    <!--inicio dos modals-->
    <!--Modal de cadastro-->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalFormCadastrar">
		<div class="modal-dialog" role="document">
			<div class="modal-content formstyle1">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Cadastro de usuário</h4>
				</div>
				<!--form cadastro de usuario-->
				<form method="POST" action="/cadastrar/usuario">
					<div class="modal-body">
				    	{!! csrf_field() !!}
					    <div class="input-group">
							<span class="input-group-addon">Nome:</span>
					        <input class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="Digite seu nome">
					    </div>

					    <div class="input-group">
							<span class="input-group-addon">Email:</span>
					        <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Digite seu email">
					    </div>

					    <div class="input-group">
							<span class="input-group-addon">Senha:</span>
					        <input class="form-control" type="password" name="password" placeholder="Digite uma senha">
					    </div>

					    <div class="input-group">
							<span class="input-group-addon">Confirmar Senha:</span>
					        <input class="form-control" type="password" name="password_confirmation" placeholder="Confirme sua senha">
					    </div>
					</div>
					<div class="modal-footer">
						<button class="navbar-inverse" type="submit">Cadastrar</button>
					</div>	
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->


	<div class="modal fade" tabindex="-1" role="dialog" id="modalFormEditarComentario">
		<div class="modal-dialog" role="document">
			<div class="modal-content formstyle1">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Editar comentário</h4>
				</div>
				<!--form cadastro de usuario-->
				<form method="POST" action="/editar/comentario">
					<div class="modal-body">
				    	{!! csrf_field() !!}
				    	<div class="input-group">
							<span class="input-group-addon">Data criação:</span>
					        <input class="form-control" type="text" name="dataCriacao" disabled="" >
					    </div>
					    <div class="input-group">
					        <span class="input-group-addon">Data da última atualização:</span>
					        <input class="form-control" type="text" name="dataAtualizacao" disabled="" >
					    </div>
				    	<input type="hidden" name="idUser" value="">
						<input type="hidden" name="token" value="">
						<input type="hidden" name="idComentario" value="">
				    	<div class="input-group decricaoComentario">
							<textarea class="form-control" name="comentario" placeholder="Comente aqui... "></textarea>
						</div>
					</div>
					<div class="modal-footer">
						<button class="navbar-inverse" type="submit">Editar</button>
					</div>	
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
	<!--modal editar dados-->
    <div class="modal fade" tabindex="-1" role="dialog" id="modalFormEditar">
		<div class="modal-dialog" role="document">
			<div class="modal-content formstyle1">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">Editar meus dados</h4>
				</div>
				<!--form upload de foto-->
				<form method="POST" id="formEditarFoto" action="/cadastrar/usuario/foto" enctype="multipart/form-data">
					<div class="modal-body">
				    	{!! csrf_field() !!}
				    	<input type="hidden" name="idUser" value="">
				    	<input type="hidden" name="token" value="">
				    	<div id="fotoUser">
				    		<img  src="imagens/avatar_padrao.jpg" alt="foto" >
				    		<h3>Atualizar foto</h3>
				    	</div>
						<div style='height: 0px;width: 0px; overflow:hidden;'>
							<input id="upfile" type="file" name="fotoUser" value="upload" />
						</div>
					</div>
				</form>
				<!--form cadastro de usuario-->
				<form method="POST" id="formEditarCadastro" action="/editar/usuario">
					<div class="modal-body">
						<input type="hidden" name="idUser" value="">
						<input type="hidden" name="token" value="">
				    	{!! csrf_field() !!}
					    <div class="input-group">
							<span class="input-group-addon">Nome:</span>
					        <input class="form-control" type="text" name="name" value="{{ old('name') }}" placeholder="Digite seu nome">
					    </div>

					    <div class="input-group">
							<span class="input-group-addon">Email:</span>
					        <input class="form-control" type="email" name="email" value="{{ old('email') }}" placeholder="Digite seu email">
					    </div>

					    <div class="input-group">
							<span class="input-group-addon">Senha:</span>
					        <input class="form-control" type="password" name="password" placeholder="Digite uma senha" 
					        	value="senhapadrao!@#">
					    </div>

					    <div class="input-group">
							<span class="input-group-addon">Confirmar Senha:</span>
					        <input class="form-control" type="password" name="password_confirmation" placeholder="Confirme sua senha" value="senhapadrao!@#" >
					    </div>
					</div>
					<div class="modal-footer">
						<button class="navbar-inverse" type="submit">Editar</button>
					</div>	
				</form>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

	<!-- Modal de msgs-->
	<div class="modal fade" id="modalMsg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content formstyle1">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	      </div>
	      <div class="modal-body">
	        <div id="msg" class="alert" role="alert">...</div>
	      </div>
	      <div class="modal-footer">
	        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
	        
	      </div>
	    </div>
	  </div>
	</div>

@endsection