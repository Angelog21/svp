<table class="striped">
    <thead>
        <tr>
            <th>#</th>
            <th>Fecha</th>
            <th>Descripcion</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($freedays as $key => $val)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{$val->date}}</td>
                <td>{{$val->description}}</td>
            </tr>
        @empty
            <p>No hay datos</p>
        @endforelse

    </tbody>
</table>
