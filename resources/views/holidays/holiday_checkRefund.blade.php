@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Confirmar Reintegro")])
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
                            <th>Oficina</th>
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
                    @forelse ($holidays as $holiday)
                        <tr>
                            <td>{{ $holiday->applicant->person->name }}</td>
                            <td>{{ $holiday->applicant->person->card_id }}</td>
                            <td>{{ $holiday->applicant->area->name }}</td>
                            <td>{{ $holiday->applicant->area->direction->office->acronimo }}</td>
                            <td>{{substr($holiday->created_at,0,-9)}}</td>
                            <td>{{$holiday->start_date}}</td>
                            <td>{{$holiday->end_date}}</td>
                            <td>{{$holiday->refund_date}}</td>
                            <td>
                                @foreach ($holiday->periods as $p)
                                    {{$p->period}}<br>
                                @endforeach
                            </td>
                            <td>{{$holiday->request_days}}</td>
                            <td>
                                <a href="{{route('holidays.editHoliday',$holiday->id)}}" class="btn-floating btn-large waves-effect waves-light green accent-3 hoverable btn tooltipped" data-position="bottom" data-tooltip="Confirmar Reintegro"><i class="material-icons">check_circle</i></a>
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
