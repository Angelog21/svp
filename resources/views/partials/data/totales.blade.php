<div class="col s4">
    <h5 class="center" style="margin-top:50px;">Totales</h5>
    <ul class="collection">
    <li class="collection-item avatar">
        <i class="material-icons circle orange">add</i>
        <span class="title">Períodos a Consumir</span>
        @if ($periods)
            @forelse ($periods as $p)
                <p>{{ $p->period }}</p>
            @empty
                <p>2019-2020</p>
            @endforelse
        @else
            <p>2019-2020</p>
        @endif
        @if (isset($especial))
            <p>2019-2020</p>
        @endif
    </li>
    <li class="collection-item avatar">
        <i class="material-icons circle">history</i>
        <span class="title">Días disponibles</span>
        <p>{{ $available_days }}</p>

    </li>
    <li class="collection-item avatar">
        <i class="material-icons circle green">insert_chart</i>
        <span class="title">Solicitados</span>
        <p>{{ $request_days }}</p>
    </li>
    <li class="collection-item avatar">
        <i class="material-icons circle red">highlight_off</i>
        <span class="title">Diferidos</span>
        <p>{{ $restant }}</p>
    </li>
    <li class="collection-item avatar">
            <i class="material-icons circle pink">done</i>
            <span class="title">Dias feriados</span>
            <p>{{ $freedays }}</p>
    </li>
    </ul>
</div>
