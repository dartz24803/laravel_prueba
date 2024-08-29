<div class="toolbar d-md-flex align-items-md-center mt-3">
    <div class="form-group col-lg-2">
        <label>Base:</label>
        <select class="form-control" id="cod_baseb" name="cod_baseb" onchange="Lista_Solicitud_Puesto();">
            <option value="0">TODOS</option>
            @foreach ($list_base as $list)
                <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
            @endforeach
        </select>
    </div>
</div>

@csrf
<div class="table-responsive mb-4 mt-4" id="lista_solicitud_puesto">
</div>

<script>
    Lista_Solicitud_Puesto();

    function Lista_Solicitud_Puesto(){
        Cargando();

        var cod_base = $('#cod_baseb').val();
        var url = "{{ route('linea_carrera_so.list') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: "POST",
            data: {'cod_base':cod_base},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (resp) {
                $('#lista_solicitud_puesto').html(resp);  
            }
        });
    }

    function solo_Numeros(e) {
        var key = event.which || event.keyCode;
        if (key >= 48 && key <= 57) {
            return true;
        } else {
            return false;
        }
    }

    function Update_Solicitud_Puesto(id,estado){
        Cargando();

        var url="{{ route('linea_carrera_so.update', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type:"POST",
            data: {'estado':estado},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (data) {
                Lista_Solicitud_Puesto();
            },
            error:function(xhr) {
                var errors = xhr.responseJSON.errors;
                var firstError = Object.values(errors)[0][0];
                Swal.fire(
                    '¡Ups!',
                    firstError,
                    'warning'
                );
            }
        });
    }
</script>