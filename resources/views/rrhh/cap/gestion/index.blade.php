<div class="row mr-1 ml-1 mt-2">
    <div class="form-group col-lg-2">
        <label>Mes:</label>
        <select class="form-control" id="mesb" name="mesb" onchange="Lista_Gestion();">
            <option value="0">Seleccione</option>
            @foreach ($list_mes as $list)
                <option value="{{ $list->cod_mes }}"
                @if ($list->cod_mes==$mes) selected @endif>
                    {{ $list->nom_mes }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-lg-2">
        <label>Año:</label>
        <select class="form-control" id="aniob" name="aniob" onchange="Lista_Gestion();">
            <option value="0">Seleccione</option>
            @foreach ($list_anio as $list)
                <option value="{{ $list->cod_anio }}"
                @if ($list->cod_anio==$anio) selected @endif>
                    {{ $list->cod_anio }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<div class="table-responsive" id="lista_gestion">
</div>

<script>
    Lista_Gestion();

    function Lista_Gestion(){
        Cargando();

        var mes = $('#mesb').val();
        var anio = $('#aniob').val();
        var url = "{{ route('cap_ges.list') }}";

        $.ajax({
            url: url,
            type: "POST",
            data: {'mes':mes,'anio':anio},
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success:function (resp) {
                $('#lista_gestion').html(resp);
            }
        });
    }
</script>