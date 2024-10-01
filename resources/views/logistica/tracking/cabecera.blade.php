@php
    $fecha_formateada =  date('l d')." de ".date('F')." del ".date('Y');
    $dias_ingles = array('Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday');
    $dias_espanol = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
    $meses_ingles = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
    $meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre');
    $fecha_formateada = str_replace($dias_ingles, $dias_espanol, $fecha_formateada);
    $fecha_formateada = str_replace($meses_ingles, $meses_espanol, $fecha_formateada);
@endphp

<div class="form-group col-lg-2">
    <label class="control-label text-bold" style="color: black;">SEMANA: {{ $get_id->semana }}</label>
</div>

<div class="form-group col-lg-2">
    <label class="control-label text-bold" style="color: black;">Nro. Req.: {{ $get_id->n_requerimiento }}</label>
</div>

<div class="form-group col-lg-2">
    <label class="control-label text-bold" style="color: black;">Base: {{ $get_id->hacia }}</label>
</div>

<div class="form-group col-lg-2">
    <label class="control-label text-bold" style="color: black;">Distrito: {{ $get_id->nombre_distrito }}</label>
</div>

<div class="form-group col-lg-4">
    <label class="control-label text-bold" style="color: black;">Fecha: {{ $fecha_formateada }}</label>
</div>