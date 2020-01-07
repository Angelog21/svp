@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Revision de Solicitudes")])
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
                        <th>Motivo</th>
                        <th>Descripcion</th>
                        <th>Turno</th>
                        <th>Acción</th>
                    </tr>
                </thead>
            <tbody>
                @forelse ($permits as $p)
                    <tr>
                        <td>{{ $p->applicant->person->name }}</td>
                        <td>{{ $p->applicant->person->card_id }}</td>
                        <td>{{ $p->applicant->office->name }}</td>
                        <td>{{substr($p->created_at,0,-9)}}</td>
                        <td>{{$p->start_date}}</td>
                        <td>{{$p->end_date}}</td>
                        <td>{{$p->refund_date}}</td>
                        <td>{{$p->reason->name}}</td>
                        <td>{{$p->description}}</td>
                        @if (isset($turno))
                            <td>{{$turno}}</td>
                        @else
                            <td>-</td>
                        @endif
                            <td>
                                <a href="{{route('permits.editUser',$p->applicant_id)}}" class="btn-floating btn-large waves-effect waves-light amber darken-3 hoverable btn tooltipped" data-position="bottom" data-tooltip="Cambiar estado de usuario"><i class="material-icons">control_point</i></a>
                                <a href="{{route('permits.cpdf',encrypt($p->id))}}" class="btn-floating btn-large waves-effect waves-light red hoverable btn tooltipped" data-position="bottom" data-tooltip="Visualizar constancia"><i class="material-icons">picture_as_pdf</i></a>
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
