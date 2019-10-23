<div class="row">
    <form action="{{ route('holidays.createFreeDay')}}" method="POST">
        @csrf
        <div class="col s6">
        <h5 class="center" style="margin-top:50px;">Fecha Feriado</h5>
            <div class="input-field">
                <input type="date" class="datepicker" name="fi" id="feriado" required>
            </div>
        </div>
        <div class="col s6">
        <h5 class="center" style="margin-top:50px;">Descripcion</h5>
            <div class="input-field">
            <input type="text" name="description" required>
            </div>
        </div>
        <div class="col s12 center">
            <h5 class="center" style="margin-top:50px;"></h5>
            <button class="btn waves-effect light-blue darken-3 hoverable" type="submit" name="action">Guardar<i class="material-icons right">send</i></button>
        </div>
    </form>
</div>

