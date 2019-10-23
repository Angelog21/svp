@extends('layouts.app')

@section('title')
    @include('partials.title.general', [
        'title' => __("Solicitar Vacaciones")
    ])
@endsection

@section('content')
<div class="container">

    <form action="{{ route('holidays.calculate') }}" method="POST">
        @csrf
        <div class="row" style="margin-top:100px">
            <div class="col s4">
                <h5 class="center" style="margin-top:50px;">Fecha Inicio</h5>
                <div class="input-field">
                    <input type="date" class="datepicker" name="fi" id="fi">
                    <input type="hidden" id="fival" name="fival">
                </div>
            </div>
            <div class="col s4">
                <h5 class="center" style="margin-top:50px;">Fecha Fin</h5>
                <div class="input-field">
                    <input type="date" class="datepicker" id="ff" name="ff">
                </div>
            </div>
            <div class="col s2">
                <h5 class="center">Días Disponibles</h5>
                <h3 class="center card-panel green accent-3 white-text">
                    {{$days}}
                </h3>
            </div>
            <div class="col s2">
                <h5 class="center">Días solicitados</h5>
                <h3 class="center card-panel cyan lighten-1 white-text" id="d"></h3>
                <input type="hidden" name="rd" id="days">
            </div>
        </div>
        <div class="row">
            <div class="col s12">
                <h5>Fecha de vencimiento del próximo período: <strong>{{$rdate}}</strong></h5>
            </div>
        </div>
        <div class="row">
            <div class="col s5"></div>
            <div class="col s4">
                <button class="btn btn-large blue darken-3" style="margin-top:80px" type="submit">Calcular</button>
            </div>
        </div>
</form>
</div>
</div>
@endsection
