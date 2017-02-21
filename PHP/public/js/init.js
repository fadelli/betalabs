function sub(obj){
	var file = obj.value;
	var fileName = file.split("\\");
	document.getElementById("yourBtn").innerHTML = fileName[fileName.length-1];
	document.myForm.submit();
	event.preventDefault();
}
function setCookie(name,value,exdays){
	var expires;
	var date; 
	var value;
	date = new Date(); //  criando o COOKIE com a data atual
	date.setTime(date.getTime()+(exdays*24*60*60*1000));
	expires = date.toUTCString();
	document.cookie = name+"="+value+"; expires="+expires+"; path=/";
}
function getCookie(name){
	var value = "; " + document.cookie;
	var parts = value.split("; " + name + "=");
	if (parts.length == 2) 
		return parts.pop().split(";").shift();
	else
		return null;
}
function eraseCookie(name){ 
	setCookie(name,"" ,-1); // deletando o cookie encontrado a partir do mostraCookie
}



function queryObj() {
    var result = {}, keyValuePairs = location.search.slice(1).split("&");
    keyValuePairs.forEach(function(keyValuePair) {
        keyValuePair = keyValuePair.split('=');
        result[decodeURIComponent(keyValuePair[0])] = decodeURIComponent(keyValuePair[1]) || '';
    });
    return result;
}
function listarComentarios(){
	$.ajax({
		url: '/listar/comentarios',
		type: 'GET',
		dataType: 'json',
		success: function ( myComentarios ){
			htmlComentarios = "";
			for(item in myComentarios){
				htmlComentarios+= '<div class="itemComentario">';
				htmlComentarios+= '<input type="hidden" class="idComentario" value="'+myComentarios[item].id+'">';
				htmlComentarios+= '<input type="hidden" class="idUserComentario" value="'+myComentarios[item].usuarios_id+'">';
				htmlComentarios+= '<div class="ComentarioL">';
				htmlComentarios+= '<img class="fotoUsuerComentario" src="'+myComentarios[item].foto+'" alt="foto">';
				htmlComentarios+= '</div>';
				htmlComentarios+= '<div class="ComentarioR">';
				htmlComentarios+= '<h3 class="nomeAutor" >'+myComentarios[item].nome+'</h3>';
				htmlComentarios+= '<h3 class="dataComentario">'+myComentarios[item].data+'</h3>';
				htmlComentarios+= '</div>';
				htmlComentarios+= '<div class="descricaoComentario">'+myComentarios[item].comentario+'</div>';
				htmlComentarios+= '</div>';
			}
			$("#myComentarios").html(htmlComentarios);
			organizarComentarios();
			addBtnEditarExcluirComentario();
		}
	});
}

function listarComentarioId(id){
	$.ajax({
		url: '/dados/comentario/' +id,
		type: 'GET',
		dataType: 'json',
		success: function ( comentario ){
			
			return comentario;
		}
	});
}

function logout(){

	eraseCookie('betalabsUserId');
	eraseCookie('betalabsUserNome');
	eraseCookie('betalabsUserEmail');
	eraseCookie('betalabsUserToken');
	eraseCookie('betalabsUserFoto');

}
function addBtnEditarExcluirComentario(){
	
	idUserAtual = dadosUser.id;
	$(".itemComentario").each(function(){ 
		if($(this).children('.idUserComentario').val() == idUserAtual){
			$(this).addClass('editarComentario');

		}
	});

	$(".editarComentario").hover(function (){
		html = '<div class="btnEditarExcluir">'
		html+= '<button class="btn btn-default btnEditarComentario"><i class="glyphicon glyphicon-edit"></i> Editar</button>'
		html+= '<button class="btn btn-default btnExcluirComentario"><i class="glyphicon glyphicon-remove"></i> Excluir</button>'
		html+= '</>'
		$(this).append(html);
		$(".btnExcluirComentario").click(function(){
			pai = $(this).parent('.btnEditarExcluir').parent('.itemComentario');
			idComentario = pai.children('.idComentario').val();
			$("#formExcluirCometario form input[name='idComentario']").val(idComentario);
			$("#formExcluirCometario form input[name='idUser']").val(dadosUser.id);
			$("#formExcluirCometario form input[name='token']").val(dadosUser.token);
			$("#formExcluirCometario form").submit();
		});
		$(".btnEditarComentario").click(function(){
			pai = $(this).parent('.btnEditarExcluir').parent('.itemComentario');
			idComentario = pai.children('.idComentario').val();
			Comentario = pai.children('.descricaoComentario').html();
			$("#modalFormEditarComentario form input[name='idComentario']").val(idComentario);
			$("#modalFormEditarComentario form input[name='idUser']").val(dadosUser.id);
			$("#modalFormEditarComentario form input[name='token']").val(dadosUser.token);
			$("#modalFormEditarComentario textarea").val(Comentario);

			$.ajax({
				url: '/dados/comentario/' +idComentario,
				type: 'GET',
				dataType: 'json',
				success: function ( comentario ){
					console.log(comentario);
					if(comentario.status != false){
						$("#modalFormEditarComentario form input[name='dataCriacao']").val(comentario.dataCriacao);
						$("#modalFormEditarComentario form input[name='dataAtualizacao']").val(comentario.dataAtualizacao);
						$("#modalFormEditarComentario").modal("show");
					}
				}
			});
			
		});
	},function (){
		$(this).children('.btnEditarExcluir').remove();
	});

}

