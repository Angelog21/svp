<div class="carousel">
    @include('partials.menus.generalOptions')
    <div class="contenido hoverable carousel-item" id="cinco">
        <a href="solicitudes.html"><i class="material-icons small white-text icono">group_add</i></a>
        <p class="texto">Ver solicitudes</p>
    </div>
    <div class="contenido hoverable carousel-item" id="seis">
        <a href="{{route('holidays.feriados')}}"><i class="material-icons small white-text icono">date_range</i></a>
      <p class="texto">Fechas Feriados</p>
    </div>
</div>
