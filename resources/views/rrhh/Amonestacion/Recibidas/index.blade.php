<?php
    $id_nivel = session('usuario')->id_nivel;
?>
@csrf
<div class="table-responsive mb-4 mt-4" id="lista_recibidas">
</div>

<script>
    Lista_Amonestaciones_Recibidas();

    function Lista_Amonestaciones_Recibidas() {
        Cargando();

        var url = "{{ url('Lista_Amonestaciones_Recibidas') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                $('#lista_recibidas').html(data);
            }
        });
    }
</script>
