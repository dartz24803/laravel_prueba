@extends('layouts.plantilla')

@section('content')
<?php
    $id_nivel = session('usuario')->id_nivel;
    $id_puesto = session('usuario')->id_puesto;
    $centro_labores = session('usuario')->centro_labores;
?>

<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Modulo de Tickets</h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <?php if($id_nivel==1 || $id_puesto==27 || $id_puesto==148){ ?>
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6 p-3">
                        <div class="col-md-12 row">
                            <div class="col-md-4 row">
                                <div class="col-md-12">
                                    <label>Estado</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="checkbox" id="cpiniciar" checked name="cpiniciar" value="1" onchange="Cambiar_Tickets_Admin()">
                                    <label for="cpiniciar" style="font-weight:normal">Por Iniciar</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="checkbox" id="cproceso" checked name="cproceso" value="2" onchange="Cambiar_Tickets_Admin()">
                                    <label for="cproceso" style="font-weight:normal">En Proceso</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="checkbox" id="cfinalizado" name="cfinalizado" value="3" onchange="Cambiar_Tickets_Admin()">
                                    <label for="cfinalizado" style="font-weight:normal">Completado</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="checkbox" id="cstandby" name="cstandby" value="4" onchange="Cambiar_Tickets_Admin()">
                                    <label for="cstandby" style="font-weight:normal">Stand by</label>
                                </div>
                            </div>

                            <?php if($id_nivel==1){ ?>
                                <div class="form-group col-md-2">
                                    <label>Plataforma</label>
                                    <select class="form-control" id="busq_plataforma" name="busq_plataforma" onchange="Cambiar_Tickets_Admin()">
                                        <option value="0" selected>Todos</option>
                                        <?php foreach($list_plataforma as $list){ ?>
                                            <option value="<?php echo $list['id_plataforma']; ?>">
                                                <?php echo $list['nom_plataforma'];?>
                                            </option>
                                        <?php } ?>
                                    </select>
                                </div>
                            <?php }else{ ?>
                                <div class="form-group col-md-2">
                                    <label>Plataforma</label>
                                    <select class="form-control" id="busq_plataforma" name="busq_plataforma" onchange="Cambiar_Tickets_Admin()">
                                        <?php foreach($list_plataforma as $list){ if($list['id_plataforma']==3 ||
                                            $list['id_plataforma']==2){?>
                                            <option value="<?php echo $list['id_plataforma']; ?>">
                                                <?php echo $list['nom_plataforma'];?>
                                            </option>
                                        <?php } } ?>
                                    </select>
                                </div>
                            <?php } ?>

                            <div class="form-group col-md-1.5">
                                <label>Base</label>
                                <select class="form-control" id="busq_base" name="busq_base" onchange="Cambiar_Tickets_Admin()">
                                    <option value="0" selected>Todos</option>
                                    <?php foreach($list_base as $list){ ?>
                                        <option value="<?php echo $list['cod_base'] ; ?>"><?php echo $list['cod_base'];?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Area</label>
                                <select class="form-control" id="busq_area" name="busq_area" onchange="Cambiar_Tickets_Admin()">
                                    <option value="0" selected>Todos</option>
                                    <?php foreach($list_area as $list){ ?>
                                        <option value="<?php echo $list->id_area ; ?>">
                                            <?php echo $list->nom_area;?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-1.5" style="margin-top: 10px;">
                                <button type="button" class="btn btn-primary mb-2 mr-2 mt-4" title="Nuevo Ticket" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('Tickets/Modal_Tickets') }}" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                    Nuevo Ticket
                                </button>
                            </div>

                            <div class="form-group col-md-1">
                                <label class="control-label text-bold" style="color:transparent;">Invisible</label>
                                <a class="btn" style="background-color: #28a745 !important;" onclick="Excel_Tickets_Admin();">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path></g></g></svg>
                                </a>
                            </div>
                        </div>

                        <div id="lista_tickets_admin" class="table-responsive mb-4 mt-4">
                        </div>
                    </div>
                </div>
            <?php }else{ ?>
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="col-md-12 row">
                            <div class="form-group col-md-2">
                                <label>Estado</label>
                                <div >
                                    <input type="checkbox" id="cpiniciar" checked name="cpiniciar" value="1" onchange="Cambiar_Tickets()">
                                    <span style="font-weight:normal"><?php echo "Por Iniciar"; ?></span>

                                    <input type="checkbox" id="cproceso" checked name="cproceso" value="2" onchange="Cambiar_Tickets()">
                                    <span style="font-weight:normal"><?php echo "En Proceso"; ?></span><br>

                                    <input type="checkbox" id="cfinalizado" name="cfinalizado" value="3" onchange="Cambiar_Tickets()">
                                    <span style="font-weight:normal"><?php echo "Completado"; ?></span>

                                    <input type="checkbox" id="cstandby" name="cstandby" value="4" onchange="Cambiar_Tickets()">
                                    <span style="font-weight:normal"><?php echo "Stand by"; ?></span>
                                </div>
                            </div>

                            <div class="form-group col-md-2">
                                <label>Plataforma</label>
                                <select class="form-control" id="busq_plataforma" name="busq_plataforma" onchange="Cambiar_Tickets()">
                                    <option value="0" selected>Todos</option>
                                    <?php foreach($list_plataforma as $list){ ?>
                                        <option value="<?php echo $list['id_plataforma']; ?>">
                                            <?php echo $list['nom_plataforma'];?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="form-group col-md-1.5" style="margin-top: 10px;">
                                <button type="button" class="btn btn-primary mb-2 mr-2 mt-4" title="Nuevo Ticket" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ url('Tickets/Modal_Tickets') }}" >
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                    Nuevo Ticket
                                </button>
                            </div>

                            <div class="form-group col-md-1">
                                <label class="control-label text-bold" style="color:transparent;">Invisible</label>
                                <a class="btn mb-2 mr-2" style="background-color: #28a745 !important;" onclick="Excel_Tickets_Usuario()">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path></g></g></svg>
                                </a>
                            </div>
                        </div>

                        <div id="lista_tickets" class="table-responsive mb-4 mt-4">
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#tickets").addClass('active');
        $("#htickets").attr('aria-expanded','true');

        var nivel = "<?php echo $id_nivel; ?>";
        var puesto = "<?php echo $id_puesto; ?>";

        if(nivel==1 || puesto==27 || puesto==148){
            Cambiar_Tickets_Admin();
        }else{
            Cambiar_Tickets();
        }
    });

    function Cambiar_Tickets_Admin(){
        Cargando();

        var plataforma = $('#busq_plataforma').val();
        var base = $('#busq_base').val();
        var area = $('#busq_area').val();
        if ($('#cpiniciar').is(":checked")){
            var cpiniciar=1;
        }else{
            var cpiniciar=0;
        }
        if ($('#cproceso').is(":checked")){
            var cproceso=1;
        }else{
            var cproceso=0;
        }
        if ($('#cfinalizado').is(":checked")){
            var cfinalizado=1;
        }else{
            var cfinalizado=0;
        }
        if ($('#cstandby').is(":checked")){
            var cstandby=1;
        }else{
            var cstandby=0;
        }

        var url = "{{ url('Tickets/Busqueda_Tickets_Admin') }}/"+plataforma+"/"+base+"/"+area+"/"+cpiniciar+"/"+cproceso+"/"+cfinalizado+"/"+cstandby;

        $.ajax({
            url: url,
            type: 'GET',
            success: function(data){
                $('#lista_tickets_admin').html(data);
            }
        });
    }

    function Mostrar_Vence_Ticket(id_pendiente){
        var div = document.getElementById("span_vence_"+id_pendiente);
        div.style.display = "none";
        var div = document.getElementById("f_fin_"+id_pendiente);
        div.style.display = "block";
    }

    function Update_Vence_Ticket(id){
        Cargando();

        var f_fin = $('#f_fin_'+id).val();
        var url = "{{ url('Ticket/Update_Vence_Ticket') }}";

        $.ajax({
            url: url,
            type: 'POST',
            data: {'id_tickets':id,'f_fin':f_fin},
            success: function(data){
                Cambiar_Tickets_Admin();
            }
        });
    }

    function Cambiar_Tickets(){
        Cargando();

        var plataforma = $('#busq_plataforma').val();
        if ($('#cpiniciar').is(":checked")){
            var cpiniciar=1;
        }else{
            var cpiniciar=0;
        }
        if ($('#cproceso').is(":checked")){
            var cproceso=1;
        }else{
            var cproceso=0;
        }
        if ($('#cfinalizado').is(":checked")){
            var cfinalizado=1;
        }else{
            var cfinalizado=0;
        }
        if ($('#cstandby').is(":checked")){
            var cstandby=1;
        }else{
            var cstandby=0;
        }

        var url = "{{ url('Tickets/Busqueda_Tickets') }}/"+plataforma+"/"+cpiniciar+"/"+cproceso+"/"+cfinalizado+"/"+cstandby;

        $.ajax({
            url: url,
            type: 'GET',
            success: function(data){
                $('#lista_tickets').html(data);
            }
        });
    }

    function Delete_Tickets(id) {
        Cargando();

        var url = "{{ url('Tickets/Delete_Tickets_Vista') }}";

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
                    data: {'id_tickets': id},
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            var nivel = "<?php echo $id_nivel; ?>";
                            var puesto = "<?php echo $id_puesto; ?>";

                            if(nivel==1 || puesto==27 || puesto==148){
                                Cambiar_Tickets_Admin();
                            }else{
                                Cambiar_Tickets();
                            }
                        });
                    }
                });
            }
        })
    }

    function Excel_Tickets_Admin(){
        var plataforma = $('#busq_plataforma').val();
        var base = $('#busq_base').val();
        var area = $('#busq_area').val();
        if ($('#cpiniciar').is(":checked")){
            var cpiniciar=1;
        }else{
            var cpiniciar=0;
        }
        if ($('#cproceso').is(":checked")){
            var cproceso=1;
        }else{
            var cproceso=0;
        }
        if ($('#cfinalizado').is(":checked")){
            var cfinalizado=1;
        }else{
            var cfinalizado=0;
        }
        if ($('#cstandby').is(":checked")){
            var cstandby=1;
        }else{
            var cstandby=0;
        }
        window.location = "{{ url('Tickets/Excel_Tickets_Admin') }}/"+plataforma+"/"+base+"/"+area+"/"+cpiniciar+"/"+cproceso+"/"+cfinalizado+"/"+cstandby;
    }

    function Excel_Tickets_Usuario(){
        var plataforma = $('#busq_plataforma').val();
        if ($('#cpiniciar').is(":checked")){
            var cpiniciar=1;
        }else{
            var cpiniciar=0;
        }
        if ($('#cproceso').is(":checked")){
            var cproceso=1;
        }else{
            var cproceso=0;
        }
        if ($('#cfinalizado').is(":checked")){
            var cfinalizado=1;
        }else{
            var cfinalizado=0;
        }
        if ($('#cstandby').is(":checked")){
            var cstandby=1;
        }else{
            var cstandby=0;
        }
        window.location = " url('Ticket/Excel_Tickets_Usuario') }}/"+plataforma+"/"+cpiniciar+"/"+cproceso+"/"+cfinalizado+"/"+cstandby;
    }
</script>

@endsection
