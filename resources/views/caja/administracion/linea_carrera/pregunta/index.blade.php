<div class="toolbar d-flex">
    <div class="col-lg-12 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('linea_carrera_conf_pre.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
            Registrar
        </button>
    </div>
</div>

@csrf
<div class="table-responsive mb-4 mt-4" id="lista_pregunta">
</div>

<script>
    Lista_Pregunta();

    function Lista_Pregunta(){
        Cargando();

        var url = "{{ route('linea_carrera_conf_pre.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#lista_pregunta').html(resp);  
            }
        });
    }

    function Tipo(v){
        Cargando();

        var id_tipo = $('#id_tipo').val();

        if(id_tipo=="1"){
            $('#tipo_abierta'+v).show();
            $('.tipo_opcion_multiple'+v).hide();
            $('#descripcion'+v).val('');
            $('#opcion_1'+v).val('');
            $('#opcion_2'+v).val('');
            $('#opcion_3'+v).val('');
            $('#opcion_4'+v).val('');
            $('#opcion_5'+v).val('');
            $("input:radio").attr("checked", false);
        }else if(id_tipo=="2"){
            $('#tipo_abierta'+v).show();
            $('.tipo_opcion_multiple'+v).show();
            $('#descripcion'+v).val('');
        }else{
            $('#tipo_abierta'+v).hide();
            $('.tipo_opcion_multiple'+v).hide();
            $('#descripcion'+v).val('');
            $('#opcion_1'+v).val('');
            $('#opcion_2'+v).val('');
            $('#opcion_3'+v).val('');
            $('#opcion_4'+v).val('');
            $('#opcion_5'+v).val('');
            $("input:radio").attr("checked", false);
        }
    }

    function Delete_Pregunta(id) {
        Cargando();

        var url = "{{ route('linea_carrera_conf_pre.destroy', ':id') }}".replace(':id', id);
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
                            Lista_Pregunta();
                        });    
                    }
                });
            }
        })
    }
</script>