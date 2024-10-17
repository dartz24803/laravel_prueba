@extends('layouts.plantilla')

@section('navbar')
@include('rrhh.navbar')
@endsection

@section('content')

<?php
$id_puesto=session('usuario')->id_puesto;
$id_nivel=session('usuario')->id_nivel;
?>
<style>
    #tabla_estilo{
        color: #000;
    }
    #tabla_estilo tbody tr:hover{
        background-color: #E3E4E5;
    }
    #tabla_estilo th:nth-child(<?php echo date('j')+2; ?>),td:nth-child(<?php echo date('j')+2; ?>){
        background-color: #FFE1E2;
    }
</style>
<style>
    .salidaa:hover {
        background-color: yellow;
    }
    .retornoo:hover {
        background-color: red;
    }
    .sin_retorno:hover {
        background-color: green;
    }
    svg.warning  {
        color: #e2a03f;
        fill: rgba(233, 176, 43, 0.19);
    }
    svg.primary  {
        color: #2196f3;
        fill: rgba(33, 150, 243, 0.19);
    }
    svg.danger  {
        color: #e7515a;
        fill: rgba(231, 81, 90, 0.19);
    }
    .pegadoleft{
        padding-left: 0px!important
    }
    .profile-img img {
        border-radius: 6px;
        background-color: #ebedf2;
        padding: 2px;
        width: 35px;
        height: 35px;
    }
    .chosen-container{
        height: 40px;
    }
    .chosen-container-single .chosen-single {
        height: 43px;
    }
    .chosen-container-single .chosen-single {
        height: 43px;
        padding-top: 9px;
    }
    .chosen-container-single .chosen-single div b {
        margin-top: 9px;
    }
    .btn svg {
        width: 29px;
        height: 30px;
        vertical-align: bottom;
    }
