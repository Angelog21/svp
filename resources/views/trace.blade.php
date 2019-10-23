@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Registro de actividades")])
@endsection

@section('content')
<div class="container">
    <div class="row">
        <table class="highlight responsive-table centered">
          <thead>
            <tr>
                <th>#</th>
                <th>Usuario</th>
                <th>Ultima conexión</th>
                <th>Tipo</th>
                <th>Descripción</th>
                <th>Fecha de Acción</th>
            </tr>
          </thead>
          <tbody>
              @forelse ($trace as $t => $v)
                <tr>
                    <td>{{$t+1}}</td>
                    <td>{{$v->user->username}}</td>
                    <td>{{$v->user->last_login}}</td>
                    <td>{{$v->type}}</td>
                    <td>{{$v->description}}</td>
                    <td>{{$v->created_at}}</td>
                </tr>
              @empty
                  <p>No hay registros</p>
              @endforelse
          </tbody>
        </table>
        {{ $trace->links()}}
    </div>
  </div>
@endsection