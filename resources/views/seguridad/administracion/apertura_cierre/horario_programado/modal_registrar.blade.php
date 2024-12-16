<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nuevo horario programado:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Base:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="cod_base" id="cod_base">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                        <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Cantidad de fotos (ingreso):</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="cant_foto_ingreso" id="cant_foto_ingreso" 
                placeholder="Cantidad foto ingreso" onkeypress="return solo_Numeros(event);">
            </div>

            <div class="form-group col-lg-2">
                <label>Cantidad de fotos (apertura):</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="cant_foto_apertura" id="cant_foto_apertura" 
                placeholder="Cantidad foto apertura" onkeypress="return solo_Numeros(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Cantidad de fotos (cierre):</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="cant_foto_cierre" id="cant_foto_cierre" 
                placeholder="Cantidad foto cierre" onkeypress="return solo_Numeros(event);">
            </div>

            <div class="form-group col-lg-2">
                <label>Cantidad de fotos (salida):</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="cant_foto_salida" id="cant_foto_salida" 
                placeholder="Cantidad foto salida" onkeypress="return solo_Numeros(event);">
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-lg-2 n-chk d-flex align-items-center">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_lu" name="ch_lu" value="1" onclick="Activar_Dia('lu')">
                    <span class="new-control-indicator"></span> &nbsp; &nbsp; &nbsp;  Lunes
                </label>
            </div>
            <!--<div class="form-group col-lg-2">
                <label class=" control-label text-bold">Ingreso:</label>
                <div class="form-group mb-2">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_ingreso_lu" name="hora_ingreso_lu">
                </div>
            </div>-->
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar desde:" style="cursor:help">Apertura: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_apertura_lu" name="hora_apertura_lu" >
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar hasta:" style="cursor:help">Cierre: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_cierre_lu" name="hora_cierre_lu" >
                </div>
            </div>
            <!--<div class="form-group col-lg-2">
                <label class=" control-label text-bold">Salida: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_salida_lu" name="hora_salida_lu">
                </div> 
            </div>-->
        </div>

        <div class="row">
            <div class="form-group col-lg-2 n-chk d-flex align-items-center">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_ma" name="ch_ma" value="1" onclick="Activar_Dia('ma')">
                    <span class="new-control-indicator"></span> &nbsp; &nbsp; &nbsp;  Martes
                </label>
            </div>
            <!--<div class="form-group col-lg-2">
                <label class=" control-label text-bold">Ingreso:</label>
                <div class="form-group mb-2">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_ingreso_ma" name="hora_ingreso_ma">
                </div>
            </div>-->
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar desde:" style="cursor:help">Apertura: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_apertura_ma" name="hora_apertura_ma" >
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar hasta:" style="cursor:help">Cierre: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_cierre_ma" name="hora_cierre_ma" >
                </div>
            </div>
            <!--<div class="form-group col-lg-2">
                <label class=" control-label text-bold">Salida: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_salida_ma" name="hora_salida_ma">
                </div> 
            </div>-->
        </div>

        <div class="row">
            <div class="form-group col-lg-2 n-chk d-flex align-items-center">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_mi" name="ch_mi" value="1" onclick="Activar_Dia('mi')">
                    <span class="new-control-indicator"></span> &nbsp; &nbsp; &nbsp;  Miércoles
                </label>
            </div>
            <!--<div class="form-group col-lg-2">
                <label class=" control-label text-bold">Ingreso:</label>
                <div class="form-group mb-2">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_ingreso_mi" name="hora_ingreso_mi">
                </div>
            </div>-->
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar desde:" style="cursor:help">Apertura: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_apertura_mi" name="hora_apertura_mi" >
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar hasta:" style="cursor:help">Cierre: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_cierre_mi" name="hora_cierre_mi" >
                </div>
            </div>
            <!--<div class="form-group col-lg-2">
                <label class=" control-label text-bold">Salida: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_salida_mi" name="hora_salida_mi">
                </div> 
            </div>-->
        </div>

        <div class="row">
            <div class="form-group col-lg-2 n-chk d-flex align-items-center">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_ju" name="ch_ju" value="1" onclick="Activar_Dia('ju')">
                    <span class="new-control-indicator"></span> &nbsp; &nbsp; &nbsp;  Jueves
                </label>
            </div>
            <!--<div class="form-group col-lg-2">
                <label class=" control-label text-bold">Ingreso:</label>
                <div class="form-group mb-2">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_ingreso_ju" name="hora_ingreso_ju">
                </div>
            </div>-->
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar desde:" style="cursor:help">Apertura: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_apertura_ju" name="hora_apertura_ju" >
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar hasta:" style="cursor:help">Cierre: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_cierre_ju" name="hora_cierre_ju" >
                </div>
            </div>
            <!--<div class="form-group col-lg-2">
                <label class=" control-label text-bold">Salida: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_salida_ju" name="hora_salida_ju">
                </div> 
            </div>-->
        </div>

        <div class="row">
            <div class="form-group col-lg-2 n-chk d-flex align-items-center">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_vi" name="ch_vi" value="1" onclick="Activar_Dia('vi')">
                    <span class="new-control-indicator"></span> &nbsp; &nbsp; &nbsp;  Viernes
                </label>
            </div>
            <!--<div class="form-group col-lg-2">
                <label class=" control-label text-bold">Ingreso:</label>
                <div class="form-group mb-2">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_ingreso_vi" name="hora_ingreso_vi">
                </div>
            </div>-->
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar desde:" style="cursor:help">Apertura: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_apertura_vi" name="hora_apertura_vi" >
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar hasta:" style="cursor:help">Cierre: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_cierre_vi" name="hora_cierre_vi" >
                </div>
            </div>
            <!--<div class="form-group col-lg-2">
                <label class=" control-label text-bold">Salida: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_salida_vi" name="hora_salida_vi">
                </div> 
            </div>-->
        </div>

        <div class="row">
            <div class="form-group col-lg-2 n-chk d-flex align-items-center">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_sa" name="ch_sa" value="1" onclick="Activar_Dia('sa')">
                    <span class="new-control-indicator"></span> &nbsp; &nbsp; &nbsp;  Sábado
                </label>
            </div>
            <!--<div class="form-group col-lg-2">
                <label class=" control-label text-bold">Ingreso:</label>
                <div class="form-group mb-2">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_ingreso_sa" name="hora_ingreso_sa">
                </div>
            </div>-->
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar desde:" style="cursor:help">Apertura: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_apertura_sa" name="hora_apertura_sa" >
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar hasta:" style="cursor:help">Cierre: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_cierre_sa" name="hora_cierre_sa" >
                </div>
            </div>
            <!--<div class="form-group col-lg-2">
                <label class=" control-label text-bold">Salida: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_salida_sa" name="hora_salida_sa">
                </div> 
            </div>-->
        </div>

        <div class="row">
            <div class="form-group col-lg-2 n-chk d-flex align-items-center">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    <input type="checkbox" class="new-control-input" id="ch_do" name="ch_do" value="1" onclick="Activar_Dia('do')">
                    <span class="new-control-indicator"></span> &nbsp; &nbsp; &nbsp;  Domingo
                </label>
            </div>
            <!--<div class="form-group col-lg-2">
                <label class=" control-label text-bold">Ingreso:</label>
                <div class="form-group mb-2">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_ingreso_do" name="hora_ingreso_do">
                </div>
            </div>-->
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar desde:" style="cursor:help">Apertura: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_apertura_do" name="hora_apertura_do" >
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar hasta:" style="cursor:help">Cierre: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_cierre_do" name="hora_cierre_do" >
                </div>
            </div>
            <!--<div class="form-group col-lg-2">
                <label class=" control-label text-bold">Salida: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_salida_do" name="hora_salida_do">
                </div> 
            </div>-->
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Horario_Programado();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Horario_Programado() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('apertura_cierre_conf_ho.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="error"){
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        '¡Registro Exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Horario_Programado();
                        $("#ModalRegistroGrande .close").click();
                    })
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
