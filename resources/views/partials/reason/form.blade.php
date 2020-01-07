<div class="row">
    <form action="{{ route('permits.createReason')}}" method="POST">
        @csrf
        <div class="col s3"></div>
        <div class="col s6">
        <h5 class="center" style="margin-top:50px;">Motivo</h5>
            <div class="input-field">
                <input type="text" name="name" required>
            </div>
        </div>
        <div class="col s12 center">
            <h5 class="center" style="margin-top:50px;"></h5>
            <button class="btn waves-effect light-blue darken-3 hoverable" type="submit" name="action">Insertar<i class="material-icons right">send</i></button>
        </div>
    </form>
</div>

