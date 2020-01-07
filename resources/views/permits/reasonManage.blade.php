@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Administrar Motivos")])
@endsection

@section('content')
<div class="container">
    @if (auth()->user()->role->id == App\Role::ANALISTA_PERMISOS)
        @include('partials.reason.form')
        <br><br>
        @if(isset($reasons))
            @include('partials.reason.dataEspecial',['reasons'=>$reasons])
        @else
            <p>No hay motivos</p>
        @endif
    @endif
</div>  
@endsection