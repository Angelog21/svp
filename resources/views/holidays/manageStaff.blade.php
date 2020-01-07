@extends('layouts.app')

@section('title')
    @include('partials.title.general', [
        'title' => __("Administrar Personal")
    ])
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col s4"></div>
        <div class="input-field col s4">
            <i class="material-icons prefix">vpn_key</i>
            <input id="cedula" type="text" class="validate" required autocomplete="Cedula" onkeypress="validar(event)" autofocus>
            <label for="cedula">Cédula</label>
        </div>
        <div class="col s4" style="margin-top:30px;">
            <button id="buscar" onclick="search();" class="btn btn-floating pulse waves-effect waves-light btn-small light-blue darken-3 hoverable">
                <i class="material-icons right ">search</i>
            </button>
        </div>
    </div>
    <div class="data hide">
        {{--datos personales--}}
        <div class="row">
            <h4 class="center mt-4">
                Datos personales
            </h4>
            <div class="input-field col s6">
                Nombre:
                <input id="name" type="text" required autocomplete="Nombre" readonly>
            </div>
            <div class=" input-field col s6">
                Extensión:
                <input id="ext" type="text" required autocomplete="Extension" readonly>
            </div>
        </div>
        <div class="row">
            <div class="input-field col s6">
                Teléfono:
                <input id="phone" type="text" required autocomplete="Teléfono" readonly>
            </div>
            <div class=" input-field col s6">
                Fecha de Ingreso:
                <input id="date_admission" type="text" required autocomplete="date_admission" readonly>
            </div>
        </div>
        {{--datos periodos--}}
        {{--<div class="row">
            <h4 class="center mt-4">
                Períodos
            </h4>
            <div class="col s3"></div>
            <div class="input-field col s6">
                Cantidad:
                <select id="cant_period" onchange="period();">
                    <option selected disabled>Seleccione</option>
                    @for ($i = 1; $i < 11; $i++)
                        <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </div>
        </div>--}}
        <div class="row">
            <h4 class="center mt-4">
                Períodos
            </h4>
            <form action="{{route('holidays.periodStore')}}" method="post" id="cperiod">
                @csrf
                <input type="hidden" id="user_id" name="user_id">
                <input type="hidden" id="periods" name="periods">
                <div class="cp"></div>
                <div class="row">
                    <div class="col s5"></div>
                    <button type="submit" class="btn green darken-3 center hide" id="registrar" style="margin-top:40px">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
