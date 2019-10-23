<script>
    function search(){
        let cedula = $('#cedula').val();
        if(cedula != ''){
            let url = "{{route('holidays.search')}}"+'/'+cedula;

            $.get(url, function(result){
                if(result.length > 0){
                    $('.data').removeClass('hide');
                    $('#name').val(result[0].name);
                    $('#ext').val(result[0].extension);
                    $('#phone').val(result[0].phone);
                    $('#date_admission').val(result[0].date_admission);
                    $('#user_id').val(result[0].id);
                }else{
                    alert('No existe esa cedula en nuestros registros');
                }
            });
        }else{
            alert('Debe ingresar una cédula');
        }
    }
    function period(){
        let period = parseInt($('#cant_period').val());
        $('#periods').val(period);
        $('.cp').empty();
        for(var i = 0; i < period; i++){
            $('.cp').append('<div class="input-field col s6">Período:<input id="period" name="period'+(i+1)+'" type="text" required autocomplete="Período"></div><div class=" input-field col s6">Fecha de Vencimiento:<input type="date" class="datepicker" id="e'+(i+1)+'" name="expiration_date'+(i+1)+'" required autocomplete="Fecha Vencimiento"></div>');
            $('#e'+(i+1)).pickadate({
                monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                weekdaysShort: ['Dom','Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                max: true,
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 25, // Creates a dropdown of 15 years to control year
                today: 'Hoy',
                clear: 'Limpiar',
                close: 'Ok',
                closeOnSelect: true, // Close upon selecting a date
                formatSubmit: 'yyyy-mm-dd',
                hiddenName: true
            });
        }
        $('#registrar').removeClass('hide');
    }

    function holiday(){
        let holiday = parseInt($('#cant_holiday').val());
        $('#holidays').val(holiday);
        $('.cp').empty();
        /*
        for(var i = 0; i < holiday; i++){
            $('.cp').append('<div class="input-field col s6">Período:<input id="holiday" name="holiday'+(i+1)+'" type="text" required autocomplete="Vacacion"></div><div class=" input-field col s6">Fecha de Vencimiento:<input type="date" class="datepicker" id="e'+(i+1)+'" name="expiration_date'+(i+1)+'" required autocomplete="Fecha Vencimiento"></div>');
            $('#e'+(i+1)).pickadate({
                monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
                weekdaysShort: ['Dom','Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                max: true,
                selectMonths: true, // Creates a dropdown to control month
                selectYears: 25, // Creates a dropdown of 15 years to control year
                today: 'Hoy',
                clear: 'Limpiar',
                close: 'Ok',
                closeOnSelect: true, // Close upon selecting a date
                formatSubmit: 'yyyy-mm-dd',
                hiddenName: true
            });
        }*/
        $('#registrar').removeClass('hide');
    }
</script>
