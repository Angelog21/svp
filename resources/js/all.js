
  $("#imagen").backstretch([
    "../image/fondo10.jpg",
    "../image/fondo11.jpg",
    "../image/fondo12.jpg",
    "../image/fondo13.jpg"
], {duration: 4000, fade: 1000});

//carrusel
$(document).ready(function(){
  $('.carousel').carousel();
});

$('.datepicker').on('mousedown',function(e){
  e.preventDefault();
});

//pickadate vacaciones

$('#fi').pickadate({
    monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
    weekdaysShort: ['Dom','Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 1, // Creates a dropdown of 15 years to control year,
    min: 21,
    disable: [
        1,7
    ],
    today: 'Hoy',
    clear: 'Limpiar',
    close: 'Ok',
    closeOnSelect: true, // Close upon selecting a date
    formatSubmit: 'yyyy/mm/dd',
    onSet: function(){
        $('#ff').val("");
        $("#fival").val(this.get('select', 'yyyy-mm-dd'));
    }
});

$('#ff').pickadate({
    onOpen: function(){
    let fecha_texto = $("#fival").val();
    let ms = Date.parse(fecha_texto);
    let fecha = new Date(ms);
    fecha.setDate(fecha.getDate() + 22);
    this.set('min',fecha);
    },
    monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
    weekdaysShort: ['Dom','Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 1, // Creates a dropdown of 15 years to control year
    disable: [
    1,7
    ],
    today: 'Hoy',
    clear: 'Limpiar',
    close: 'Ok',
    closeOnSelect: true, // Close upon selecting a date
    formatSubmit: 'yyyy-mm-dd',
    hiddenName: true,
    onClose: function(){
        var date1 = new Date($('#fival').val());
        var date2 = new Date(this.get('select','yyyy-mm-dd'));
        var diffdays= date2.getTime()-date1.getTime();
        var days = Math.round(diffdays/(1000*60*60*24));
        var weekend = 0;

        while(date1 <= date2){
            if(date1.getDay() == 0 || date1.getDay() == 6){
                weekend++;
            }
            date1.setDate(date1.getDate() + 1);
        }
        days -= weekend;
        $('#d').text(days);
        $('#days').val(days);
    }
});

$('#fr').pickadate({
    monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
    weekdaysShort: ['Dom','Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 1, // Creates a dropdown of 15 years to control year,
    min: 1,
    disable: [
        1,7
    ],
    today: 'Hoy',
    clear: 'Limpiar',
    close: 'Ok',
    closeOnSelect: true, // Close upon selecting a date
    formatSubmit: 'yyyy/mm/dd',
    onSet: function(){
        $("#frval").val(this.get('select', 'yyyy-mm-dd'));
    }
});

    //fin pickadate vacaciones

$('#feriado').pickadate({
    monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
    weekdaysShort: ['Dom','Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 1, // Creates a dropdown of 15 years to control year,
    disable: [
        1,7
    ],
    today: 'Hoy',
    clear: 'Limpiar',
    close: 'Ok',
    closeOnSelect: true, // Close upon selecting a date
    formatSubmit: 'yyyy/mm/dd',
    hiddenName:true,
    onSet: function(){
        $("#fival").val(this.get('select', 'yyyy-mm-dd'));
    }
});

//pickadate permisos

$('#fip').pickadate({
    monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
    weekdaysShort: ['Dom','Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 1, // Creates a dropdown of 15 years to control year,
    min: new Date,
    disable: [
        1,7
    ],
    today: 'Hoy',
    clear: 'Limpiar',
    close: 'Ok',
    closeOnSelect: true, // Close upon selecting a date
    formatSubmit: 'yyyy-mm-dd',
    onSet: function(){
        $('#ffp').val("");
        $("#fipval").val(this.get('select', 'yyyy-mm-dd'));
    }
});

$('#ffp').pickadate({
    onOpen: function(){
        if($('#days').val() >= 1){
            $('#t').remove();
        }
        let fecha_texto = $("#fipval").val();
        let ms = Date.parse(fecha_texto);
        let fecha = new Date(ms);
        fecha.setDate(fecha.getDate()+1);
        this.set('min',fecha);
    },
    monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
    monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
    weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
    weekdaysShort: ['Dom','Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
    selectMonths: true, // Creates a dropdown to control month
    selectYears: 1, // Creates a dropdown of 15 years to control year
    disable: [
        1,7
    ],
    today: 'Hoy',
    clear: 'Limpiar',
    close: 'Ok',
    closeOnSelect: true, // Close upon selecting a date
    formatSubmit: 'yyyy-mm-dd',
    hiddenName: true,
    onClose: function(){
        let date1 = new Date($('#fipval').val());
        let date2 = new Date(this.get('select','yyyy-mm-dd'));
        let diffdays= date2.getTime()-date1.getTime();
        let days = Math.round(diffdays/(1000*60*60*24));
        $('#dval').val(days);
        $('#days').text(days);
        if(days == 0){
            $('#turno').append('<div id ="t"><input class="with-gap" name="turn" type="radio" id="turn1" value="m" required/> <label for="turn1">Mañana</label> <input class="with-gap" name="turn" type="radio" id="turn2" value="t" /><label for="turn2">Tarde</label></div>');
        }else{
            $('#t').remove();
        }
    }
});

$('.carousel-item').on('click',function(e){
    let ar = e.target.classList;
    if($(this).hasClass('active')){
        Materialize.toast('¡Debe hacer click en el ícono!', 2000, 'rounded');
    }
});

$('select').material_select();
$('#tooltiped').tooltip();
$('.tooltipped').tooltip();
