<div class="row">
    <div class="col s2">
        <a class="btn btn-floating light-blue darken-3 pulse" style="margin-left:100px;margin-top:100px" href="{{ URL::previous() == route('holidays.calculate') ? route('home') : URL::previous() }}"><i class="material-icons">keyboard_return</i></a>
    </div>
    <div class="col s8">
        <h3 style="margin-top:50px; margin-left: 350px">{{$title}}</h3>
    </div>
    <div class="col s2">
        <small>
            Nombre: {{Auth::user()->person->name}}
            <br>
            @if (Auth::user()->last_login)
                Última Conexión: {{Auth::user()->last_login}}
            @endif
        </small>
    </div>
</div>
