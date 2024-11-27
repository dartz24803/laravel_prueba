@extends('layouts.plantilla')

@section('navbar')
    @include('seguridad.navbar')
@endsection

@section('content')
<?php 
$id_nivel=session('usuario')->id_nivel;
$id_puesto=session('usuario')->id_puesto;
?>

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
    $sesion =  session('usuario');
    $id_puesto=session('usuario')->id_puesto;
    $id_nivel=session('usuario')->id_nivel;
    $centro_labores=session('usuario')->centro_labores;
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Reporte de Proveedores</h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layou<t-spacing">
                <div class="widget-content widget-content-area br-6 p-3">
                    <div class="toolbar">    
                        <div class="row">
                            <input type="hidden" id="puesto" name="puesto" value="<?php echo $id_puesto ?>">
                            <?php if($id_nivel==1 || 
                            $id_puesto==23 || 
                            $id_puesto==24 || 
                            $id_puesto==158 || 
                            $id_puesto==209){?>
                                <div class="col-md-2 form-group">
                                    <label class="control-label text-bold">Bases:</label>
                                    <select id="base" name="base" placeholder="Centro de labores" data-placeholder="Your Favorite Type of Bear" tabindex="10" class="form-control chosen-select-deselect">
                                    <option value="0">Todas</option>
                                    <?php foreach($list_base as $list){ ?>
                                        <option value="<?php echo $list['cod_base']?>"> <?php echo $list['cod_base'];?> </option>
                                    <?php } ?>
                                    </select>
                                </div>
                            <?php }?>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label class="control-label text-bold">Estado:</label>
                                    <select id="estado_interno" name="estado_interno" class="form-control" >
                                        <option value="1">Programado</option>
                                        <option value="2">No Programado</option>
                                        <option selected value="3">Todos</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label text-bold">Fecha Inicio:</label>
                                        <input type="date" class="form-control formcontrolarlimpiar" id="fecha_inicio" value="<?php echo date("Y-m-d");?>"  name="fecha_inicio" > 
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label class="control-label text-bold">Fecha Fin:</label>
                                        <input type="date" class="form-control formcontrolarlimpiar" id="fecha_fin" value="<?php echo date("Y-m-d");?>"  name="fecha_fin" > 
                                </div>
                            </div>
                            <div class="form-group col-md-1">
                                <label class="control-label text-bold">&nbsp;</label>
                                <button type="button" id="busqueda_papeleta_seguridad" class="btn btn-primary mb-2 mr-2 form-control" onclick="Buscar_RProveedor();" title="Buscar">
                                    Buscar
                                </button>
                            </div>
                            <?php if($id_nivel==1 || 
                            $id_puesto==23 || 
                            $id_puesto==158 || 
                            $id_puesto==209){?> 
                                <div class="form-group col-md-1">
                                    <label class="control-label text-bold">&nbsp;</label>
                                    <a class="btn mb-2 mr-2" style="background-color: #28a745 !important;" onclick="Excel_RProveedor()">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path></g></g></svg>                                
                                    </a>
                                </div>
                            <?php }?>
                            
                        </div>
                    </div>
                    @csrf
                    <div class="table-responsive mb-4 mt-4" id="lista_rproveedor">
                    </div>
                </div>
            </div>           
        </div>
    </div>
</div>


<script>
 
    $(document).ready(function() {
        $("#seguridades").addClass('active');
        $("#lrproveedor").attr('aria-expanded','true');
        $("#hlrproveedor").addClass('active');

        ListarRProveedores();
    });

    $('#estado_solicitud').change(function(){
        var data= $(this).val();            
    });

    $('#estado_solicitud').val('4').trigger('change');    
</script>

