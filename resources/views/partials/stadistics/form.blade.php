<form action="{{route('holidays.stadisticsByOffice')}}" method="get">
    <div class="row">
      <div class="col s10">
            <div class="input-field">
                <select name="office_id">
                    <option value="0" selected>Todas</option>
                    @foreach ($offices as $o)
                        <option value="{{$o['id']}}">{{$o['acronimo']}}</option>
                    @endforeach
                </select>
                <label>Seleccione la Oficina</label>
            </div>
        </div>
        <div class="col s2">
            <button type="submit" class="btn btn-large light-blue darken-3 hoverable" id="tooltiped" data-position="right" data-tooltip="Consultar"><i class="material-icons">send</i></button>
        </div>
    </div>
</form>
