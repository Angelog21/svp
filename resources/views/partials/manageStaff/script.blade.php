<script>
    function search(){
        let cedula = $('#cedula').val();
        if(cedula != ''){
            let url = "{{route('holidays.search')}}"+'/'+cedula;
            //para validar que se ejecuta una sola vez la funcion
            $.get(url, function(result){
                console.log(result);
                if(result.length > 0){
                    if($('#periods').val() == ''){
                        $('.data').removeClass('hide');
                        $('#name').val(result[0][0].name);
                        $('#ext').val(result[0][0].extension);
                        $('#phone').val(result[0][0].phone);
                        $('#date_admission').val(result[0][0].date_admission);
                        $('#user_id').val(result[0][0].user.id);
                        //datos de los periodos
                        let i = 1;
                        for(const date in result[1]){
                            if(i%2 == 0){
                                $('.cp').append('<div class="col s2 mt-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Insertar:<div class="switch">#'+i+'&nbsp;&nbsp;&nbsp;&nbsp;<label>No<input type="checkbox" name="'+date+'" checked="checked"><span class="lever"></span>Si</label></div></div><div class="input-field col s4 lighten-2"> Período:<input name="period'+i+'" type="text" value="'+date+'" readonly></div><div class="input-field col s4 lighten-2">Fecha de Vencimiento:<input type="text" name="expiration_date'+i+'" value="'+result[1][date]+'" readonly></div><div class="input-field col s2 lighten-2">Días disponibles:<input type="text" name="available_days'+i+'" value="0"></div>');
                            }else{
                                $('.cp').append('<div class="col s2 mt-4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Insertar:<div class="switch">#'+i+' &nbsp;&nbsp;&nbsp;&nbsp;<label>No<input type="checkbox" name="'+date+'" checked="checked"><span class="lever"></span>Si</label></div></div><div class="input-field col s4"> Período:<input name="period'+i+'" type="text" value="'+date+'" readonly></div><div class="input-field col s4">Fecha de Vencimiento:<input type="text" name="expiration_date'+i+'" value="'+result[1][date]+'" readonly></div><div class="input-field col s2">Días disponibles:<input type="text" name="available_days'+i+'" value="0"></div>');
                            }
                            i++;
                        }
                        $("#periods").val(--i);
                        $('#registrar').removeClass('hide');
                    }else{
                        alert('Ya se realizó la busqueda')
                    }
                }else{
                    alert('No existe esa cedula en nuestros registros');
                }
            });
        }else{
            alert('Debe ingresar una cédula');
        }
    }

    function validar(e){
        tecla = (document.all) ? e.keyCode : e.which;
        if (tecla==13) search();
    }
</script>
