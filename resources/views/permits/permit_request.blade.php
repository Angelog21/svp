@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Mis Solicitudes")])
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
                                <form action="{{route('permits.action',$p->id)}}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    @if (auth()->user()->role->id == \App\Role::DIRECTOR_LINEA || auth()->user()->role->id == \App\Role::DIRECTOR_GENERAL)
                                        {{--<button class="btn-floating btn-large waves-effect waves-light red hoverable btn tooltipped" name="action" value="cancel" data-position="bottom" data-tooltip="Cancelar"><i class="material-icons">cancel</i></button>--}}
                                    @else
                                        <button class="btn-floating btn-large waves-effect waves-light green hoverable btn tooltipped" name="action" value="success" data-position="bottom" data-tooltip="Aprobar"><i class="material-icons">check</i></button>
                                        <button class="btn-floating btn-large waves-effect waves-light red hoverable btn tooltipped" name="action" value="cancel" data-position="bottom" data-tooltip="Cancelar"><i class="material-icons">cancel</i></button>
                                    @endif
                                    <input type="hidden" name="destination_id" value="{{ $p->applicant->id }}">
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
@endsection
