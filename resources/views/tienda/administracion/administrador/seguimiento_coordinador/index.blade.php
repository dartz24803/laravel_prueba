<div class="toolbar d-flex">
    <div class="col-lg-12 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('administrador_conf_sc.create', 0) }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
            Registrar
        </button>
    </div>
</div>

@csrf
<div class="table-responsive mb-4 mt-4" id="lista_c_seguimiento_coordinador">
</div>

<script>
    Lista_C_Seguimiento_Coordinador();

    function Lista_C_Seguimiento_Coordinador(){
        Cargando();

        var url = "{{ route('administrador_conf_sc.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#lista_c_seguimiento_coordinador').html(resp);  
            }
        });
    }

    
    function Periocidad(v){
        var id_periocidad = $("#id_periocidad"+v).val();

        if(id_periocidad==2){
            $(".div_semanal"+v).show();
            $(".div_quincenal"+v).hide();
            $("#dia_1"+v).val(0);
            $("#dia_2"+v).val(0);
            $(".div_mensual"+v).hide();
            $("#dia"+v).val(0);
            $(".div_anual"+v).hide();
            $("#mes"+v).val(0);
        }else if(id_periocidad==3){
            $(".div_quincenal"+v).show();
            $(".div_semanal"+v).hide();
            $("#nom_dia_1"+v).val(0);
            $("#nom_dia_2"+v).val(0);
            $("#nom_dia_3"+v).val(0);
            $(".div_mensual"+v).hide();
            $("#dia"+v).val(0);
            $(".div_anual"+v).hide();
            $("#mes"+v).val(0);
        }else if(id_periocidad==4){
            $(".div_mensual"+v).show();
            $(".div_semanal"+v).hide();
            $("#nom_dia_1"+v).val(0);
            $("#nom_dia_2"+v).val(0);
            $("#nom_dia_3"+v).val(0);
            $(".div_quincenal"+v).hide();
            $("#dia_1"+v).val(0);
            $("#dia_2"+v).val(0);
            $(".div_anual"+v).hide();
            $("#mes"+v).val(0);
            $("#dia"+v).val(0);
        }else if(id_periocidad==5){
            $(".div_mensual"+v).show();
            $(".div_semanal"+v).hide();
            $("#nom_dia_1"+v).val(0);
            $("#nom_dia_2"+v).val(0);
            $("#nom_dia_3"+v).val(0);
            $(".div_quincenal"+v).hide();
            $("#dia_1"+v).val(0);
            $("#dia_2"+v).val(0);
            $("#dia"+v).val(0);
            $(".div_anual"+v).show();
        }else{
            $(".div_semanal"+v).hide();
            $("#nom_dia_1"+v).val(0);
            $("#nom_dia_2"+v).val(0);
            $("#nom_dia_3"+v).val(0);
            $(".div_quincenal"+v).hide();
            $("#dia_1"+v).val(0);
            $("#dia_2"+v).val(0);
            $(".div_mensual"+v).hide();
            $("#dia"+v).val(0);
            $(".div_anual"+v).hide();
            $("#mes"+v).val(0);
        }
    }

    function Delete_C_Seguimiento_Coordinador(id) {
        Cargando();

        var url = "{{ route('administrador_conf_sc.destroy', ':id') }}".replace(':id', id);
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
                    data: {'id':id},
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_C_Seguimiento_Coordinador();
                        });    
                    }
                });
            }
        })
    }
</script>