function organizarComentarios(){
	qtdElementos = 3;
	distancia = 6;
	tamCantainer = $('#myComentarios').width();
	tamItem = tamCantainer / 3 - (distancia * (qtdElementos - 1));
	$('#myComentarios .itemComentario').css('width', tamItem+'px');


	$('#myComentarios').wookmark({
		align: $(".itemComentario").length > 2 ? 'center' : 'left',
	    offset: distancia, // Optional, the distance to the containers border
	    itemWidth: tamItem, // Optional, the width of a grid item
	    autoResize: true,
	});
}

diasCookie = 1;
tempo = 400;
textoBenVindo = 'Bem vindo, ';
var dadosUser = {
  	setUser: function() {
  		this.id 	= getCookie('betalabsUserId');
		this.nome 	= getCookie('betalabsUserNome');
		this.email 	= getCookie('betalabsUserEmail');
		this.token 	= getCookie('betalabsUserToken');
		this.foto 	= getCookie('betalabsUserFoto');

		$("#modalFormEditar form input[name='idUser']").val(this.id);
		$("#modalFormEditar form input[name='name']").val(this.nome);
		$("#modalFormEditar form input[name='email']").val(this.email);
		$("#modalFormEditar form input[name='token']").val(this.token);
		$(".formCometario form input[name='idUser']").val(this.id);
		$(".formCometario form input[name='token']").val(this.token);
		$("#fotoUser img").attr('src',this.foto);
  	}
};


