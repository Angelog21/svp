@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Registros vacacionales")])
@endsection

@section('content')
        <div class="row">
            <table class="highlight responsive-table centered">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Cédula</th>
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
                    @forelse ($h as $holiday)
                        <tr>
                            <td>{{ $holiday->applicant->person->name }}</td>
                            <td>{{ $holiday->applicant->person->card_id }}</td>
                            <td>{{ $holiday->applicant->office->acronimo }}</td>
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
                                <a href="{{route('holidays.cpdf',encrypt($holiday->id))}}" class="btn-floating btn-large waves-effect waves-light red hoverable btn tooltipped" data-position="bottom" data-tooltip="Visualizar constancia"><i class="material-icons">picture_as_pdf</i></a>
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
@endsection
