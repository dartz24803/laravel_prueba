<div class="row mr-1 ml-1 mt-2">
    <div class="form-group col-lg-2">
        <label>Tipo:</label>
        <select class="form-control" id="tipob" name="tipob" onchange="Lista_Detalle_Gestion('{{ $id_centro_labor }}','{{ $mes }}','{{ $anio }}');">
            <option value="0" selected>Todo</option>
            <option value="1">Asistencia</option>
            <option value="2">Falta</option>
            <option value="3">Libre</option>
        </select>
    </div>

    <div class="row d-flex align-items-center col-lg-2">
        <a type="button" class="btn btn-primary" onclick="Regresar_Gestion('{{ $mes }}','{{ $anio }}');">Regresar</a> 
    </div>
</div>

<div class="table-responsive" id="lista_detalle_gestion">
</div>

<script>
    Lista_Detalle_Gestion('{{ $id_centro_labor }}','{{ $mes }}','{{ $anio }}');
    
    function Lista_Detalle_Gestion(id,mes,anio){
        Cargando();

        var tipo = $('#tipob').val();
        var url = "{{ route('cap_ges.list_detalle', ':id') }}".replace(':id', id);

        $.ajax({
            url: url,
            type: "POST",
            data: {'mes':mes,'anio':anio,'tipo':tipo},
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success:function (resp) {
                $('#lista_detalle_gestion').html(resp);
            }
        });
    }
</script>