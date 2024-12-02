@extends('layouts.plantilla')

@section('navbar')
@endsection

@section('content')
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
        <div class="page-header">
            <div class="page-title">
                <h3>Registro de Papeletas</h3>
            </div>
        </div>
            <div class="row" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6 p-3">
                        <div class="toolbar">
                            <div class="row align-items-center">
                                <div class="col-md-5 col-lg-3">
                                    <label class="control-label text-bold">Estado Solicitud:</label>
                                    <select id="estado_solicitud" name="estado_solicitud" class="form-control" onchange="Busca_Registro_Papeleta()">
                                        <option value="0">Todos</option>
                                        <option value="1" selected>En Proceso de aprobacion</option>
                                        <option value="2">Aprobados</option>
                                        <option value="3">Denegados</option>
                                    </select>
                                </div>

                                <div class="col-md-2">
                                    <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistroGrande" app_reg_grande="{{ url('Papeletas/Modal_Papeletas_Salida/0') }}" >
                                        Registrar
                                    </button>
                                </div>

                                <?php if($registro_masivo == 1 || $id_nivel==1 || $id_puesto==314) {  ?>
                                    <div class="col-md-4 col-lg-3">
                                        <button type="button" class="btn btn-primary" title="Registrar Masivo" data-toggle="modal" data-target="#ModalRegistroGrande" app_reg_grande="{{ url('Papeletas/Modal_Papeletas_Salida/1') }}" >
                                            Registro Masivo
                                        </button>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        @csrf
                        <div class="table-responsive mb-4 mt-4" id="lista_colaborador" style="max-width:100%; overflow:auto;">
                            <table id="zero-config" class="table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Motivo</th>
                                        <th>Destino</th>
                                        <th>Trámite</th>
                                        <th><div align="center">Fecha</div></th>
                                        <th><div align="center">H. Salida</div></th>
                                        <th><div align="center">H. Retorno</div></th>
                                        <th><div align="center">Estado</div></th>
                                        <?php if($ultima_papeleta_salida_todo > 0) {  ?><th class="no-content"></th><?php } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($list_papeletas_salida as $list) {  ?>
                                    <tr>
                                        <td>
                                            <?php
                                                if( $list['id_motivo']==1){
                                                    echo "Laboral";
                                                }else if ($list['id_motivo']==2){
                                                    echo "Personal";
                                                }else{
                                                    echo $list['motivo'];
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php echo $list['destino']; ?>
                                        </td>
                                        <td>
                                            <?php echo $list['tramite']; ?>
                                        </td>
                                        <td align="center">
                                            <?php
                                                echo date_format(date_create($list['fec_solicitud']), "d/m/Y");
                                            ?>
                                        </td>
                                        <td align="center">
                                            <?php
                                                if($list['sin_ingreso'] == 1 ){
                                                    echo "Sin Ingreso";
                                                }else{
                                                    echo $list['hora_salida'];
                                                }
                                            ?>
                                        </td>
                                        <td align="center">
                                            <?php
                                                if($list['sin_retorno'] == 1 ){
                                                    echo "Sin Retorno";
                                                }else{
                                                    echo $list['hora_retorno'];
                                                }
                                            ?>
                                        </td>
                                        <td align="center">
                                            <?php
                                                if( $list['estado_solicitud']=='1'){
                                                    echo "<span class='shadow-none badge badge-warning'>En proceso</span>";
                                                }else if ($list['estado_solicitud']=='2'){
                                                    echo "<span class='shadow-none badge badge-primary'>Aprobado</span>";
                                                }else if ($list['estado_solicitud']=='3'){
                                                    echo " <span class='shadow-none badge badge-danger'>Denegado</span>";
                                                }else if ($list['estado_solicitud']=='4'){
                                                    echo "<span class='shadow-none badge badge-warning'>En proceso - Aprobación Gerencia</span>";
                                                }else if($list['estado_solicitud']=='5') {
                                                    echo "<span class='shadow-none badge badge-warning'>En proceso - Aprobación RRHH</span>";
                                                }else{
                                                    echo "<span class='shadow-none badge badge-primary'>Error</span>";
                                                }
                                            ?>
                                        </td>
                                        <?php if( $ultima_papeleta_salida_todo > 0){ ?>
                                            <td class="text-center">
                                                <?php if( $list['estado_solicitud']=='1'){ ?>
                                                    <!--<a href="javascript:void(0);" title="Editar" data-toggle="modal" data-target="#ModalUpdateSlide" app_upd_slide="{{ url('Papeletas/Modal_Update_Papeletas_Salida/'. $list["id_solicitudes_user"]) }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 p-1 br-6 mb-1"><path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path></svg>
                                                    </a>-->
                                                    <a href="#" class="" title="Eliminar" onclick="Delete_Papeletas_Salida('<?php echo $list['id_solicitudes_user']; ?>')" id="Eliminar" role="button">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                                                            <polyline points="3 6 5 6 21 6"></polyline>
                                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                            <line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line>
                                                        </svg>
                                                    </a>
                                                <?php }else{?>
                                                    <a title="No puedes editar" class="anchor-tooltip tooltiped"><div class="divdea">
                                                    <svg id="Layer_1" width="13" height="13" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 128 128"><defs><style>.cls-1{fill:#2d3e50;}</style></defs><title>n</title><path class="cls-1" d="M86.15787,99.25657c-3.54161,2.827-10.03158,6.41724-14.75995,6.08384-4.67736-.3298-3.78182-4.78987-2.85481-8.295l7.83763-29.63476a13.29171,13.29171,0,0,0-25.68221-6.86278C49.55418,64.7858,40.39666,102.57942,40.34023,102.816c-1.28065,5.36943-2.81226,12.2324-.45115,17.525,3.58188,8.02819,14.46035,5.69646,21.06968,3.78541a52.68574,52.68574,0,0,0,12.91952-5.64322,118.52775,118.52775,0,0,0,13.15678-10.41187Z"/><path class="cls-1" d="M74.55393,2.049c-9.8517-.61753-19.65075,8.23893-20.034,18.3877a15.14774,15.14774,0,0,0,2.23531,8.54311c6.11649,9.89677,20.16846,7.7415,27.76526.91074C94.54734,20.87483,87.832,2.88134,74.55393,2.049Z"/></svg>
                                                    </div></a>
                                                <?php } ?>
                                            </td>
                                        <?php } ?>
                                    </tr>
                                <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        $("#papeletas_apps").addClass('active');
        $("#hpapeletas_apps").attr('aria-expanded','true');
        $("#apps_papeletas").addClass('active');
    });

    $(document).ready(function() {
        document.title = 'Papeletas Registro';
                $('#zero-config').DataTable({
                "dom": "<'dt--top-section'<'row'<'col-12 col-sm-6 d-flex justify-content-sm-start justify-content-center'l><'col-12 col-sm-6 d-flex justify-content-sm-end justify-content-center mt-sm-0 mt-3'f>>>" +
                "<'table-responsive'tr>" +
                "<'dt--bottom-section d-sm-flex justify-content-sm-between text-center'<'dt--pages-count  mb-sm-0 mb-3'i><'dt--pagination'p>>",
                responsive: true,
                "oLanguage": {
                "oPaginate": { "sPrevious": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-left"><line x1="19" y1="12" x2="5" y2="12"></line><polyline points="12 19 5 12 12 5"></polyline></svg>', "sNext": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-right"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>' },
                "sInfo": "Mostrando página _PAGE_ de _PAGES_",
                "sSearch": '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>',
                "sSearchPlaceholder": "Buscar...",
                "sLengthMenu": "Resultados :  _MENU_",
                "sEmptyTable": "No hay datos disponibles en la tabla",
            },
                "stripeClasses": [],
                "lengthMenu": [10, 20, 50],
                "pageLength": 10
            });
    });

    function Delete_Papeletas_Salida(id) {
        Cargando();

        var id = id;
        var url = "{{ url('Papeletas/Delete_Papeletas_Salida') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
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
                        'id_solicitudes_user': id
                    },
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            $('#zero-config').DataTable().ajax.reload(null, false);
                        });
                    }
                });
            }
        })
    }

    function Busca_Registro_Papeleta(){
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
