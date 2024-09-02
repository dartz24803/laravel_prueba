<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar pregunta:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Puesto:</label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" name="id_puestoe" id="id_puestoe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_puesto as $list)
                        <option value="{{ $list->id_puesto }}"
                        @if ($list->id_puesto==$get_id->id_puesto) selected @endif>
                            {{ $list->nom_puesto }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Tipo:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_tipoe" id="id_tipoe" onchange="Tipo('e');">
                    <option value="0">Seleccione</option>
                    <option value="1" @if ($get_id->id_tipo=="1") selected @endif>Abierta</option>
                    <option value="2" @if ($get_id->id_tipo=="2") selected @endif>Opción múltiple</option>
                </select>
            </div>
        </div>

        <div id="tipo_abiertae" class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="descripcione" id="descripcione" placeholder="Descripción" value="{{ $get_id->descripcion }}">
            </div>
        </div>

        <div class="row tipo_opcion_multiplee">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold" for="validar_opcion_1e">Opción 1:</label>
                <input type="radio" name="validar_opcione" id="validar_opcion_1e" value="1"
                @php 
                    $get_opcion = $get_opcion->toArray();
                    if(isset($get_opcion[0]['opcion']) && $get_opcion[0]['respuesta']=="1"){
                        echo "checked";
                    }
                @endphp>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="opcion_1e" id="opcion_1e" placeholder="Opción 1"
                value="@php if(isset($get_opcion[0]['opcion'])){ echo $get_opcion[0]['opcion']; } @endphp">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold" for="validar_opcion_2e">Opción 2:</label>
                <input type="radio" name="validar_opcione" id="validar_opcion_2e" value="2"
                @php 
                    if(isset($get_opcion[1]['opcion']) && $get_opcion[1]['respuesta']=="1"){
                        echo "checked";
                    }
                @endphp>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="opcion_2e" id="opcion_2e" placeholder="Opción 2"
                value="@php if(isset($get_opcion[1]['opcion'])){ echo $get_opcion[1]['opcion']; } @endphp">
            </div>
        </div>

        <div class="row tipo_opcion_multiplee">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold" for="validar_opcion_3e">Opción 3:</label>
                <input type="radio" name="validar_opcione" id="validar_opcion_3e" value="3"
                @php 
                    if(isset($get_opcion[2]['opcion']) && $get_opcion[2]['respuesta']=="1"){
                        echo "checked";
                    }
                @endphp>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="opcion_3e" id="opcion_3e" placeholder="Opción 3"
                value="@php if(isset($get_opcion[2]['opcion'])){ echo $get_opcion[2]['opcion']; } @endphp">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold" for="validar_opcion_4e">Opción 4:</label>
                <input type="radio" name="validar_opcione" id="validar_opcion_4e" value="4"
                @php 
                    if(isset($get_opcion[3]['opcion']) && $get_opcion[3]['respuesta']=="1"){
                        echo "checked";
                    }
                @endphp>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="opcion_4e" id="opcion_4e" placeholder="Opción 4"
                value="@php if(isset($get_opcion[3]['opcion'])){ echo $get_opcion[3]['opcion']; } @endphp">
            </div>
        </div>

        <div class="row tipo_opcion_multiplee">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold" for="validar_opcion_5e">Opción 5:</label>
                <input type="radio" name="validar_opcione" id="validar_opcion_5e" value="5"
                @php 
                    if(isset($get_opcion[4]['opcion']) && $get_opcion[4]['respuesta']=="1"){
                        echo "checked";
                    }
                @endphp>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="opcion_5e" id="opcion_5e" placeholder="Opción 5"
                value="@php if(isset($get_opcion[4]['opcion'])){ echo $get_opcion[4]['opcion']; } @endphp">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Pregunta();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(document).ready(function() {
        @if ($get_id->id_tipo=="1")
            $('#tipo_abiertae').show();
            $('.tipo_opcion_multiplee').hide();
        @elseif ($get_id->id_tipo=="2")
            $('#tipo_abiertae').show();
            $('.tipo_opcion_multiplee').show();
        @else 
            $('#tipo_abiertae').hide();
            $('.tipo_opcion_multiplee').hide();
        @endif
    });

    function Update_Pregunta() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('linea_carrera_conf_pre.update', $get_id->id) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="error"){
                    Swal({
                        title: '¡Actualización Denegada!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Pregunta();
                        $("#ModalUpdate .close").click();
                    });  
                }
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