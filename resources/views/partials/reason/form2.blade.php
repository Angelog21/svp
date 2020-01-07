@extends('layouts.app')

@section('title')
@include('partials.title.general', [
    'title' => __("Editar Motivo")
])
@endsection

@section('content')
<div class="container">
    <div class="row">
        <form action="{{route('permits.updateReason',$reason->id)}}" method="POST">
            @csrf
            @method('PUT')
            <div class="col s3"></div>
            <div class="col s6">
            <h5 class="center" style="margin-top:50px;">Motivo</h5>
                <div class="input-field">
                <input type="text" name="name" value="{{ $reason->name }}">
                </div>
            </div>
            <div class="col s12 center">
                <h5 class="center" style="margin-top:50px;"></h5>
                <button class="btn waves-effect yellow darken-3 hoverable" type="submit" name="action">Actualizar<i class="material-icons right">send</i></button>
            </div>
        </form>
    </div>
</div>
@endsection
