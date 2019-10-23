@extends('layouts.app')

@section('title')
    @include('partials.title.general', [
        'title' => __("Solicitar Permiso")
    ])
@endsection

@section('content')
<div class="container">
    <form action="{{ route('permits.store') }}" method="POST">
        <div class="row" style="margin-top:100px">
        @csrf
        <div class="col s5">
            <h5 class="center" style="margin-top:50px;">Fecha Inicio</h5>
              <div class="input-field">
                <input type="date" class="datepicker" name="fi" id="fip" required>
                <input type="hidden" name="fip" id="fipval">
              </div>
          </div>
          <div class="col s5">
               <h5 class="center" style="margin-top:50px;">Fecha Fin</h5>
               <div class="input-field">
                 <input type="date" class="datepicker" name="ff" id="ffp" required>
               </div>
          </div>
          <div class="col s2">
               <h5 class="center">Total días</h5>
               <h3 class="center card-panel light-blue darken-3 white-text" id="days"></h3>
               <input type="hidden" name="days" id="dval">
          </div>
       </div>
       <!--Validar si la fi es igual a la ff-->
       <div class="row">
            <div class="col s4" id="turno">
            </div>
           <div class="col s2">
             <input class="with-gap" name="require" type="radio" id="require4" value="1" required/>
               <label for="require4">Requiere suplente</label>

               <input class="with-gap" name="require" type="radio" id="require5" value="0" />
               <label for="require5">No requiere</label>
           </div>
           <div class="col s4">
               <div class="input-field">
                   <select name="reason">
                        <option value="" disabled selected>Seleccione un motivo</option>
                        @foreach ($reason as $r)
                                <option value="{{$r->id}}">{{$r->name}}</option>
                        @endforeach
                   </select>
                   <label>Motivo</label>
               </div>
           </div>
           <div class="col s2">
               <input class="with-gap" name="remunerate" type="radio" id="test6" value="1" required/>
               <label for="test6">Remunerado</label>
               <input class="with-gap" name="remunerate" type="radio" id="test7" value="0" />
               <label for="test7">No remunerado</label>
           </div>
       </div>
       <div class="row">
           <div class="input-field col s12">
               <input type="text" name="description" required>
               <label for="textarea1">Descripción</label>
           </div>
       </div>
       <br>
       <div class="row">
            <div class="col s12 center">
                <button class="btn btn-large blue darken-3" style="margin-top:80px" type="submit">Solicitar <i class="material-icons right">send</i></button>
             </div>
         </div>
</form>
</div>
</div>
@endsection
