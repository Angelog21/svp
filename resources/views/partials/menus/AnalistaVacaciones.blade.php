<div class="carousel">
    @include('partials.menus.generalOptions')
    <div class="contenido hoverable carousel-item" id="cinco">
    <a href="{{route('holidays.revision')}}"><i class="material-icons small white-text icono">view_list</i></a>
        <p class="texto">Revisar solicitudes</p>
    </div>
    <div class="contenido hoverable carousel-item green accent-4">
        <a href="{{route('holidays.checkRecord')}}"><i class="material-icons small white-text icono">playlist_add_check</i></a>
            <p class="texto">Revisar Historial</p>
    </div>
    <div class="contenido hoverable carousel-item pink accent-4">
        <a href="{{route('holidays.checkRefund')}}"><i class="material-icons small white-text icono">assignment_turned_in</i></a>
            <p class="texto">Confirmar Reintegro</p>
    </div>
    <div class="contenido hoverable carousel-item deep-purple accent-3">
        <a href="{{route('holidays.manageStaff')}}"><i class="material-icons small white-text icono">assignment_ind</i></a>
            <p class="texto">Administrar Personal</p>
    </div>
</div>
