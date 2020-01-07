<div class="carousel">
    @include('partials.permitMenus.generalOptions')
    <div class="contenido hoverable carousel-item red darken-3">
        <a href="{{route('permits.revision')}}"><i class="material-icons small white-text icono">view_list</i></a>
        <p class="texto">Revisar solicitudes</p>
    </div>
    <div class="contenido hoverable carousel-item teal lighten-1">
        <a href="{{route('permits.checkRecord')}}"><i class="material-icons small white-text icono">playlist_add_check</i></a>
        <p class="texto">Revisar Historial</p>
    </div>
    <div class="contenido hoverable carousel-item brown darken-1">
        <a href="{{route('permits.reasonAdmin')}}"><i class="material-icons small white-text icono">check_box</i></a>
        <p class="texto">Administrar Motivos</p>
    </div>
    <div class="contenido hoverable carousel-item pink accent-4">
        <a href="{{route('permits.checkRefund')}}"><i class="material-icons small white-text icono">assignment_turned_in</i></a>
            <p class="texto">Confirmar Reintegro</p>
    </div>
</div>
