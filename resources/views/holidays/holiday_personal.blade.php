@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Personal de Vacaciones")])
@endsection

@section('content')
<div class="container">
        <div class="row">
            <table class="highlight responsive-table centered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Cédula</th>
                            <th>Area</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th>Días Disfrutados</th>
                            <th>Días Restantes</th>
                            @if (auth()->user()->role_id == \App\Role::DIRECTOR_GENERAL || auth()->user()->role_id == \App\Role::DIRECTOR_LINEA || auth()->user()->role_id == \App\Role::SUPERADMIN)
                                <th>Acción</th>
                            @endif
                        </tr>
                    </thead>
                <tbody>
                    @forelse ($holidays as $key => $holiday)
                        <tr>
                            <td>{{ $holiday->applicant->person->name }}</td>
                            <td>{{ $holiday->applicant->person->card_id }}</td>
                            <td>{{ $holiday->applicant->area->name }}</td>
                            <td>{{$holiday->start_date}}</td>
                            <td>{{$holiday->end_date}}</td>
                            <td>{{$holiday->enjoyed_days}}</td>
                            <td>{{$holiday->leftover_days}}</td>
                            @if (auth()->user()->role_id == \App\Role::DIRECTOR_GENERAL || auth()->user()->role_id == \App\Role::DIRECTOR_LINEA || auth()->user()->role_id == \App\Role::SUPERADMIN)
                                <td>
                                    <a class="btn-floating btn-large waves-effect waves-light yellow darken-2 tooltipped hoverable" data-position="right" data-tooltip="Suspender" href="{{route('holidays.suspension',$holiday->id)}}"><i class="large material-icons">cancel</i></a>
                                </td>
                            @endif

                        </tr>
                    @empty
                        <tr>
                            <p>No existen datos</p>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