</style>
<?php
    $id_puesto = session('usuario')->id_puesto;
    $id_nivel = session('usuario')->id_nivel;
    $centro_labores = session('usuario')->centro_labores;

    $usuario_codigo = session('usuario')->usuario_codigo;
    $permiso_pps =   session('usuario')->estadopps; 

    $registro_masivo = session('usuario')->registro_masivo;
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="row layout-top-spacing" id="cancel-row">
            <div id="tabsSimple" class="col-lg-12 col-12 layout-spacing">
                <div class="statbox widget box box-shadow">
                    <div class="widget-content widget-content-area simple-tab">
                        <ul class="nav nav-tabs  mb-3 mt-3" id="simpletab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="registro-tab" data-toggle="tab" href="#registro" role="tab" aria-controls="home" aria-selected="true" onclick="Buscar_Papeleta_Registro()">Registro</a>
                                </li>
                            <?php if($permiso_pps==1 || $id_nivel==1 || $id_puesto==19 || $id_puesto==21 || $id_puesto==23 || $id_puesto==40 || 
                                    $id_puesto==10 || $id_puesto==93 || $id_puesto==314 || $id_puesto==315){?> 
                                <li class="nav-item">
                                    <a class="nav-link" id="aprobacion-tab" data-toggle="tab" href="#aprobacion" role="tab" aria-controls="home" aria-selected="true" onclick="Buscar_Papeletas_Salida_Gestion()">Aprobación</a>
                                </li>
                            <?php }?>
                            <?php if($id_nivel==1 || $id_puesto==23 || $id_puesto==36 || $id_puesto==24 || $id_puesto==26 || $id_puesto==128 || 
                            $id_puesto==21 || $id_puesto==19 || $id_puesto==279 || $id_puesto==209 || $id_puesto==307 || $id_puesto==315){?>
                                <li class="nav-item">
                                    <a class="nav-link" id="control-tab" data-toggle="tab" href="#control" role="tab" aria-controls="home" aria-selected="true" onclick="Buscar_Estado_Solicitud_Papeletas_Salida_Seguridad()">Control</a>
                                </li>    
                            <?php }?>
                        </ul>
                        
                        <div class="row" id="cancel-row">
                            <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                                <div id="div_papeletas" class="widget-content widget-content-area p-3">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
                
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#rhumanos").addClass('active');
        $("#hrhumanos").attr('aria-expanded','true');
        $("#papeletas").addClass('active');
        Buscar_Papeleta_Registro();
        //$("#busqueda_papeleta_seguridad").trigger("click");
        /*if('<?php echo $permiso_pps ?>'==1 || '<?php echo $id_nivel ?>'==1 || '<?php echo $usuario_codigo ?>'==="44582537" || '<?php echo $usuario_codigo ?>'==="46553611" || '<?php echo $usuario_codigo ?>'==="29426417" || '<?php echo $usuario_codigo ?>'==="08584691" || '<?php echo $usuario_codigo ?>'==="46156858" || '<?php echo $id_puesto ?>'==19 || '<?php echo $id_puesto ?>'==21 || '<?php echo $id_puesto ?>'==279 || '<?php echo $id_puesto ?>'==23 || '<?php echo $id_puesto ?>'==40){
            Busca_Registro_Papeleta()
        }*/
    });

    function Buscar_Papeleta_Registro(){
        Cargando();
        $(".nav-link").removeClass('active')
        var url = "{{ url('Papeletas/Buscar_Papeleta_Registro') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            type: "GET",
            success: function(resp) {
                $('#div_papeletas').html(resp);
                $("#registro-tab").addClass('active');
            }
        });
    }

    function Buscar_Estado_Solicitud_Papeletas_Salida_Seguridad() {
        Cargando();

        var base = $('#base').val();
        var num_doc = $('#num_doc_control').val();
        var estado_solicitud = $('#estado_solicitud3').val();
        //var id_area = $('#id_area').val();
        var fecha_revision = $('#fecha_revision3').val();
        var fecha_revision_fin = $('#fecha_revision_fin3').val();
        var url = "{{ url('Papeletas/Buscar_Base_Papeletas_Seguridad') }}";
        var ini = moment(fecha_revision);
        var fin = moment(fecha_revision_fin);
        var csrfToken = $('input[name="_token"]').val();

        if (ini.isAfter(fin) == true) {
            msgDate = 'La Fecha de Inicio no debe ser mayor a la de Fecha de Fin. <br> Porfavor corrígelo. ';
            inputFocus = '#hora_salida_hoy';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        } else if (fecha_revision != '' && fecha_revision_fin === '') {
            msgDate = 'Si va buscar por rango de fechas porfavor ponga la fecha final también  ';
            inputFocus = '#hora_salida_hoy';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });

        } else if (fecha_revision === '' && fecha_revision_fin != '') {
            msgDate = 'Si va buscar por rango de fechas porfavor ponga la fecha inicial también  ';
            inputFocus = '#hora_salida_hoy';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    'base': base,
                    'estado_solicitud': estado_solicitud,
                    'fecha_revision': fecha_revision,
                    'fecha_revision_fin': fecha_revision_fin,
                    'num_doc':num_doc
                },
                success: function(data) {
                    $('#lista_colaborador3').html(data);
                }
            });
        }

    }

    function Buscar_Papeletas_Salida_Gestion() {
        Cargando();
        var estado_solicitud = $('#estado_solicitud2').val();
        var fecha_revision = $('#fecha_revision').val();
        var fecha_revision_fin = $('#fecha_revision_fin').val();
        var url = "{{ url('Papeletas/Buscar_Papeletas_Salida_Gestion') }}";
        var csrfToken = $('input[name="_token"]').val();

        var ini = moment(fecha_revision);
        var fin = moment(fecha_revision_fin);

        if (ini.isAfter(fin) == true) {
            msgDate = 'La Fecha de Inicio no debe ser mayor a la de Fecha de Fin. <br> Porfavor corrígelo. ';
            inputFocus = '#hora_salida_hoy';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        } else if (fecha_revision != '' && fecha_revision_fin === '') {
            msgDate = 'Si va buscar por rango de fechas porfavor ponga la fecha final también  ';
            inputFocus = '#hora_salida_hoy';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });

        } else if (fecha_revision === '' && fecha_revision_fin != '') {
            msgDate = 'Si va buscar por rango de fechas porfavor ponga la fecha inicial también  ';
            inputFocus = '#hora_salida_hoy';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    'estado_solicitud': estado_solicitud,
                    'fecha_revision': fecha_revision,
                    'fecha_revision_fin': fecha_revision_fin
                },
                success: function(data) {
                    $('#lista_colaborador2').html(data);
                }
            });
        }
    }

    function Busca_Registro_Papeleta(){
        Cargando();
        var estado_solicitud = $('#estado_solicitud').val();//this.value;
        var url = "{{ url('Papeletas/Buscar_Estado_Solicitud_Papeletas_Salida_Usuario') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type:"POST",
            url:url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {'estado_solicitud':estado_solicitud },
            success:function (data) {
                $('#lista_colaborador').html(data);
            }
        });
    }
   
</script>
@endsection

<script>
    
    /***********primero tooltip */
    var anchors = document.querySelectorAll('.anchor-tooltip');
    anchors.forEach(function(anchor) {
        var toolTipText = anchor.getAttribute('title'),
            toolTip = document.createElement('span');
        toolTip.className = 'title-tooltip';
        toolTip.innerHTML = toolTipText;
        anchor.appendChild(toolTip);
    });
    /***********primero tooltip. */

    $('.buttonDownload[download]').each(function() {
        var $a = $(this),
        fileUrl = $a.attr('href');
        $a.attr('href', 'data:application/octet-stream,' + encodeURIComponent(fileUrl));
    });

    function Vista_Imagen_Perfil(image_url,imageTitle){
        $('#modelTitle').html(imageTitle); 
        $('#modalImgs').attr('src',image_url);
        $('#profileModal').modal('show');
        //var nombredeusu= $("#id_usuarioactual").val();
        var nombredeusu= 'p';
        document.getElementById("descargarcertificado_estudiog").innerHTML = "<a href='"+image_url+"' id='imga' class='btn buttonDownload' download='qr_"+nombredeusu+".jpg'>Descargar</a>"
    }
    
</script>

<!----segundo tab aprobacion-->
