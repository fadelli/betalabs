@extends('layouts.main')

@section('content')

<div id="app">
	<nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">
                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (!Auth::guest())
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        Logout
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <div class="row">
            <table class="table table-striped">
                <thead>
                    <th>ID</th>
                    <th>Decriçao</th>
                    <th>ID Usuário</th>
                    <th>
                        <a class="btn btn-default" href="admin/excluir/todos/comentarios">
                            <i class="glyphicon glyphicon-remove"></i> Excluir todos
                        </a>
                    </th>
                </thead>
                <tbody>
                    @forelse ($comentarios as $comentario)
                    <tr>
                        <td>{{ $comentario->id }}</td>
                        <td>{{ $comentario->comentario }}</td>
                        <td>{{ $comentario->usuarios_id }}</td>
                        <td>
                            <a class="btn btn-default" href="admin/excluir/comentario/{{$comentario->id}}"><i class="glyphicon glyphicon-remove"></i> Excluir</a>
                        </td>
                    </tr>
                    @empty
                        <td colspan="4">Não temos nenhum comentário.</td>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

	
@endsection