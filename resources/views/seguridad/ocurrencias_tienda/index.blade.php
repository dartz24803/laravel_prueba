@extends('layouts.plantilla')

@section('navbar')
    @include('seguridad.navbar')
@endsection

@section('content')
<?php 
$id_puesto= session('usuario')->id_puesto;
$id_nivel= session('usuario')->id_nivel;
?>
<div id="content" class="main-content">
    <div class="layout-px-spacing"> 
        <div class="page-header">
            <div class="page-title">
                <h3>Reporte de Ocurrencias </h3>
            </div>
        </div>

        <?php if($id_nivel==1 || $id_puesto==23 || $id_puesto==24 || $id_puesto==26 || $id_puesto==36 || $id_puesto==315){ ?>
            <div class="row" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="toolbar m-4">
                            <div class="row">
                                <div class="form-group col-md-8">
                                </div> 

                                <div class="form-group col-md-1">
                                    <button type="button" class="btn btn-primary mb-2 mr-2 form-control" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="<?= url('OcurrenciaTienda/Modal_Ocurrencia_Tienda_Admin') ?>">
                                        Nuevo
                                    </button>
                                </div> 

                                {{-- <?php if($id_nivel==1 || $id_puesto==23 || $id_puesto==26){ ?>
                                    <div class="form-group col-md-2">
                                        <button type="button" class="btn btn-primary mb-2 mr-2" onclick="Confirmar_Revision()" <?php if($cantidad_revisadas==0){ echo "disabled"; } ?>>
                                            Confirmar revisión
                                        </button>
                                    </div> 
                                <?php } ?> --}}

                                <div class="form-group col-md-1">
                                    <a class="btn mb-2 mr-2" style="background-color: #28a745 !important;" onclick="Excel_Ocurrencia();">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path></g></g></svg>                                
                                    </a>
                                </div>    
                            </div>

                            <div class="row">    
                                <div class="form-group col-md-1">
                                    <label>Base</label>
                                    <select class="form-control" id="base_busq" name="base_busq" onchange="Traer_Tipo_Ocurrencia_Busq();">
                                        <option value="Todo">Todos</option>
                                        <?php foreach($list_base as $list){ ?>
                                            <option value="<?php echo $list['cod_base']; ?>"><?php echo $list['cod_base']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-2">
                                    <label>Fecha Inicio</label>
                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio" value="<?php echo date('Y-m-d'); ?>">
                                </div>

                                <div class="form-group col-md-2">
                                    <label>Fecha Fin</label>
                                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin" value="<?php echo date('Y-m-d'); ?>">
                                </div>

                                <div id="div_tipo_ocurrencia" class="form-group col-md-3">
                                    <label>Tipo Ocurrencia</label>
                                    <select class="form-control basic" id="tipo_ocurrencia_busq" name="tipo_ocurrencia_busq">
                                        <option value="Todo">Todos</option>
                                        <?php foreach($list_tipo_ocurrencia as $list){ ?>
                                            <option value="<?php echo $list->id_tipo_ocurrencia; ?>"><?php echo $list->nom_tipo_ocurrencia; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Colaborador</label>
                                    <select class="form-control basic" id="colaborador_busq" name="colaborador_busq">
                                        <option value="Todo">Todos</option>
                                        <?php foreach($list_colaborador as $list){ ?>
                                            <option value="<?php echo $list['id_colaborador']; ?>"><?php echo $list['nom_colaborador']; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>

                                <div class="form-group col-md-1">
                                    <label class="control-label text-bold">&nbsp;</label>
                                    <button type="button" id="busqueda_papeleta_gestion" class="btn btn-primary mb-2 mr-2 form-control" onclick="Cambiar_Ocurrencia_Admin();" title="Buscar">
                                        Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                        @csrf
                        <div id="lista_ocurrencia" class="table-responsive mb-4 mt-4">
                        </div>
                    </div>
                </div>
            </div>
        <?php }else{ ?>
            <div class="row" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="toolbar">
                            <div class="row">    
                                <div class="form-group col-md-2">
                                    <label class="control-label text-bold">&nbsp;</label>
                                    <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg_metalikas="<?= url('Corporacion/Modal_Ocurrencia_Tienda') ?>">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                    Registrar
                                    </button> 
                                </div>      
                                
                                <?php if($id_puesto==29 || $id_puesto==161 || $id_puesto==197){ ?>
                                    <div class="form-group col-md-2">
                                        <button type="button" class="btn btn-primary mb-2 mr-2" onclick="Confirmar_Revision()" <?php if($cantidad_revisadas==0){ echo "disabled"; } ?>>
                                            Confirmar revisión
                                        </button>
                                    </div> 
                                <?php } ?>
                            </div>
                        </div>
                        @csrf
                        <div class="table-responsive mb-4 mt-4" id="lista_ocurrencia">
                            <table id="zero-config" class="table table-hover" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Código</th>
                                        <th>Ocurrencia</th>
                                        <th>Conclusión</th>
                                        <th>Gestión</th>
                                        <th>Base</th>
                                        <th>Cantidad</th>
                                        <th>Monto Total</th>
                                        <th>Descripción</th>
                                        <th>Revisado</th>
                                        <th class="no-content"></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach($list_ocurrencia_usu as $list) {  ?>                                           
                                        <tr>
                                            <td><?php echo $list['cod_ocurrencia']; ?></td>
                                            <td><?php echo $list['nom_tipo_ocurrencia']; ?></td>
                                            <td><?php echo $list['nom_conclusion']; ?></td>
                                            <td><?php echo $list['nom_gestion']; ?></td>
                                            <td><?php echo $list['cod_base']; ?></td>
                                            <td><?php echo $list['cantidad']; ?></td>
                                            <td><?php echo "S/. ".$list['monto']; ?></td>
                                            <td><?php echo $list['descripcion']; ?></td>
                                            <td class="text-center"><?php echo $list['v_revisado']; ?></td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdate" app_elim="<?= url('Corporacion/Modal_Update_Ocurrencia_Tienda') ?>/<?php echo $list['id_ocurrencia']; ?>">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 text-success">
                                                    <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                                    </svg>
                                                </a>
                                                <a title="Eliminar" onclick="Delete_Ocurrencia_Tienda('<?php echo $list['id_ocurrencia']; ?>');">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg>
                                                </a>
                                            </td> 
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#seguridades").addClass('active');
        $("#rseguridades").attr('aria-expanded','true');
        $("#hlocurrencia").addClass('active');

        <?php if(session('usuario')->id_nivel==1 || session('usuario')->id_puesto==23 || 
        session('usuario')->id_puesto==24 || session('usuario')->id_puesto==26 || session('usuario')->id_puesto==36 || session('usuario')->id_puesto===315){ ?>
            Cambiar_Ocurrencia_Admin();
        <?php } ?>
    });
/*
    var ss = $(".basic").select2({
        tags: true,
    });
*/
    function Traer_Tipo_Ocurrencia_Busq(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var cod_base = $('#base_busq').val();
        var url="<?php echo url('Corporacion/Traer_Tipo_Ocurrencia_Busq') ?>";

        $.ajax({
            type:"POST",
            url:url,
            data:{'cod_base':cod_base},
            success:function (data) {
                $('#div_tipo_ocurrencia').html(data); 
            }
        });  
    }

    function Cambiar_Ocurrencia_Admin(){
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var cod_base = $('#base_busq').val();
        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var tipo_ocurrencia = $('#tipo_ocurrencia_busq').val();
        var colaborador = $('#colaborador_busq').val();
        var csrfToken = $('input[name="_token"]').val();

        var url = "{{ url('OcurrenciaTienda/ListaOcurrencia') }}/" + cod_base + "/" + fecha_inicio + "/" + fecha_fin + "/" + tipo_ocurrencia + "/" + colaborador;

        $.ajax({
            type:"POST",
            url:url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (data) {
                $('#lista_ocurrencia').html(data);
            }
        });  
    }

    function Confirmar_Revision(id) {
        Cargando();
        var url = "{{ url('OcurrenciaTienda/Confirmar_Revision_Ocurrencia') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea confirmar el registro?',
            text: "El registro será confirmado",
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
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {
                        'id': id
                    },
                    success: function() {
                        Swal(
                            'Confirmación Exitosa',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Cambiar_Ocurrencia_Admin(); // Ejecuta la función después de la confirmación
                        });
                    },
                });
            }
        })
    }


    function Delete_Ocurrencia_Tienda(id) {
        $(document)
        .ajaxStart(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        })
        .ajaxStop(function () {
            $.blockUI({
                message: '<svg> ... </svg>',
                fadeIn: 800,
                timeout: 100,
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    zIndex: 1200,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    zIndex: 1201,
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        });

        var url = "{{ url('OcurrenciaTienda/DeleteOcurrencia') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
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
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {'id_ocurrencia': id},
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            <?php if(session('usuario')->id_nivel==1 || session('usuario')->id_puesto==23 || 
                            session('usuario')->id_puesto==24 || session('usuario')->id_puesto==26){ ?>
                                Cambiar_Ocurrencia_Admin();
                            <?php }else{ ?>
                                window.location = "<?php echo url('Corporacion/Ocurrencia_Tienda')?>";
                            <?php } ?>
                        });
                    }
                });
            }
        })
    }

    function Excel_Ocurrencia() {
        var cod_base = $('#base_busq').val();
        var fecha_inicio = $('#fecha_inicio').val().split("-");
        var fecha_inicio = fecha_inicio[0]+fecha_inicio[1]+fecha_inicio[2];
        var fecha_fin = $('#fecha_fin').val().split("-");
        var fecha_fin = fecha_fin[0]+fecha_fin[1]+fecha_fin[2];
        var tipo_ocurrencia = $('#tipo_ocurrencia_busq').val();
        var colaborador = $('#colaborador_busq').val();
        window.location = "{{ url('Corporacion/Excel_Ocurrencia') }}/" + cod_base + "/" + fecha_inicio + "/" + fecha_fin + "/" + tipo_ocurrencia + "/" + colaborador;
    }
</script>

@endsection