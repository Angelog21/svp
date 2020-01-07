<table class="striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Motivo</th>
            <th>Acción</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($reasons as $key => $val)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$val->name}}</td>
                <td>
                    <a href="{{route('permits.editReason',$val->id)}}" class="btn-floating btn-large waves-effect waves-light yellow darken-3 hoverable btn tooltipped" data-position="bottom" data-tooltip="Editar" value="Editar"><i class="material-icons">edit</i></a>
                    <a href="{{route('permits.deleteReason',$val->id)}}" class="btn-floating btn-large waves-effect waves-light red hoverable btn tooltipped" data-position="right" data-tooltip="Eliminar" value="Eliminar"><i class="material-icons">delete</i></a>
                </td>
            </tr>
        @empty
            <p>No hay datos</p>
        @endforelse

    </tbody>
</table>
