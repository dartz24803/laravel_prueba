<form id="formulario_registrar_planilla" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Dato Planilla</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Situación Laboral: </label>
            </div>            
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_situacion_laboral" id="id_situacion_laboral" 
                onchange="Cambio_Situacion('');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_situacion_laboral as $list)
                        <option value="{{ $list->id_situacion_laboral }}">
                            {{ $list->nom_situacion_laboral }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 ver_sl" style="display:none">
                <label class="control-label text-bold">Tipo Contrato: </label>
            </div>            
            <div class="form-group col-lg-4 ver_sl" style="display:none">
                <select class="form-control" name="id_tipo_contrato" id="id_tipo_contrato" 
                onchange="Fecha_Vencimiento('');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_tipo_contrato as $list)
                        <option value="{{ $list->id_tipo_contrato }}">
                            {{ $list->nom_tipo_contrato }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2 ver_sl" style="display:none">
                <label class="control-label text-bold">Empresa: </label>
            </div>            
            <div class="form-group col-lg-4 ver_sl" style="display:none">
                <select class="form-control" name="id_empresa" id="id_empresa" >
                    <option value="0">Seleccione</option>
                    @foreach ($list_empresa as $list)
                        <option value="{{ $list->id_empresa }}">{{ $list->nom_empresa }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 ver_sl" style="display:none">
                <label class="control-label text-bold">Régimen: </label>
            </div>            
            <div class="form-group col-lg-4 ver_sl" style="display:none">
                <select class="form-control" name="id_regimen" id="id_regimen" >
                    <option value="0">Seleccione</option>
                    @foreach ($list_regimen as $list)
                        <option value="{{ $list->id_regimen }}">{{ $list->nom_regimen }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Sueldo: </label> 
            </div>            
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="sueldo" name="sueldo" 
                placeholder="Ingresar Sueldo" onkeypress="return solo_Numeros_Punto(event);">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Bono: </label>
            </div>            
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="bono" name="bono" 
                placeholder="Ingresar Bono" onkeypress="return solo_Numeros_Punto(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha Inicio: </label>
            </div>            
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" id="fec_inicio" name="fec_inicio">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold ver_fv">Fecha Vencimiento: </label>
            </div>            
            <div class="form-group col-lg-4">
                <input type="date" class="form-control ver_fv" id="fec_vencimiento" 
                name="fec_vencimiento">
            </div>
        </div>

        @if ($cantidad>0)
            <div class="row">
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Tipo: </label>
                </div>            
                <div class="form-group col-lg-4">
                    <label class="control-label text-bold">
                        @if ($ultimo->motivo_fin=="1")
                            Renovación
                        @elseif ($ultimo->motivo_fin=="2")
                            Reingreso
                        @endif
                    </label>
                    <input type="hidden" id="id_tipo" name="id_tipo" 
                    value="
                    @php 
                        if($ultimo->motivo_fin=="1"){ 
                            echo "4";
                        }elseif($ultimo->motivo_fin=="2"){ 
                            echo "5";
                        } 
                    @endphp">
                </div>
            </div>
        @else
            <input type="hidden" id="id_tipo" name="id_tipo" value="6">
        @endif
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Datos_Planilla();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Datos_Planilla() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_registrar_planilla'));
        var url = "{{ route('colaborador_pl.store', $id_usuario) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == "error") {
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡Existe un registro con la misma fecha de inicio!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else if (data == "incompleto") {
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡Existe un registro en estado activo!",
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else {
                    swal.fire(
                        '¡Registro Exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Planilla_Parte_Superior();
                        Planilla_Parte_Inferior();
                        $("#ModalRegistro .close").click();
                        $('#btn_enviar_correo1').prop('disabled', false).removeClass('btn-gray').addClass('btn-primary');
                        $('#btn_enviar_correo2').prop('disabled', false).removeClass('btn-gray').addClass('btn-danger');
                    });
                }
            },
            error: function(xhr) {
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