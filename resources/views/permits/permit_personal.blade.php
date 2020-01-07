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
                        <th>Fecha solicitud</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Fecha reintegro</th>
                        <th>Motivo</th>
                        <th>Días</th>
                        <th>Turno</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($permits as $permit)
                        <tr>
                            <td>{{$permit->applicant->person->name}}</td>
                            <td>{{$permit->applicant->person->card_id}}</td>
                            <td>{{substr($permit->created_at,0,-9)}}</td>
                            <td>{{$permit->start_date}}</td>
                            <td>{{$permit->end_date}}</td>
                            <td>{{$permit->refund_date}}</td>
                            <td>{{$permit->reason->name}}</td>
                            <td>{{$permit->days}}</td>
                            @if (isset($permit->turn))
                                <td>{{$permit->turn}}</td>
                            @else
                            <td>-</td>
                            @endif
                            <td>{{$permit->description}}</td>
                            <td>{{$permit->state}}</td>

                        </tr>
                    @empty
                        <tr>
                            <p>No hay personal de permiso</p>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
