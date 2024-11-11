<div class="row mr-1 ml-1 mt-2">
    <div class="form-group col-lg-2">
        <label>Mes:</label>
        <select class="form-control" id="mesb" name="mesb" onchange="Lista_Gestion();">
            <option value="0">Seleccione</option>
            @foreach ($list_mes as $list)
                <option value="{{ $list->cod_mes }}"
                @if ($list->cod_mes==date('m')) selected @endif>
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
                @if ($list->cod_anio==date('Y')) selected @endif>
                    {{ $list->cod_anio }}
                </option>
            @endforeach
        </select>
    </div>
</div>

<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    @csrf
    <div class="table-responsive" id="lista_registro">
    </div>
</form> 

<script>
    function Lista_Gestion(){
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