<div class="row mr-1 ml-1 mt-2">
    <div class="form-group col-lg-2">
        <label>Base:</label>
        <select class="form-control" id="baseb" name="baseb" onchange="Lista_Detalle();">
            <option value="0">Todos</option>
            @foreach ($list_base as $list)
                <option value="{{ $list->id_base }}"
                @if ($list->cod_base==session('usuario')->centro_labores) selected @endif>
                    {{ $list->cod_base }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-lg-2">
        <label>Año:</label>
        <select class="form-control" id="aniob" name="aniob" onchange="Lista_Detalle();">
            <option value="0">Todos</option>
            @foreach ($list_anio as $list)
                <option value="{{ $list->cod_anio }}"
                @if ($list->cod_anio==date('Y')) selected @endif>
                    {{ $list->cod_anio }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-lg-2">
        <label>Semana:</label>
        <select class="form-control" id="semanab" name="semanab" onchange="Lista_Detalle();">
            <option value="0">Todos</option>
            @php $semana = 53; $i = 1; @endphp
            @while ($i<=$semana)
                <option value="{{ $i }}" @if ($i==date('W')) selected @endif>
                    {{ $i }}
                </option>
            @php $i++; @endphp
            @endwhile
        </select>
    </div>
</div>

<div class="table-responsive" id="lista_detalle">
</div>

<script>
    Lista_Detalle();

    function Lista_Detalle(){
        Cargando();
        
        var base = $('#baseb').val();
        var anio = $('#aniob').val();
        var semana = $('#semanab').val();
        var url = "{{ route('tracking_det.list') }}";

        $.ajax({
            url: url,
            type: "POST",
            data: {'base':base,'anio':anio,'semana':semana},
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success:function (resp) {
                $('#lista_detalle').html(resp);  
            }
        });
    }
</script>