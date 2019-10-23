@extends('layouts.app')

@section('title')
@include('partials.title.general', [
    'title' => __("Editar Día Feriado")
])
@endsection

@section('content')
<div class="container">
<div class="row">
    <form action="{{route('holidays.updateFreeDay',$freeday->id)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="col s6">
        <h5 class="center" style="margin-top:50px;">Fecha Feriado</h5>
            <div class="input-field">
                <input type="date" class="datepicker" name="fi" id="fi" value="{{ $freeday->date }}">
                <input type="hidden" name="fival" id="fival">
            </div>
        </div>
        <div class="col s6">
        <h5 class="center" style="margin-top:50px;">Descripcion</h5>
            <div class="input-field">
            <input type="text" name="description" value="{{ $freeday->description }}">
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
