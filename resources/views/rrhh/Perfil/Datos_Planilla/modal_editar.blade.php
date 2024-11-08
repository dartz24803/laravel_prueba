<form id="formulario_editar_planilla" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Dato Planilla</h5>
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
                <select class="form-control" disabled>
                    <option value="0">Seleccione</option>
                    @foreach ($list_situacion_laboral as $list)
                        <option value="{{ $list->id_situacion_laboral }}"
                        @if ($list->id_situacion_laboral==$get_id->id_situacion_laboral) selected @endif>
                            {{ $list->nom_situacion_laboral }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 ver_sle" @if ($get_id->id_situacion_laboral=="1") style="display:none" @endif>
                <label class="control-label text-bold">Tipo Contrato: </label>
            </div>            
            <div class="form-group col-lg-4 ver_sle" @if ($get_id->id_situacion_laboral=="1") style="display:none" @endif>
                <select class="form-control" name="id_tipo_contratoe" id="id_tipo_contratoe" 
                onchange="Fecha_Vencimiento('e');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_tipo_contrato as $list)
                        <option value="{{ $list->id_tipo_contrato }}"
                        @if ($list->id_tipo_contrato==$get_id->id_tipo_contrato) selected @endif>
                            {{ $list->nom_tipo_contrato }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2 ver_sle" @if ($get_id->id_situacion_laboral=="1") style="display:none" @endif>
                <label class="control-label text-bold">Empresa: </label>
            </div>            
            <div class="form-group col-lg-4 ver_sle" @if ($get_id->id_situacion_laboral=="1") style="display:none" @endif>
                <select class="form-control" name="id_empresae" id="id_empresae">
                    <option value="0">Seleccione</option>
                    @foreach ($list_empresa as $list)
                        <option value="{{ $list->id_empresa }}"
                        @if ($list->id_empresa==$get_id->id_empresa) selected @endif>
                            {{ $list->nom_empresa }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 ver_sle" @if ($get_id->id_situacion_laboral=="1") style="display:none" @endif>
                <label class="control-label text-bold">Régimen: </label>
            </div>            
            <div class="form-group col-lg-4 ver_sle" @if ($get_id->id_situacion_laboral=="1") style="display:none" @endif>
                <select class="form-control" name="id_regimene" id="id_regimene">
                    <option value="0">Seleccione</option>
                    @foreach ($list_regimen as $list)
                        <option value="{{ $list->id_regimen }}"
                        @if ($list->id_regimen==$get_id->id_regimen) selected @endif>
                            {{ $list->nom_regimen }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Sueldo: </label> 
            </div>            
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="sueldoe" name="sueldoe" 
                placeholder="Ingresar Sueldo" value="{{ $get_id->sueldo }}" 
                onkeypress="return solo_Numeros_Punto(event);">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Bono: </label>
            </div>            
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="bonoe" name="bonoe" 
                placeholder="Ingresar Bono" value="{{ $get_id->bono }}" 
                onkeypress="return solo_Numeros_Punto(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha Inicio: </label>
            </div>            
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" value="{{ $get_id->fec_inicio }}" disabled>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold ver_fve">Fecha Vencimiento: </label>
            </div>            
            <div class="form-group col-lg-4">
                <input type="date" class="form-control ver_fve" id="fec_vencimientoe" 
                value="{{ $get_id->fec_vencimiento }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Motivo Fin: </label>
            </div>            
            <div class="form-group col-lg-4">
                <select class="form-control" name="motivo_fin" id="motivo_fin" 
                onchange="Motivo_Fin();">
                    <option value="0">Seleccione</option>
                    <option value="1">Renovación</option>
                    <option value="2">Cesado</option>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha Fin: </label>
            </div>            
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" id="fec_fin" name="fec_fin" value="{{ $get_id->fec_fin }}" 
                disabled>
            </div>
        </div>

        {{--RENOVACIÓN--}}
        <div class="row div_renovacion" style="display:none;">
            <div class="form-group col-lg-12">
                <h5 class="modal-title"><b>Registrar Nuevo Dato Planilla</b></h5>
            </div>  
        </div>
    
        <div class="row div_renovacion" style="display:none;">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Situación Laboral: </label>
            </div>            
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_situacion_laboralr" id="id_situacion_laboralr" onchange="Cambio_Situacion('r')">
                    <option value="0">Seleccione</option>
                    @foreach ($list_situacion_laboral as $list)
                        <option value="{{ $list->id_situacion_laboral }}">
                            {{ $list->nom_situacion_laboral }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 ver_slr" style="display:none">
                <label class="control-label text-bold">Tipo Contrato: </label>
            </div>            
            <div class="form-group col-lg-4 ver_slr" style="display:none">
                <select class="form-control" name="id_tipo_contrator" id="id_tipo_contrator" onchange="Fecha_Vencimiento('r');">
                    <option value="0">Seleccione</option>
                    @foreach ($list_tipo_contrato as $list)
                        <option value="{{ $list->id_tipo_contrato }}">
                            {{ $list->nom_tipo_contrato }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>            

        <div class="row div_renovacion" style="display:none;">
            <div class="form-group col-lg-2 ver_slr" style="display:none">
                <label class="control-label text-bold">Empresa: </label>
            </div>            
            <div class="form-group col-lg-4 ver_slr" style="display:none">
                <select class="form-control" name="id_empresar" id="id_empresar">
                    <option value="0">Seleccione</option>
                    @foreach ($list_empresa as $list)
                        <option value="{{ $list->id_empresa }}">{{ $list->nom_empresa }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 ver_slr" style="display:none">
                <label class="control-label text-bold">Régimen: </label>
            </div>            
            <div class="form-group col-lg-4 ver_slr" style="display:none">
                <select class="form-control" name="id_regimenr" id="id_regimenr">
                    <option value="0">Seleccione</option>
                    @foreach ($list_regimen as $list)
                        <option value="{{ $list->id_regimen }}">{{ $list->nom_regimen }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row div_renovacion" style="display:none;">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Sueldo: </label>
            </div>            
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="sueldor" name="sueldor" placeholder="Ingresar Sueldo" 
                onkeypress="return solo_Numeros_Punto(event);">
            </div>

            <div class="form-group col-lg-2 ver_slr" style="display:none">
                <label class="control-label text-bold">Bono: </label>
            </div>            
            <div class="form-group col-lg-4 ver_slr" style="display:none">
                <input type="text" class="form-control" id="bonor" name="bonor" placeholder="Ingresar Bono" 
                onkeypress="return solo_Numeros_Punto(event);">
            </div>
        </div>

        <div class="row div_renovacion" style="display:none;">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha Inicio: </label>
            </div>            
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" id="fec_inicior" name="fec_inicior">
            </div>

            <div class="form-group col-lg-2 ver_fvr">
                <label class="control-label text-bold">Fecha Vencimiento: </label>
            </div>            
            <div class="form-group col-lg-4 ver_fvr">
                <input type="date" class="form-control" id="fec_vencimientor" name="fec_vencimientor">
            </div>
        </div>

        {{--CESE--}}
        <div class="row div_cese" style="display:none;">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Motivo de Cese: </label>
            </div>            
            <div class="form-group col-lg-4">
                <select class="form-control basic" name="id_motivo_cesec" id="id_motivo_cesec">
                    <option value="0">Seleccione</option>
                    @foreach ($list_motivo_cese as $list)
                        <option value="{{ $list->id_motivo }}">{{ $list->nom_motivo }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row div_cese" style="display:none;">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Adjuntar Archivo: </label>
            </div>            
            <div class="form-group col-lg-10">
                <input type="file" class="form-control-file" id="archivo_cesec" name="archivo_cesec" 
                onchange="Valida_Archivo('archivo_cesec');">
            </div>
        </div>

        <div class="row div_cese" style="display:none;">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Especificar: </label>
            </div>            
            <div class="form-group col-lg-10">
                <textarea name="observacionc" id="observacionc" rows="3" class="form-control"></textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Datos_Planilla();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Motivo_Fin(){
        if ($('#motivo_fin').val() != "0") {
            $('#fec_fin').removeAttr("disabled");
        }else{
            $("#fec_fin").prop('disabled', true);
            $('#fec_fin').val('');
        }

        if($('#motivo_fin').val()=="1"){
            $('.div_renovacion').show();
            $('.div_cese').hide();
            $('#id_motivo_cesec').val('0');
            $('#archivo_cesec').val('');
            $('#observacionc').val('');
        }else if($('#motivo_fin').val()=="2"){
            $('.div_renovacion').hide();
            $('.div_cese').show();
            $('.ver_slr').hide();
            $('#id_situacion_laboralr').val('0');
            $('#id_tipo_contrator').val('0');
            $('#id_empresar').val('0');
            $('#id_regimenr').val('0');
            $('#sueldor').val('');
            $('#bonor').val('');
            $('#fec_inicior').val('');
            $('#fec_vencimientor').val('');
        }else{
            $('.div_renovacion').hide();
            $('.div_cese').hide();
            $('.ver_slr').hide();
            $('#id_situacion_laboralr').val('0');
            $('#id_tipo_contrator').val('0');
            $('#id_empresar').val('0');
            $('#id_regimenr').val('0');
            $('#sueldor').val('');
            $('#bonor').val('');
            $('#fec_inicior').val('');
            $('#fec_vencimientor').val('');
            $('#id_motivo_cesec').val('0');
            $('#archivo_cesec').val('');
            $('#observacionc').val('');
        }
    }

    function Update_Datos_Planilla() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario_editar_planilla'));
        var url = "{{ route('colaborador_pl.update', $get_id->id_historico_colaborador) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data == "error"){
                    Swal({
                        title: '¡Actualización Denegada!',
                        text: "¡Existe un registro con la misma fecha de inicio!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else if(data == "incompleto"){
                    Swal({
                        title: '¡Actualización Denegada!',
                        text: "¡Existe un registro en estado activo!",
                        type: 'warning',
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
                        Planilla_Parte_Superior();
                        Planilla_Parte_Inferior();
                        $("#ModalUpdate .close").click();
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