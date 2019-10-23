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
        <div class="input-field col s4 center">
            Cédula:
            <input id="name" type="text" required value="{{$user[0]->person->card_id}}" readonly>
            <input id="user_id" name="user_id" type="text" value="{{$user[0]->id}}">
        </div>
    </div>

    {{--cantidad vacaciones--}}
    <div class="row">
            <h4 class="center mt-4">
                Vacaciones
            </h4>
            <div class="col s3"></div>
            <div class="input-field col s6">
                Cantidad:
                <select id="cant_holiday" onchange="holiday();">
                    <option selected disabled>Seleccione</option>
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{$i}}">{{$i}}</option>
                    @endfor
                </select>
            </div>
        </div>
    <div class="data">
        {{--datos personales--}}
        <div class="row">
            <div class="input-field col s3">
                Nombre de Aprobador:
                <input id="name" type="text" required value="{{$approver[0]->person->name}}" readonly>
            </div>
            <div class=" input-field col s3">
                Extensión:
                <input id="ext" type="text" required autocomplete="Extension" readonly>
            </div>
            <div class="input-field col s3">
                    Nombre de Aprobador:
                    <input id="name" type="text" required value="{{$approver[0]->person->name}}" readonly>
                </div>
                <div class=" input-field col s3">
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
        <div class="row">
            <form action="{{route('holidays.periodStore')}}" method="post" id="cperiod">
                @csrf
                <input type="hidden" id="user_id" name="user_id">
                <input type="hidden" id="periods" name="periods">
                <div class="cp"></div>
                <div class="row">
                    <div class="col s5"></div>
                    <button type="submit" class="btn green darken-3 center hide" id="registrar">Registrar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
