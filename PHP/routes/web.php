<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');
Route::get('/listar/comentarios', 'HomeController@getComentarios');
Route::get('/dados/comentario/{id}', 'HomeController@getComentarioId');

Route::post('/auth/login', 'HomeController@auth');

Route::post('/cadastrar/usuario', 'HomeController@cadastrarUsuario');

Route::post('/editar/usuario', 'HomeController@editarUsuario');

Route::post('/exibir/usuario', 'HomeController@getUsuario');

Route::post('/cadastrar/comentario', 'HomeController@cadastrarComentario');


Route::post('/cadastrar/usuario/foto', 'HomeController@setFotoUsuario');

Route::post('/excluir/comentario', 'HomeController@excluirComentario');

Route::post('/editar/comentario', 'HomeController@editarComentario');


//route do admin

Route::group(['prefix' => 'admin','namespace' => 'Admin', 'middleware' => 'auth'], function () {
	// Controllers Within The "App\Http\Controllers\Admin" Namespace
	Route::get('/', 'HomeController@index');
	
});


