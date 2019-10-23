<div class="carousel">
    @include('partials.permitMenus.generalOptions')
    <div class="contenido hoverable carousel-item" id="cua">
        <a href="{{route('permits.personal')}}"><i class="material-icons small white-text icono">people</i></a>
        <p class="texto">Personal de permiso</p>
    </div>
    <div class="contenido hoverable carousel-item" id="cin">
        <a href="{{route('permits.getRequest')}}"><i class="material-icons small white-text icono">group_add</i></a>
        <p class="texto">Ver solicitudes</p>
    </div>
    <div class="contenido hoverable carousel-item" id="cin">
        <a href="{{route('permits.stadistics')}}"><i class="material-icons small white-text icono">insert_chart</i></a>
        <p class="texto">Ver Estadisticas</p>
    </div>
</div>
