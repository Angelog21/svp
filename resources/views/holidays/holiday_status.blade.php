@extends('layouts.app')

@section('title')
    @include('partials.title.general',['title'=> __("Estatus de proceso")])
@endsection

@section('content')
    <div class="container">
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
                  @foreach ($holiday as $h)
                  <li>
                    <div class="collapsible-header"><i class="material-icons">date_range</i>Fechas</div>
                    <div class="collapsible-body">
                        <span>

                                <p>Fecha Solicitud: {{$h->created_at}} </p>
                                <p>Fecha Inicio: {{$h->start_date}}</p>
                                <p>Fecha Fin: {{$h->end_date}}</p>
                                <p>Fecha Reintegro: {{$h->refund_date}}</p>
                                <p>Período:
                                  @foreach ($h->periods as $p)
                                    <br>{{$p->period}}
                                  @endforeach
                                </p>

                        </span>
                    </div>
                  </li>

                  <li>
                    <div class="collapsible-header"><i class="material-icons">view_headline</i>Días</div>
                    <div class="collapsible-body">
                      <span>
                        <p>Solicitados: {{$h->request_days}}</p>
                        <p>Disfrutados: {{$h->enjoyed_days}}</p>
                        <p>Restantes: {{$h->leftover_days}}</p>
                      </span>
                  </div>
                  </li>
                  @endforeach
                  <li>
                    <div class="collapsible-header"><i class="material-icons">sync</i>Estado</div>
                    <div class="collapsible-body">
                        <span>
                            @if($holiday[0]->state == App\Holiday::PROCESO)
                                @include('partials.status.proceso')
                            @endif
                            @if($holiday[0]->state == App\Holiday::APROBADO)
                                @include('partials.status.aprobado')
                            @endif
                            @if($holiday[0]->state == App\Holiday::RECHAZADO)
                                @include('partials.status.rechazado')
                            @endif
                        </span>
                    </div>
                  </li>

                </ul>
          </div>
    </div>
@endsection
