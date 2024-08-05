<style>
    input[disabled] {
        background-color: white !important;
        color: black;
    }
</style>

<div class="d-md-flex align-items-md-center mt-3">
    <div class="form-group col-lg-2">
        <label>Sede:</label>
        <select class="form-control" id="id_sedeb" name="id_sedeb" onchange="Lista_Archivo();">
            <option value="0">TODOS</option>
            @foreach ($list_sede as $list)
                <option value="{{ $list->id_sede }}">{{ $list->nombre_sede }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-lg-2">
        <label>Local:</label>
        <select class="form-control" id="id_localb" name="id_localb" onchange="Lista_Archivo();">
            <option value="0">TODOS</option>
            @foreach ($list_local as $list)
                <option value="{{ $list->id_local }}">{{ $list->descripcion }}</option>
            @endforeach
        </select>
    </div>

    <div class="col-lg-4 col-xl-6">
        <button type="button" class="btn btn-primary mb-2 mb-sm-0 mb-md-2 mb-lg-0" onclick="Lista_Archivo();" title="Buscar">
            Buscar
        </button>
    </div>
</div>

@csrf
<div class="p-2 row ml-2" id="lista_archivo">
</div>

<script>
    function Lista_Archivo(){
        Cargando();

        var id_sede = $('#id_sedeb').val();
        var id_local = $('#id_localb').val();
        var url = "{{ route('control_camara_img.list') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type:"POST",
            url: url,
            data:{'id_sede':id_sede,'id_local':id_local},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (data) {
                $("#lista_archivo").html(data);
            }
        });
    }
</script>