<script>
    function holiday(){
        let holiday = parseInt($('#cant_holiday').val());
        $('#holidays').val(holiday);
        $('.ch').empty();

        for(var i = 0; i < holiday; i++){
            if(i%2 == 0){
                $('.ch').append('<div class="blue lighten-3 mt-4" style="padding: 10px 80px;border-radius:10px"><div class="row"><div class="input-field col s3">Nombre de Aprobador:<input id="name" type="text" required value="{{$approver[0]->person->name}}" readonly><input type="hidden" name="approver_id" value="{{$approver[0]->id}}"></div><div class=" input-field col s3">Fecha de Inicio:<input id="sd'+(i+1)+'" type="text" name="sd'+(i+1)+'" required class="data"><input id="sdval'+(i+1)+'" type="hidden" name="sdval'+(i+1)+'"></div><div class="input-field col s3">Fecha Fin:<input id="ed'+(i+1)+'" name="ed'+(i+1)+'" type="text" required class="data"></div><div class=" input-field col s3">Fecha Reintegro:<input id="rd'+(i+1)+'" name="rd'+(i+1)+'" type="text" required class="data"></div></div><div class="row"><div class="input-field col s6">Períodos:<select name="periods'+(i+1)+'[]" id="periods'+(i+1)+'" multiple><option disabled selected>Seleccione uno o varios</option>@foreach ($periods as $p)<option value="{{$p->id}}">{{$p->period}}</option>@endforeach</select></div><div class=" input-field col s6">Observación:<input id="date_admission" name="observation" type="text" autocomplete="date_admission"></div></div></div>');
            }else{
                $('.ch').append('<div class="light-green accent-1 mt-4" style="padding: 10px 80px;border-radius:10px"><div class="row"><div class="input-field col s3">Nombre de Aprobador:<input id="name" type="text" required value="{{$approver[0]->person->name}}" readonly><input type="hidden" name="approver_id" value="{{$approver[0]->id}}"></div><div class=" input-field col s3">Fecha de Inicio:<input id="sd'+(i+1)+'" type="text" name="sd'+(i+1)+'" required class="data"><input id="sdval'+(i+1)+'" type="hidden" name="sdval'+(i+1)+'"></div><div class="input-field col s3">Fecha Fin:<input id="ed'+(i+1)+'" name="ed'+(i+1)+'" type="text" required class="data"></div><div class=" input-field col s3">Fecha Reintegro:<input id="rd'+(i+1)+'" name="rd'+(i+1)+'" type="text" required class="data"></div></div><div class="row"><div class="input-field col s6">Períodos:<select name="periods'+(i+1)+'[]" id="periods'+(i+1)+'" multiple><option disabled selected>Seleccione uno o varios</option></select></div><div class=" input-field col s6">Observación:<input id="date_admission" name="observation" type="text"autocomplete="date_admission"></div></div></div>');
                @foreach ($periods as $p)
                    $('#periods'+(i+1)).append('<option value="{{$p->id}}">{{$p->period}}</option>')
                @endforeach
            }

            $('#periods'+(i+1)).on('contentChanged',function(){
                $(this).material_select();
            });

            $('#periods'+(i+1)).trigger('contentChanged');

            $('#sd'+(i+1)).pickadate({
                monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                weekdaysShort: ['Dom','Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                max: true,
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 70, // Creates a dropdown of 15 years to control year
                today: 'Hoy',
                clear: 'Limpiar',
                close: 'Ok',
                closeOnSelect: true, // Close upon selecting a date
                formatSubmit: 'yyyy-mm-dd',
                hiddenName: true,
                onSet: function(){
                    $('#ed'+(i)).val("");
                    $("#sdval"+i).val(this.get('select', 'yyyy-mm-dd'));
                }
            });
            $('#ed'+(i+1)).pickadate({
                monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                weekdaysShort: ['Dom','Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                max: true,
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 70, // Creates a dropdown of 15 years to control year
                today: 'Hoy',
                clear: 'Limpiar',
                close: 'Ok',
                closeOnSelect: true, // Close upon selecting a date
                formatSubmit: 'yyyy-mm-dd',
                hiddenName: true
            });
            $('#rd'+(i+1)).pickadate({
                monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                weekdaysShort: ['Dom','Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                max: true,
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 70, // Creates a dropdown of 15 years to control year
                today: 'Hoy',
                clear: 'Limpiar',
                close: 'Ok',
                closeOnSelect: true, // Close upon selecting a date
                formatSubmit: 'yyyy-mm-dd',
                hiddenName: true
            });
            $('#sd'+(i+1)).on('mousedown',function(e){
                e.preventDefault();
            });
            $('#ed'+(i+1)).on('mousedown',function(e){
                e.preventDefault();
            });
            $('#rd'+(i+1)).on('mousedown',function(e){
                e.preventDefault();
            });
        }
        $('#registrar').removeClass('hide');
    }
</script>
