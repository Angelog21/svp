<div class="col s3">
    <h5 class="center" style="margin-top:50px;">Información</h5>
    <ul class="collection">
        <li class="collection-item avatar">
            <i class="material-icons circle orange">add</i>
            <span class="title">Nombre</span>
            <p>{{$h->applicant->person->name}}</p>
        </li>
        <li class="collection-item avatar">
            <i class="material-icons circle">folder</i>
            <span class="title">Cédula</span>
            <p>{{$h->applicant->person->card_id}}</p>
        </li>
        <li class="collection-item avatar">
            <i class="material-icons circle green">insert_chart</i>
            <span class="title">Disfrutados</span>
            <p>{{$enjoyed}} Días</p>
        </li>
        <li class="collection-item avatar">
            <i class="material-icons circle red">play_arrow</i>
            <span class="title">Restantes</span>
            <p>{{$remaining}} Días</p>
        </li>

    </ul>
</div>
