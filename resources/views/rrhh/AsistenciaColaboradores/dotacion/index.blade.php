<div class="col-md-12 row">
    <div class="form-group col-lg-2">
        <label>Fecha</label>
        <input type="date" class="form-control" id="f_fecha" name="f_fecha" value="<?php echo date('Y-m-d'); ?>">
    </div>

    <div class="form-group col-lg-1 d-flex align-items-center justify-content-center">
        <button type="button" class="btn btn-primary" onclick="Lista_Dotacion();">
            Buscar
        </button>
    </div>

    @csrf
    <div class="table-responsive mb-4 mt-4" id="lista_dotacion">
    </div>
</div>






<script>
    Lista_Dotacion();

    function Lista_Dotacion() {
        Cargando();

        var fecha = $("#f_fecha").val();
        var url = "{{ route('dotacion_colaborador.list') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            data: {
                'fecha': fecha,

            },
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function(data) {
                $('#lista_dotacion').html(data);
            }
        });
    }

    function Excel_Colaborador() {
        var id_gerencia = $('#id_gerenciab').val();
        window.location = "{{ route('colaborador_co.excel', ':id_gerencia') }}".replace(':id_gerencia', id_gerencia);
    }
</script>