<div class="toolbar d-flex">
    <div class="col-lg-12 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistroGrande" app_reg_grande="{{ route('apertura_cierre_conf_ho.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
            Registrar
        </button>
    </div>
</div>

<div class="table-responsive mb-4 mt-4" id="lista_horario_programado">
</div>

<script>
    Lista_Horario_Programado();

    function solo_Numeros(e) {
        var key = event.which || event.keyCode;
        if (key >= 48 && key <= 57) {
            return true;
        } else {
            return false;
        }
    }

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

    function Activar_Dia(v){
        if(!$('#ch_'+v).is(":checked")){
            $("#hora_ingreso_"+v).prop('disabled', true);
            $("#hora_ingreso_"+v).val('');
            $("#hora_apertura_"+v).prop('disabled', true);
            $("#hora_apertura_"+v).val('');
            $("#hora_cierre_"+v).prop('disabled', true);
            $("#hora_cierre_"+v).val('');
            $("#hora_salida_"+v).prop('disabled', true);
            $("#hora_salida_"+v).val('');
        }else{
            $("#hora_ingreso_"+v).prop('disabled', false);
            $("#hora_apertura_"+v).prop('disabled', false);
            $("#hora_cierre_"+v).prop('disabled', false);
            $("#hora_salida_"+v).prop('disabled', false);
        }
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
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
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