<script>

    var url = "{{ url('RProveedores/Buscar_RProveedor') }}";

    function ListarRProveedores(){
        var csrfToken = $('input[name="_token"]').val();
        $.ajax({
            type:"POST",
            url:url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (data) {
                $('#lista_rproveedor').html(data);
            }
        }); 
    }

    function Update_Hora_RProveedor(id, tipo) {
        Cargando();

        var id = id;
        var tipo = tipo;
        if(tipo==1){
            text="hora real de llegada?";
        }if(tipo==2){
            text="hora ingreso a instalaciones?";
        }if(tipo==3){
            text="hora de descarga de mercadería?";
        }if(tipo==4){
            text="hora de salida?";
        }
        var csrfToken = $('input[name="_token"]').val();
        var url = "{{ url('RProveedores/Actualizar_Hora_RProveedor') }}";
        Swal({
            title: '¿Realmente desea actualizar '+text,
            text: "",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    data: {
                        'id_calendario': id,
                        'tipo': tipo
                    },
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            'Actualizado!',
                            'El registro ha sido actualizado exitosamente.',
                            'success'
                        ).then(function() {
                            Buscar_RProveedor();
                        });
                    }
                });
            }
        })
    }

    function Buscar_RProveedor() {
        Cargando();
        var puesto = $('#puesto').val();
        if(puesto==36){
            var base = 0;
        }else{
            var base = $('#base').val();
        }
        
        var estado_interno = $('#estado_interno').val();
        //var id_area = $('#id_area').val();
        var fecha_inicio = $('#fecha_inicio').val().trim();
        var fecha_fin = $('#fecha_fin').val().trim();
        var url = "{{ url('RProveedores/Buscar_RProveedor') }}";
        var ini = moment(fecha_inicio);
        var fin = moment(fecha_fin);
        var csrfToken = $('input[name="_token"]').val();

        if (ini.isAfter(fin) == true) {
            msgDate = 'La Fecha de Inicio no debe ser mayor a la de Fecha de Fin. <br> Por favor corrígelo. ';
            inputFocus = '#fecha_inicio';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        } else if (fecha_inicio != '' && fecha_fin === '') {
            msgDate = 'Si va buscar por rango de fechas porfavor ponga la fecha final también  ';
            inputFocus = '#fecha_inicio';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });

        } else if (fecha_inicio === '' && fecha_fin != '') {
            msgDate = 'Si va buscar por rango de fechas por favor ponga la fecha inicial también  ';
            inputFocus = '#fecha_inicio';
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
                    'estado_interno': estado_interno,
                    'fecha_inicio': fecha_inicio,
                    'fecha_fin': fecha_fin
                },
                success: function(data) {
                    $('#lista_rproveedor').html(data);
                }
            });
        }

    }

    function Excel_RProveedor() {
        var base = $('#base').val();
        var estado_interno = $('#estado_interno').val();
        //var id_area = $('#id_area').val();
        var fecha_inicio = $('#fecha_inicio').val().trim();
        var fecha_fin = $('#fecha_fin').val().trim();
        var url = "{{ url('RProveedores/Excel_RProveedor') }}";
        var ini = moment(fecha_inicio);
        var fin = moment(fecha_fin);

        if (ini.isAfter(fin) == true) {
            msgDate = 'La Fecha de Inicio no debe ser mayor a la de Fecha de Fin. <br> Por favor corrígelo. ';
            inputFocus = '#fecha_inicio';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        } else if (fecha_inicio != '' && fecha_fin === '') {
            msgDate = 'Si va buscar por rango de fechas porfavor ponga la fecha final también  ';
            inputFocus = '#fecha_inicio';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });

        } else if (fecha_inicio === '' && fecha_fin != '') {
            msgDate = 'Si va buscar por rango de fechas por favor ponga la fecha inicial también  ';
            inputFocus = '#fecha_inicio';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        } else {
            var csrfToken = $('input[name="_token"]').val();
            $.ajax({
                type: "GET",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
            });
            window.location = "<?php echo url('RProveedores/Excel_RProveedor'); ?>" + "/" + base + "/" + estado_interno + "/" + fecha_inicio + "/" + fecha_fin;
        }

    }
</script>

@endsection