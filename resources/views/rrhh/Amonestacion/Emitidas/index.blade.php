<?php
    $id_nivel = session('usuario')->id_nivel;
    $id_area = session('usuario')->id_area;
    $id_puesto = session('usuario')->id_puesto;
    ?>
<div class="toolbar">
    <div align="right">
        <?php
        if(session('usuario')->id_nivel==1 || 
        session('usuario')->nivel_jerarquico==3 ||  
        session('usuario')->nivel_jerarquico==4 || 
        //ADMINISTRADOR DE TIENDA
        session('usuario')->id_puesto==161 ||
        //COORDINADOR DE TIENDA
        session('usuario')->id_puesto==314){?>
        <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('Modal_Amonestacion') }}" >
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
            Registrar
        </button>
        <?php }?>
    </div>
</div>
@csrf
<div class="table-responsive mb-4 mt-4" id="lista_emitidas">
</div>

<script>
    Lista_Amonestaciones_Emitidas();

    function Lista_Amonestaciones_Emitidas() {
        Cargando();

        var url = "{{ url('Lista_Amonestaciones_Emitidas') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                $('#lista_emitidas').html(data);
            }
        });
    }
</script>
