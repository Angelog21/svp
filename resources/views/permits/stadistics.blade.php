@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Estadísticas de Permiso")])
@endsection

@section('content')
    <div class="container">
        @if (auth()->user()->role->id == \App\Role::SUPERADMIN)
            @include('partials.stadistics.form')
        @endif
        <div class="row">
            <h4 class="center">Solicitudes Anuales</h4>
            <div id="linechart" style="height:250px;"></div>
        </div>
            <br><br>
            <div class="row">
            <div class="col s6">
                <h4 class="center">Solicitudes diarias</h4>
                <div style="width:300px;height:300px;padding:50px;margin-left:100px" class="blue darken-3 z-depth-3">
                    <h1 class="white-text center" style="font-size:80px;">{{$daily}}</h1>
                </div>
            </div>
            <div class="col s6">
                <h4 class="center">Personal de permiso</h4>
                <div id="donutchart"></div>
            </div>
            <div class="col s12">
                <h4 class="center">Solicitudes mensuales</h4>
                <div id="barchart"></div>
            </div>
        </div>
    </div>
@endsection
