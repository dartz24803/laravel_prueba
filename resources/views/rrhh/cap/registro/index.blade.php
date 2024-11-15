<div class="row mr-1 ml-1 mt-2">
    <div class="form-group col-lg-2">
        <label>Centro de labor:</label>
        <select class="form-control" id="id_ubicacionb" name="id_ubicacionb" onchange="Lista_Registro();">
            <option value="0">Seleccione</option>
            @foreach ($list_ubicacion as $list)
                <option value="{{ $list->id_ubicacion }}"
                @if ($list->id_ubicacion==session('usuario')->id_centro_labor) selected @endif>
                    {{ $list->cod_ubi }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-lg-2">
        <label>Fecha:</label>
        <input type="date" class="form-control" id="fechab" name="fechab" value="{{ date('Y-m-d') }}">
    </div>

    <div class="col-lg-2 d-flex align-items-center justify-content-start mb-0 mb-lg-4">
        <button type="button" class="btn btn-primary" title="Buscar" 
        onclick="Lista_Registro();">
            Buscar
        </button>
    </div>

    <div class="col d-flex align-items-center justify-content-end mb-0 mb-lg-4">
        <button type="button" class="btn btn-primary" title="Buscar" 
        onclick="Insert_Registro();">
            Actualizar
        </button>
    </div>
</div>

<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    @csrf
    <div class="table-responsive" id="lista_registro">
    </div>
</form> 

<script>
    Lista_Registro();
    
    function Lista_Registro(){
        Cargando();

        var id_ubicacion = $('#id_ubicacionb').val();

        if(id_ubicacion=="0"){
            $('#lista_registro').html('');  
        }else{
            var fecha = $('#fechab').val();
            var url = "{{ route('cap_reg.list') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: {'id_ubicacion':id_ubicacion,'fecha':fecha},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#lista_registro').html(resp);
                }
            });
        }
    }
    
    function solo_Numeros_Punto(e) {
        var key = event.which || event.keyCode;
        if ((key >= 48 && key <= 57) || key == 46) {
            if (key == 46 && event.target.value.indexOf('.') !== -1) {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    function Insert_Registro(){
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('cap_reg.store') }}";

        var id_ubicacion = $('#id_ubicacionb').val();
        dataString.append('id_ubicacion', id_ubicacion);
        var fecha = $('#fechab').val();
        dataString.append('fecha', fecha);

        $.ajax({
            type: "POST",
            url: url,
            data: dataString,
            processData: false,
            contentType: false,
            success:function (data) {
                swal.fire(
                    '¡Actualización Exitosa!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Registro();
                });
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