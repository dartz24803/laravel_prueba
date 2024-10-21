@extends('layouts.plantilla')

@section('navbar')
@include('rrhh.navbar')
@endsection

@section('content')
<style>
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
</style>

<?php
    $id_nivel=session('usuario')->id_nivel;
    $desvinculacion=session('usuario')->desvinculacion;
    $estado=session('usuario')->estado;
    $id_puesto=session('usuario')->id_puesto;
    $id_cargo=session('usuario')->id_cargo;
    $usuario_codigo=session('usuario')->usuario_codigo;
    $centro_labores=session('usuario')->centro_labores;
    $estado=session('usuario')->estado;
    $acceso=session('usuario')->acceso;
    $induccion=session('usuario')->induccion;
    $puesto_array = session('list_puesto');
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Aprobación de Papeleta: <?php echo $get_id[0]['cod_solicitud']; ?></h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6">
                    <div class="table-responsive mb-4 mt-4">
                        <table id="style-3" class="table style-3 " style="width:100%">
                            <thead>
                                <tr class="text-center">
                                    <th>Colaborador</th>
                                    <th>Base/OFC</th>
                                    <th>Motivo</th>
                                    <th>Destino</th>
                                    <th>Trámite</th>
                                    <th>Fecha</th>
                                    <th>H. Salida</th>
                                    <th>H. Retorno</th>
                                    <th>H. Real Salida</th>
                                    <th>H. Real Retorno</th>
                                    <th>Estado</th>
                                    <th class="no-content"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="text-center">
                                    <td class="text-left"><?php echo $get_id[0]['nombres'] ?></td>
                                    <td><?php echo $get_id[0]['cod_base']; ?></td>
                                    <td class="text-left"><?php echo $get_id[0]['nom_motivo']; ?></td>
                                    <td class="text-left"><?php echo $get_id[0]['destino']; ?></td>
                                    <td class="text-left"><?php echo $get_id[0]['tramite']; ?></td>
                                    <td><?php echo date_format(date_create($get_id[0]['fec_solicitud']), "d/m/Y"); ?></td>
                                    <td>
                                        <?php
                                            if($get_id[0]['sin_ingreso'] == 1 ){
                                                echo "Sin Ingreso";
                                            }else{
                                                echo $get_id[0]['hora_salida'];
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if($get_id[0]['sin_retorno'] == 1 ){
                                                echo "Sin Retorno";
                                            }else{
                                                echo $get_id[0]['hora_retorno'];
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if( $get_id[0]['sin_ingreso']==1){
                                                echo "Sin Ingreso";
                                            }else{
                                                if($get_id[0]['horar_salida']!="00:00:00"){
                                                    echo $get_id[0]['horar_salida'];
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php
                                            if( $get_id[0]['sin_retorno']==1){
                                                echo "Sin Retorno";
                                            }else{
                                                if($get_id[0]['horar_retorno']!="00:00:00"){
                                                    echo $get_id[0]['horar_retorno'];
                                                }
                                            }
                                        ?>
                                    </td>
                                    <td class='text-center'>
                                        <?php
                                            if( $get_id[0]['estado_solicitud']=='1'){
                                                echo "<span class='shadow-none badge badge-warning'>En proceso</span>";
                                            }else if ($get_id[0]['estado_solicitud']=='2'){
                                                echo "<span class='shadow-none badge badge-primary'>Aprobado</span>";
                                            }else if ($get_id[0]['estado_solicitud']=='3'){
                                                echo " <span class='shadow-none badge badge-danger'>Denegado</span>";
                                            }else if ($get_id[0]['estado_solicitud']=='4'){
                                                echo " <span class='shadow-none badge badge-warning'>En proceso - Aprobación Gerencia</span>";
                                            }else if ($get_id[0]['estado_solicitud']=='5'){
                                                echo " <span class='shadow-none badge badge-warning'>En proceso - Aprobación RRHH</span>";
                                            }else{
                                                echo "<span class='shadow-none badge badge-primary'>Error</span>";
                                            }
                                        ?>
                                    </td>
                                    <td class="text-center">
                                        <?php if($get_id[0]['estado_solicitud']=='5' && ($id_puesto==19 || $id_puesto==21)){ ?>
                                            <a href="#" class="" title="Aprobar Papeleta" onclick="Aprobar_Solicitud('<?php echo $get_id[0]['id_solicitudes_user']; ?>');" id="Eliminar" role="button">
                                                <svg id="Layer_1" enable-background="new 0 0 512.063 512.063" height="24" viewBox="0 0 512.063 512.063" width="24" xmlns="http://www.w3.org/2000/svg"><g><g><ellipse cx="256.032" cy="256.032" fill="#00df76" rx="255.949" ry="256.032"/></g><path d="m256.032 0c-.116 0-.231.004-.347.004v512.055c.116 0 .231.004.347.004 141.357 0 255.949-114.629 255.949-256.032s-114.592-256.031-255.949-256.031z" fill="#00ab5e"/><path d="m111.326 261.118 103.524 103.524c4.515 4.515 11.836 4.515 16.351 0l169.957-169.957c4.515-4.515 4.515-11.836 0-16.351l-30.935-30.935c-4.515-4.515-11.836-4.515-16.351 0l-123.617 123.615c-4.515 4.515-11.836 4.515-16.351 0l-55.397-55.397c-4.426-4.426-11.571-4.526-16.119-.226l-30.83 29.149c-4.732 4.475-4.837 11.973-.232 16.578z" fill="#fff5f5"/><path d="m370.223 147.398c-4.515-4.515-11.836-4.515-16.351 0l-98.187 98.187v94.573l145.473-145.473c4.515-4.515 4.515-11.836 0-16.352z" fill="#dfebf1"/></g></svg>
                                            </a>
                                            <a href="#" class="" title="Desaprobar Papeleta" onclick="Anular_Solicitud('<?php echo $get_id[0]['id_solicitudes_user']; ?>')" id="Eliminar" role="button">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle table-cancel"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                                            </a>
                                        <?php } ?>
                                    </td>
                                </tr>
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
        $("#rhumanos").addClass('active');
        $("#hrhumanos").attr('aria-expanded','true');
    });

    function Aprobar_Solicitud(id) {
        Cargando();

        var url = "{{ url('Papeletas/Aprobar_Solicitud') }}";

        Swal({
            title: '¿Realmente desea aprobar la papeleta?',
            text: "La papeleta será aprobada",
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
                    data: {'id_solicitudes_user':id},
                    success: function(data) {
                        Swal(
                            'Aprobado!',
                            'La papeleta ha sido aprobada satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "{{ url('Corporacion/Lista_Papeletas_Salida_Gestion') }}";
                        });
                    }
                });
            }
        })
    }

    function Anular_Solicitud(id) {
        Cargando();

        var url = "{{ url('Corporacion/Anular_Solicitud') }}";

        Swal({
            title: '¿Realmente desea desaprobar esta Papeleta de Salida?',
            text: "El registro será desaprobado permanentemente",
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
                    data: {'id_solicitudes_user': id,},
                    success: function(data) {
                        Swal(
                            'Desaprobado!',
                            'La papeleta ha sido desaprobada satisfactoriamente.',
                            'success'
                        ).then(function() {
                            window.location = "{{ url('Corporacion/Lista_Papeletas_Salida_Gestion') }}";
                        });
                    }
                });
            }
        })
    }
</script>

@endsection
