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
                        <th>Motivo</th>
                        <th>Días</th>
                        <th>Turno</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($permits as $permit)
                        <tr>
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
                            @if ($permit->state == App\Permit::COMPLETO)
                            <td><a href="{{route('permits.cpdf',encrypt($permit->id))}}" class="btn-floating btn-large waves-effect waves-light red hoverable"><i class="material-icons">picture_as_pdf</i></a></td>
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
