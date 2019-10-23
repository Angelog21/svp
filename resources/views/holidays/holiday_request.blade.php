@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Mis Solicitudes")])
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
                            <th>Fecha solicitud</th>
                            <th>Fecha inicio</th>
                            <th>Fecha fin</th>
                            <th>Fecha reintegro</th>
                            <th>Periodo</th>
                            <th>Días Solicitados</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                <tbody>
                    @forelse ($holidays as $h)
                        <tr>
                            <td>{{ $h->applicant->person->name }}</td>
                            <td>{{ $h->applicant->person->card_id }}</td>
                            <td>{{ $h->applicant->area->name }}</td>
                            <td>{{substr($h->created_at,0,-9)}}</td>
                            <td>{{$h->start_date}}</td>
                            <td>{{$h->end_date}}</td>
                            <td>{{$h->refund_date}}</td>
                            <td>
                                @foreach ($h->periods as $p)
                                    {{$p->period}}<br>
                                @endforeach
                            </td>
                            <td>{{$h->request_days}}</td>
                            <td>
                                <form action="{{route('holidays.action',$h->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    @if (auth()->user()->role->id == \App\Role::DIRECTOR_LINEA || auth()->user()->role->id == \App\Role::DIRECTOR_GENERAL || auth()->user()->role->id == \App\Role::SUPERADMIN)
                                        <button class="btn-floating btn-large waves-effect waves-light green hoverable btn tooltipped" name="action" value="success" data-position="bottom" data-tooltip="Aprobar"><i class="material-icons">check</i></button>
                                        <button class="btn-floating btn-large waves-effect waves-light red hoverable btn tooltipped" name="action" value="cancel" data-position="bottom" data-tooltip="Cancelar"><i class="material-icons">cancel</i></button>
                                    @else
                                        <button class="btn-floating btn-large waves-effect waves-light red hoverable btn tooltipped" name="action" value="cancel" data-position="bottom" data-tooltip="Cancelar"><i class="material-icons">cancel</i></button>
                                    @endif
                                    <input type="hidden" name="destination_id" value="{{ $h->applicant->id }}">
                                </form>
                            </td>
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
