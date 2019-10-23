<div class="col s4">
    <h5 class="center" style="margin-top:50px;">Flujo de solicitud</h5>
    <ul class="collection">
    <li class="collection-item avatar">
        <i class="material-icons circle blue">add</i>
        <span class="title">Director a aprobar</span>
        <p>{{ $approver }}</p>
    </li>
    <li class="collection-item avatar">
        <i class="material-icons circle yellow darken-2">history</i>
        <span class="title">Coordinador</span>
        <p>{{ $supervisor }}</p>
    </li>
    <li class="collection-item avatar">
        <i class="material-icons circle pink">highlight_off</i>
        <span class="title">Solicitante</span>
        <p>{{ auth()->user()->person->name }}</p>
    </li>
    </ul>
</div>
