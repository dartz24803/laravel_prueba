<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar horario programado:</h5>
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
                <select class="form-control" name="cod_basee" id="cod_basee">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                        <option value="{{ $list->cod_base }}" 
                        @if ($list->cod_base==$get_id->cod_base) selected @endif>
                            {{ $list->cod_base }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Cantidad de fotos (ingreso):</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="cant_foto_ingresoe" id="cant_foto_ingresoe" 
                placeholder="Cantidad foto ingreso" value="{{ $get_id->cant_foto_ingreso }}" 
                onkeypress="return solo_Numeros(event);">
            </div>

            <div class="form-group col-lg-2">
                <label>Cantidad de fotos (apertura):</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="cant_foto_aperturae" id="cant_foto_aperturae" 
                placeholder="Cantidad foto apertura" value="{{ $get_id->cant_foto_apertura }}" 
                onkeypress="return solo_Numeros(event);">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Cantidad de fotos (cierre):</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="cant_foto_cierree" id="cant_foto_cierree" 
                placeholder="Cantidad foto cierre" value="{{ $get_id->cant_foto_cierre }}" 
                onkeypress="return solo_Numeros(event);">
            </div>

            <div class="form-group col-lg-2">
                <label>Cantidad de fotos (salida):</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="cant_foto_salidae" id="cant_foto_salidae" 
                placeholder="Cantidad foto salida" value="{{ $get_id->cant_foto_salida }}" 
                onkeypress="return solo_Numeros(event);">
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-lg-2 n-chk d-flex align-items-center">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    @php 
                        $list_detalle = $list_detalle->toArray();
                        $busq_detalle = in_array('1', array_column($list_detalle, 'dia'));
                        $posicion = array_search('1', array_column($list_detalle, 'dia'));
                    @endphp
                    <input type="checkbox" class="new-control-input" id="ch_lue" name="ch_lue" value="1" @if ($busq_detalle != false) checked @endif onclick="Activar_Dia('lue')">
                    <span class="new-control-indicator"></span> &nbsp; &nbsp; &nbsp;  Lunes
                </label>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold">Ingreso:</label>
                <div class="form-group mb-2">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_ingreso_lue" name="hora_ingreso_lue" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_ingreso']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar desde:" style="cursor:help">Apertura: </label>
                <div class="form-group mb-1">
                    <input @if ($busq_detalle == false) disabled @endif style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_apertura_lue" name="hora_apertura_lue" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_apertura']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar hasta:" style="cursor:help">Cierre: </label>
                <div class="form-group mb-1">
                    <input @if ($busq_detalle == false) disabled @endif style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_cierre_lue" name="hora_cierre_lue" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_cierre']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold">Salida: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_salida_lue" name="hora_salida_lue" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_salida']; } @endphp">
                </div> 
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2 n-chk d-flex align-items-center">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    @php 
                        $busq_detalle = in_array('2', array_column($list_detalle, 'dia'));
                        $posicion = array_search('2', array_column($list_detalle, 'dia'));
                    @endphp
                    <input type="checkbox" class="new-control-input" id="ch_mae" name="ch_mae" value="1" @if ($busq_detalle != false) checked @endif onclick="Activar_Dia('mae')">
                    <span class="new-control-indicator"></span> &nbsp; &nbsp; &nbsp;  Martes
                </label>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold">Ingreso:</label>
                <div class="form-group mb-2">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_ingreso_mae" name="hora_ingreso_mae" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_ingreso']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar desde:" style="cursor:help">Apertura: </label>
                <div class="form-group mb-1">
                    <input @if ($busq_detalle == false) disabled @endif style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_apertura_mae" name="hora_apertura_mae" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_apertura']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar hasta:" style="cursor:help">Cierre: </label>
                <div class="form-group mb-1">
                    <input @if ($busq_detalle == false) disabled @endif style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_cierre_mae" name="hora_cierre_mae" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_cierre']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold">Salida: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_salida_mae" name="hora_salida_mae" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_salida']; } @endphp">
                </div> 
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2 n-chk d-flex align-items-center">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    @php 
                        $busq_detalle = in_array('3', array_column($list_detalle, 'dia'));
                        $posicion = array_search('3', array_column($list_detalle, 'dia'));
                    @endphp
                    <input type="checkbox" class="new-control-input" id="ch_mie" name="ch_mie" value="1" @if ($busq_detalle != false) checked @endif onclick="Activar_Dia('mie')">
                    <span class="new-control-indicator"></span> &nbsp; &nbsp; &nbsp;  Miércoles
                </label>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold">Ingreso:</label>
                <div class="form-group mb-2">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_ingreso_mie" name="hora_ingreso_mie" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_ingreso']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar desde:" style="cursor:help">Apertura: </label>
                <div class="form-group mb-1">
                    <input @if ($busq_detalle == false) disabled @endif style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_apertura_mie" name="hora_apertura_mie" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_apertura']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar hasta:" style="cursor:help">Cierre: </label>
                <div class="form-group mb-1">
                    <input @if ($busq_detalle == false) disabled @endif style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_cierre_mie" name="hora_cierre_mie" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_cierre']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold">Salida: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_salida_mie" name="hora_salida_mie" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_salida']; } @endphp">
                </div> 
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2 n-chk d-flex align-items-center">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    @php 
                        $busq_detalle = in_array('4', array_column($list_detalle, 'dia'));
                        $posicion = array_search('4', array_column($list_detalle, 'dia'));
                    @endphp
                    <input type="checkbox" class="new-control-input" id="ch_jue" name="ch_jue" value="1" @if ($busq_detalle != false) checked @endif onclick="Activar_Dia('jue')">
                    <span class="new-control-indicator"></span> &nbsp; &nbsp; &nbsp;  Jueves
                </label>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold">Ingreso:</label>
                <div class="form-group mb-2">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_ingreso_jue" name="hora_ingreso_jue" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_ingreso']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar desde:" style="cursor:help">Apertura: </label>
                <div class="form-group mb-1">
                    <input @if ($busq_detalle == false) disabled @endif style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_apertura_jue" name="hora_apertura_jue" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_apertura']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar hasta:" style="cursor:help">Cierre: </label>
                <div class="form-group mb-1">
                    <input @if ($busq_detalle == false) disabled @endif style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_cierre_jue" name="hora_cierre_jue" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_cierre']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold">Salida: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_salida_jue" name="hora_salida_jue" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_salida']; } @endphp">
                </div> 
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2 n-chk d-flex align-items-center">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    @php 
                        $busq_detalle = in_array('5', array_column($list_detalle, 'dia'));
                        $posicion = array_search('5', array_column($list_detalle, 'dia'));
                    @endphp
                    <input type="checkbox" class="new-control-input" id="ch_vie" name="ch_vie" value="1" @if ($busq_detalle != false) checked @endif onclick="Activar_Dia('vie')">
                    <span class="new-control-indicator"></span> &nbsp; &nbsp; &nbsp;  Viernes
                </label>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold">Ingreso:</label>
                <div class="form-group mb-2">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_ingreso_vie" name="hora_ingreso_vie" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_ingreso']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar desde:" style="cursor:help">Apertura: </label>
                <div class="form-group mb-1">
                    <input @if ($busq_detalle == false) disabled @endif style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_apertura_vie" name="hora_apertura_vie" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_apertura']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar hasta:" style="cursor:help">Cierre: </label>
                <div class="form-group mb-1">
                    <input @if ($busq_detalle == false) disabled @endif style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_cierre_vie" name="hora_cierre_vie" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_cierre']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold">Salida: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_salida_vie" name="hora_salida_vie" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_salida']; } @endphp">
                </div> 
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2 n-chk d-flex align-items-center">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    @php 
                        $busq_detalle = in_array('6', array_column($list_detalle, 'dia'));
                        $posicion = array_search('6', array_column($list_detalle, 'dia'));
                    @endphp
                    <input type="checkbox" class="new-control-input" id="ch_sae" name="ch_sae" value="1" @if ($busq_detalle != false) checked @endif onclick="Activar_Dia('sae')">
                    <span class="new-control-indicator"></span> &nbsp; &nbsp; &nbsp;  Sábado
                </label>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold">Ingreso:</label>
                <div class="form-group mb-2">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_ingreso_sae" name="hora_ingreso_sae" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_ingreso']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar desde:" style="cursor:help">Apertura: </label>
                <div class="form-group mb-1">
                    <input @if ($busq_detalle == false) disabled @endif style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_apertura_sae" name="hora_apertura_sae" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_apertura']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar hasta:" style="cursor:help">Cierre: </label>
                <div class="form-group mb-1">
                    <input @if ($busq_detalle == false) disabled @endif style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_cierre_sae" name="hora_cierre_sae" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_cierre']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold">Salida: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_salida_sae" name="hora_salida_sae" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_salida']; } @endphp">
                </div> 
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2 n-chk d-flex align-items-center">
                <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                    @php 
                        $busq_detalle = in_array('7', array_column($list_detalle, 'dia'));
                        $posicion = array_search('7', array_column($list_detalle, 'dia'));
                    @endphp
                    <input type="checkbox" class="new-control-input" id="ch_doe" name="ch_doe" value="1" @if ($busq_detalle != false) checked @endif onclick="Activar_Dia('doe')">
                    <span class="new-control-indicator"></span> &nbsp; &nbsp; &nbsp;  Domingo
                </label>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold">Ingreso:</label>
                <div class="form-group mb-2">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_ingreso_doe" name="hora_ingreso_doe" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_ingreso']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar desde:" style="cursor:help">Apertura: </label>
                <div class="form-group mb-1">
                    <input @if ($busq_detalle == false) disabled @endif style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_apertura_doe" name="hora_apertura_doe" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_apertura']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold" title="Permite marcar hasta:" style="cursor:help">Cierre: </label>
                <div class="form-group mb-1">
                    <input @if ($busq_detalle == false) disabled @endif style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_cierre_doe" name="hora_cierre_doe" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_cierre']; } @endphp">
                </div>
            </div>
            <div class="form-group col-lg-2">
                <label class=" control-label text-bold">Salida: </label>
                <div class="form-group mb-1">
                    <input disabled style="border-bottom: 2px dashed #acb0c3;border-radius: 0px;border-top: 0px;border-left: 0px;border-right: 0pc;padding-bottom: 0px;" type="time" class="form-control" id="hora_salida_doe" name="hora_salida_doe" value="@php if($busq_detalle != false){ echo $list_detalle[$posicion]['hora_salida']; } @endphp">
                </div> 
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Horario_Programado();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Horario_Programado() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('apertura_cierre_conf_ho.update', $get_id->id_tienda_marcacion) }}";

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
                        Lista_Horario_Programado();
                        $("#ModalUpdateGrande .close").click();
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