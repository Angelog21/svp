<div class="carousel"> 
    @include('partials.permitMenus.generalOptions')
    <div class="contenido hoverable carousel-item" id="cinco">
        <a href="{{route('permits.revision')}}"><i class="material-icons small white-text icono">view_list</i></a>
            <p class="texto">Revisar solicitudes</p>
        </div>
        <div class="contenido hoverable carousel-item" id="uno">
            <a href="{{route('permits.checkRecord')}}"><i class="material-icons small white-text icono">playlist_add_check</i></a>
                <p class="texto">Revisar Historial</p>
        </div>
</div>