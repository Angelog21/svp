@extends('layouts.app')

@section('title')
    @if (isset($title))
        @include('partials.title.general',['title'=>$title])
    @else
        @include('partials.title.general',['title'=> __("Estadísticas de Vacaciones")])
    @endif
@endsection

@section('content')
    <div class="container">
        @if (auth()->user()->role->id == \App\Role::SUPERADMIN)
            @include('partials.stadistics.form',['offices'=>$offices])
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
            @if (auth()->user()->role_id == \App\Role::SUPERADMIN && !isset($office))
                <div class="col s6">
                    <h4 class="center">Personal de vacaciones</h4>
                    <div id="donutchart"></div>
                </div>
            @else
                @if (isset($office))
                <div class="col s6">
                    <h4 class="center">Personal de Vacaciones</h4>
                    <div style="width:300px;height:300px;padding:50px;margin-left:100px" class="green darken-3 z-depth-3">
                        <h1 class="white-text center" style="font-size:80px;">{{$users[0]->users_count}}</h1>
                    </div>
                </div>
                @else
                <div class="col s6">
                    <h4 class="center">Personal de Vacaciones</h4>
                    <div style="width:300px;height:300px;padding:50px;margin-left:100px" class="green darken-3 z-depth-3">
                        <h1 class="white-text center" style="font-size:80px;">{{$users[0]->users_count}}</h1>
                    </div>
                </div>
                @endif
            @endif
            <div class="col s12">
                <h4 class="center">Solicitudes mensuales</h4>
                <div id="barchart"></div>
            </div>
            @if (!isset($office))
            <div class="row">
                <div class="col s5"></div>
                <a style="margin:100px 0px;" href="{{route('holidays.pdfGeneral')}}" class="center btn btn-large waves-effect waves-light red hoverable">Personal de Vacaciones <i class="material-icons">picture_as_pdf</i></a>
            </div>
            @else

            @endif
        </div>
    </div>
@endsection
