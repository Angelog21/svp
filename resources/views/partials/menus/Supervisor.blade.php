<div class="carousel">
    @include('partials.menus.generalOptions')
    <div class="contenido hoverable carousel-item" id="cuatro">
        <a href="{{route('holidays.personal')}}"><i class="material-icons small white-text icono">people</i></a>
        <p class="texto">Personal en Vacaciones</p>
    </div>
    <div class="contenido hoverable carousel-item" id="cinco">
        <a href="{{route('holidays.getRequest')}}"><i class="material-icons small white-text icono">group_add</i></a>
        <p class="texto">Ver solicitudes</p>
    </div>
</div>
