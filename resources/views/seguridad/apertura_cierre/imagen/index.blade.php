<style>
    input[disabled] {
        background-color: white !important;
        color: black;
    }
</style>

<div class="toolbar d-md-flex align-items-md-center mt-3">
    @if (session('usuario')->id_nivel=="1" || 
    session('usuario')->id_puesto=="23" || 
    session('usuario')->id_puesto=="24" || 
    session('usuario')->id_puesto=="158" || 
    session('usuario')->id_puesto=="209" ||         
    session('usuario')->id_puesto=="307")
        <div class="form-group col-lg-2">
            <label>Base:</label>
            <select class="form-control" id="cod_baseb" name="cod_baseb" onchange="Lista_Apertura_Cierre();">
                <option value="0">TODOS</option>
                @foreach ($list_base as $list)
                    <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
                @endforeach
            </select>
        </div>
    @else
        <div class="form-group col-lg-2">
            <label>Base:</label>
            <input type="text" class="form-control" name="cod_baseb" id="cod_baseb" value="{{ session('usuario')->centro_labores }}" disabled>
        </div>
    @endif

    <div class="form-group col-lg-3 col-xl-2">
        <label>Fecha Inicio:</label>
        <input type="date" class="form-control" name="fecha_iniciob" id="fecha_iniciob" value="{{ date('Y-m-d') }}">
    </div>

    <div class="form-group col-lg-3 col-xl-2">
        <label>Fecha Fin:</label>
        <input type="date" class="form-control" name="fecha_finb" id="fecha_finb" value="{{ date('Y-m-d') }}">
    </div>

    <div class="col-lg-4 col-xl-6">
        <button type="button" class="btn btn-primary mb-2 mb-sm-0 mb-md-2 mb-lg-0" onclick="Lista_Galeria();" title="Buscar">
            Buscar
        </button>
    </div>
</div>

<div class="p-2 row ml-2" id="lista_galeria">
</div>

<script>
    Lista_Galeria();

    function Lista_Galeria(){
        Cargando();

        var cod_base = $('#cod_baseb').val();
        var fec_ini = $('#fecha_iniciob').val();
        var fec_fin = $('#fecha_finb').val();
        var url = "{{ route('apertura_cierre_img.list') }}";

        $.ajax({
            type:"POST",
            url: url,
            data:{'cod_base':cod_base,'fec_ini':fec_ini,'fec_fin':fec_fin},
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success:function (data) {
                $("#lista_galeria").html(data);
            }
        });
    }
</script>
