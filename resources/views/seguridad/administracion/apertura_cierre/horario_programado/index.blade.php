<div class="toolbar d-flex">
    <div class="col-lg-12 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistroGrande" app_reg_grande="{{ route('apertura_cierre_conf_ho.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
            Registrar
        </button>
    </div>
</div>

@csrf
<div class="table-responsive mb-4 mt-4" id="lista_horario_programado">
</div>

<script>
    Lista_Horario_Programado();

    function Lista_Horario_Programado(){
        Cargando();

        var url = "{{ route('apertura_cierre_conf_ho.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#lista_horario_programado').html(resp);  
            }
        });
    }

    function Activar_Dia(v,dia){
        if(!$('#ch_'+dia+v).is(":checked")){
            $("#hora_ingreso_"+dia+v).prop('disabled', true);
            $("#hora_apertura_"+dia+v).prop('disabled', true);
            $("#hora_cierre_"+dia+v).prop('disabled', true);
            $("#hora_salida_"+dia+v).prop('disabled', true);
        }else{
            $("#hora_ingreso_"+dia+v).prop('disabled', false);
            $("#hora_apertura_"+dia+v).prop('disabled', false);
            $("#hora_cierre_"+dia+v).prop('disabled', false);
            $("#hora_salida_"+dia+v).prop('disabled', false);
        }
        /*if(id==1){
            if(!$('#ch_lunes').is(":checked")){
                $("#hora_ingreso_l").prop('disabled', true);
                $("#hora_apertura_l").prop('disabled', true);
                $("#hora_cierre_l").prop('disabled', true);
                $("#hora_salida_l").prop('disabled', true);
                
            }else{
                $("#hora_ingreso_l").prop('disabled', false);
                $("#hora_apertura_l").prop('disabled', false);
                $("#hora_cierre_l").prop('disabled', false);
                $("#hora_salida_l").prop('disabled', false);
            }
        }else if(id==2){
            if(!$('#ch_martes').is(":checked")){
                $("#hora_ingreso_ma").prop('disabled', true);
                $("#hora_apertura_ma").prop('disabled', true);
                $("#hora_cierre_ma").prop('disabled', true);
                $("#hora_salida_ma").prop('disabled', true);
            }else{
                $("#hora_ingreso_ma").prop('disabled', false);
                $("#hora_apertura_ma").prop('disabled', false);
                $("#hora_cierre_ma").prop('disabled', false);
                $("#hora_salida_ma").prop('disabled', false);
            }
        }else if(id==3){
            if(!$('#ch_miercoles').is(":checked")){
                $("#hora_ingreso_mi").prop('disabled', true);
                $("#hora_apertura_mi").prop('disabled', true);
                $("#hora_cierre_mi").prop('disabled', true);
                $("#hora_salida_mi").prop('disabled', true);
            }else{
                $("#hora_ingreso_mi").prop('disabled', false);
                $("#hora_apertura_mi").prop('disabled', false);
                $("#hora_cierre_mi").prop('disabled', false);
                $("#hora_salida_mi").prop('disabled', false);
            }
        }else if(id==4){
            if(!$('#ch_jueves').is(":checked")){
                $("#hora_ingreso_ju").prop('disabled', true);
                $("#hora_apertura_ju").prop('disabled', true);
                $("#hora_cierre_ju").prop('disabled', true);
                $("#hora_salida_ju").prop('disabled', true);
            }else{
                $("#hora_ingreso_ju").prop('disabled', false);
                $("#hora_apertura_ju").prop('disabled', false);
                $("#hora_cierre_ju").prop('disabled', false);
                $("#hora_salida_ju").prop('disabled', false);
            }
        }else if(id==5){
            if(!$('#ch_viernes').is(":checked")){
                $("#hora_ingreso_v").prop('disabled', true);
                $("#hora_apertura_v").prop('disabled', true);
                $("#hora_cierre_v").prop('disabled', true);
                $("#hora_salida_v").prop('disabled', true);
            }else{
                $("#hora_ingreso_v").prop('disabled', false);
                $("#hora_apertura_v").prop('disabled', false);
                $("#hora_cierre_v").prop('disabled', false);
                $("#hora_salida_v").prop('disabled', false);
            }
        }else if(id==6){
            if(!$('#ch_sabado').is(":checked")){
                $("#hora_ingreso_s").prop('disabled', true);
                $("#hora_apertura_s").prop('disabled', true);
                $("#hora_cierre_s").prop('disabled', true);
                $("#hora_salida_s").prop('disabled', true);
            }else{
                $("#hora_ingreso_s").prop('disabled', false);
                $("#hora_apertura_s").prop('disabled', false);
                $("#hora_cierre_s").prop('disabled', false);
                $("#hora_salida_s").prop('disabled', false);
            }
        }else if(id==7){
            if(!$('#ch_domingo').is(":checked")){
                $("#hora_ingreso_d").prop('disabled', true);
                $("#hora_apertura_d").prop('disabled', true);
                $("#hora_cierre_d").prop('disabled', true);
                $("#hora_salida_d").prop('disabled', true);
            }else{
                $("#hora_ingreso_d").prop('disabled', false);
                $("#hora_apertura_d").prop('disabled', false);
                $("#hora_cierre_d").prop('disabled', false);
                $("#hora_salida_d").prop('disabled', false);
            }
        }*/

    }

    function Delete_Horario_Programado(id) {
        Cargando();

        var url = "{{ route('apertura_cierre_conf_ho.destroy', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Horario_Programado();
                        });    
                    }
                });
            }
        })
    }
</script>