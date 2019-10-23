@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Estatus de proceso")])
@endsection

@section('content')
    <div class="container">
        @foreach ($permit as $p)
        <div class="row">
            <br>
            <ul class="collapsible popout">
                <li>
                    <div class="collapsible-header"><i class="material-icons">fingerprint</i>Datos</div>
                    <div class="collapsible-body">
                      <span>
                        <p>Nombre: {{auth()->user()->person->name}}</p>
                        <p>Cédula: {{auth()->user()->person->card_id}}</p>
                        <p>Oficina: {{auth()->user()->office->acronimo}}</p>
                        <p>Direccion: {{auth()->user()->direction->name}}</p>
                        <p>Área: {{auth()->user()->area->name}}</p>
                      </span>
                  </div>
                  </li>
                  <li>
                    <div class="collapsible-header"><i class="material-icons">fingerprint</i>Aprobador</div>
                    <div class="collapsible-body">
                      <span>
                        <p>Nombre: {{$p->supervisor->person->name}}</p>
                        <p>Oficina: {{auth()->user()->office->acronimo}}</p>
                        <p>Direccion: {{auth()->user()->direction->name}}</p>
                        <p>Área: {{auth()->user()->area->name}}</p>
                      </span>
                  </div>
                  </li>

                  <li>
                    <div class="collapsible-header"><i class="material-icons">date_range</i>Fechas</div>
                    <div class="collapsible-body">
                        <span>
                            <p>Fecha Solicitud: {{$p->created_at}} </p>
                            <p>Fecha Inicio: {{$p->start_date}}</p>
                            <p>Fecha Fin: {{$p->end_date}}</p>
                            <p>Fecha Reintegro: {{$p->refund_date}}</p>
                        </span>
                    </div>
                  </li>

                  <li>
                    <div class="collapsible-header"><i class="material-icons">view_headline</i>Días</div>
                    <div class="collapsible-body">
                      <span>
                        <p>Solicitados: {{$p->days}}</p>
                      </span>
                      @if (isset($turn))
                          Turno: {{$turn}}
                      @endif
                  </div>
                  </li>

                  <li>
                    <div class="collapsible-header"><i class="material-icons">sync</i>Estado</div>
                    <div class="collapsible-body">
                        <span>
                            @if($p->state == App\Permit::PROCESO)
                                @include('partials.status.proceso')
                            @endif
                            @if($p->state == App\Permit::APROBADO)
                                @include('partials.status.aprobado')
                            @endif
                            @if($p->state == App\Permit::RECHAZADO)
                                @include('partials.status.rechazado')
                            @endif
                        </span>
                    </div>
                  </li>

                </ul>
          </div>
          @endforeach
    </div>
@endsection