$(function(){
	var myParam = queryObj();
	if (myParam['foto_user'] == 'true' && getCookie('betalabsUserToken') != null) {
		id = getCookie('betalabsUserId');
		setCookie('betalabsUserFoto', 'imagem-usuarios/id_usuario'+id+myParam['extensao'],diasCookie);
        dadosUser.setUser();
        $("#modalFormEditar").modal();
    }else if(myParam['foto_user'] == 'false' && getCookie('betalabsUserToken') != null){
    	$("#msg").html("Foto não atualizada, extensao do arquivo tem que ser *.jpg ou  *.png").addClass('alert-danger');
		$("#modalFormCadastrar").modal('hide');
		$("#modalMsg").modal('show');
    }


	dadosUser.setUser();
	organizarComentarios();
	$(".btnHeader a").click(function(event){
		event.preventDefault();
	});

	$("#fotoUser").click(function(){
		$("#upfile").click();
	});
	$("#upfile").change(function(event){

		$("#formEditarFoto").submit();
		event.preventDefault();
	})

	$( "#fotoUser" ).hover(
	  function() {
	    $(this).children("h3").show();
	  }, function() {
	    $(this).children("h3").hide();
	  }
	);

	
	$("#btnEntrar").click(function(event){
		event.preventDefault();
		$("#formLogin").slideToggle(tempo);
		$("#mascara").slideToggle(0);
	});
	$("#mascara").click(function(){
		$("#formLogin").slideUp(tempo);
		$("#mascara").slideToggle(0);
	});

	
	if(dadosUser.token){
		addBtnEditarExcluirComentario();
		$(".headerBemVindo h2").html(textoBenVindo+dadosUser.nome);
		$(".noLogin").hide();
		$(".headerBemVindo").slideToggle(tempo);
		$(".formCometario form textarea, .formCometario form button[type='submit'] ").removeAttr('disabled');
	}else{
		$(".noLogin").show();
	}

	$("#");

	$("#formLogin form").submit(function(){
		url = $(this).attr('action');
		dados = $(this).serialize();
		$(this).each(function(){
		  this.reset();
		});
		$.ajax({
	        url: url,
	        type: 'POST',
	        dataType: 'json',
	        data: dados,
	        success: function(data) {
	        	console.log(data);
	        	if(data.status == false && data.dados == false){
	        		$("#msg").html("Não foi possível fazer o login.").addClass('alert-danger');
					$("#modalMsg").modal('show');
				}else if(data.status){
					setCookie('betalabsUserId', data.dados.id,diasCookie);
					setCookie('betalabsUserNome', data.dados.nome,diasCookie);
					setCookie('betalabsUserEmail', data.dados.email,diasCookie);
					setCookie('betalabsUserToken', data.dados.token,diasCookie);
					setCookie('betalabsUserFoto', data.dados.foto,diasCookie);
					$(".headerBemVindo h2").html(textoBenVindo+data.dados.nome);
					$(".noLogin").hide();
					$(".headerBemVindo").slideToggle(tempo);
					$(".formCometario form textarea, .formCometario form button[type='submit'] ").removeAttr('disabled');
					dadosUser.setUser();
				}
	        }
	    });

	    $("#mascara").click();
		return false;
	});

	$("#modalFormCadastrar form").submit(function(){
		url = $(this).attr('action');
		dados = $(this).serialize();
		$(this).each(function(){
		  this.reset();
		});
		$.ajax({
	        url: url,
	        type: 'POST',
	        dataType: 'json',
	        data: dados,
	        success: function(data) {
	        	console.log(data);
	        	if(data.status == false && data.email == true){
	        		$("#msg").html("email já exite no cadastro.").addClass('alert-danger');
	        		$("#modalFormCadastrar").modal('hide');
					$("#modalMsg").modal('show');
				}else if(data.status){
					$("#msg").html("Cadastro efetuado com successo.").addClass('alert-success');
					$("#modalFormCadastrar").modal('hide');
					$("#modalMsg").modal('show');
				}
	        }
	    });
		return false;
	});

	$("#formExcluirCometario form").submit(function(){
		url = $(this).attr('action');
		dados = $(this).serialize();
		$(this).each(function(){
		  this.reset();
		});
		$.ajax({
	        url: url,
	        type: 'POST',
	        dataType: 'json',
	        data: dados,
	        success: function(data) {
	        	console.log(data);
	        	if(data.status == false){
	        		$("#msg").html("Não foi possível excluir o comentário.").addClass('alert-danger');
					$("#modalMsg").modal('show');
				}else if(data.status){
					listarComentarios();
					$("#msg").html("Comentário excluido com sucesso.").addClass('alert-success');
					$("#modalMsg").modal('show');
				}
	        }
	    });
		return false;
	});

	$("#modalFormEditarComentario form").submit(function(){
		url = $(this).attr('action');
		dados = $(this).serialize();
		$(this).each(function(){
		  this.reset();
		});
		$.ajax({
	        url: url,
	        type: 'POST',
	        dataType: 'json',
	        data: dados,
	        success: function(data) {
	        	console.log(data);
	        	if(data.status == false){
	        		$("#msg").html("Não foi possível editar o comentário.").addClass('alert-danger');
	        		$("#modalFormEditarComentario").modal('hide');
					$("#modalMsg").modal('show');
				}else if(data.status){
					listarComentarios();
					$("#msg").html("Comentário editado com sucesso.").addClass('alert-success');
					$("#modalFormEditarComentario").modal('hide');
					$("#modalMsg").modal('show');
				}
	        }
	    });
		return false;
	});
	
	$(".formCometario form").submit(function(){
		url = $(this).attr('action');
		dados = $(this).serialize();
		$(this).each(function(){
		  this.reset();
		});
		$.ajax({
	        url: url,
	        type: 'POST',
	        dataType: 'json',
	        data: dados,
	        success: function(data) {
	        	console.log(data);
	        	if(data.status == false && data.email == true){
	        		$("#msg").html("Não foi possível inserir seu comentário.").addClass('alert-danger');
					$("#modalMsg").modal('show');
				}else if(data.status){
					//$("#msg").html("Comentário inserido com com successo.").addClass('alert-success');
					//$("#modalMsg").modal('show');
					listarComentarios();
				}
	        }
	    });
		return false;
	});

	$("#formEditarCadastro").submit(function(){
		url = $(this).attr('action');
		dados = $(this).serialize();
		$(this).each(function(){
		  this.reset();
		});
		$.ajax({
	        url: url,
	        type: 'POST',
	        dataType: 'json',
	        data: dados,
	        success: function(data) {
	        	console.log(data);
	        	if(data.status == false ){
	        		$("#msg").html("Não foi possível editar o cadastro.").addClass('alert-danger');
	        		$("#modalFormEditar").modal('hide');
					$("#modalMsg").modal('show');
				}else if(data.status){
					setCookie('betalabsUserNome', data.dados.nome,diasCookie);
					setCookie('betalabsUserEmail', data.dados.email,diasCookie);
					dadosUser.setUser();
					$("#msg").html("Alteração efetuada com successo.").addClass('alert-success');
					$("#modalFormEditar").modal('hide');
					$("#modalMsg").modal('show');
				}
	        }
	    });
		return false;
	});

});
