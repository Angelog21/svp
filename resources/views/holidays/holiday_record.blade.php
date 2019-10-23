@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Mi historial")])
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <table class="highlight responsive-table centered">
                <thead>
                    <tr>
                        <th>Fecha solicitud</th>
                        <th>Fecha inicio</th>
                        <th>Fecha fin</th>
                        <th>Fecha reintegro</th>
                        <th>Periodo</th>
                        <th>Días solicitados</th>
                        <th>Días disfrutados</th>
                        <th>Días restantes</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($holidays as $holiday)
                        <tr>
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
                            <td>{{$holiday->enjoyed_days}}</td>
                            <td>{{$holiday->leftover_days}}</td>
                            <td>{{$holiday->state}}</td>
                            @if ($holiday->state == App\Holiday::FIRMADO || $holiday->state == App\Holiday::COMPLETO)
                            <td><a href="{{route('holidays.cpdf',encrypt($holiday->id))}}" class="btn-floating btn-large waves-effect waves-light red hoverable"><i class="material-icons">picture_as_pdf</i></a></td>
                            @else
                            <td><button class="btn-floating btn-large waves-effect waves-light red hoverable" disabled><i class="material-icons">picture_as_pdf</i></button></td>
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
