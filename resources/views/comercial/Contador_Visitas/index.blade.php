@extends('layouts.plantilla')

@section('navbar')
@include('comercial.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">

        <div class="page-header">
            <div class="page-title">
                <h3>Contador de Visitas</h3>
            </div>
        </div>

        <div class="row" id="cancel-row">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6 p-3">
                    <div class="toolbar">
                        <form id="formulario" class="control">
                            <div class="col-md-12 row">
                                <div class="form-group col-md-2">
                                    <label class="control-label text-bold">Base</label>
                                    <select id="cod_basei" name="cod_basei" class="form-control">
                                        <option value="0" >TODOS</option>
                                        <?php foreach($list_base as $list){?>
                                            <option value="<?php echo $list['cod_tienda']; ?>"> <?php echo $list['cod_base'];?> </option>
                                        <?php } ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label text-bold">Inicio</label>
                                    <input type="date" name="inicioi" id="inicioi" class="form-control" value="<?php echo date('Y-m-d')?>">
                                </div>
                                <div class="form-group col-md-2">
                                    <label class="control-label text-bold">Fin</label>
                                    <input type="date" name="fini" id="fini" class="form-control" value="<?php echo date('Y-m-d')?>">
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="control-label text-bold">&nbsp;</label>
                                    <button type="button" class="btn btn-primary mb-2 mr-2 form-control" title="Registrar" onclick="Visualizar_Contador_Visitas('1')" >
                                        Visualizar
                                    </button>
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="control-label text-bold">&nbsp;</label>
                                    <button type="button" class="btn btn-primary mb-2 mr-2 form-control" title="Registrar" onclick="Visualizar_Contador_Visitas('2')" >
                                        Ejecutar
                                    </button>
                                </div>
                                <div class="form-group col-md-1">
                                    <label class="control-label text-bold">&nbsp;</label>
                                    <button class="btn btn-primary mb-2 mr-2 form-control" type="button" onclick="Visualizar_Contador_Visitas('3');" style="background-color: #28a745!important;border-color:#28a745!important">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path></g></g></svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @csrf
                    <div class="table-responsive mb-4 mt-4" id="lista_busqueda">
                        <table id="zero-config" class="table table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Cod Tienda</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Entradas</th>
                                    <th>Salidas</th>
                                </tr>
                            </thead>
                            <tbody>
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
        $("#comercial").addClass('active');
        $("#hcomercial").attr('aria-expanded','true');
        $("#rvisitas").addClass('active');
    });
    function Visualizar_Contador_Visitas(t) {
        Cargando();
        var url = "{{ url('ContadorVisitas/Visualizar_Insert_Contador_Visitas') }}";
        var inicio=$('#inicioi').val();
        var fin=$('#fini').val();
        var cod_base=$('#cod_basei').val();
        var csrfToken = $('input[name="_token"]').val();

        if (Valida_Contador_Visitas()) {
            if(t==3){
                window.location = "{{ url('ContadorVisitas/Excel_Contador_Visitas') }}/"+inicio+"/"+fin+"/"+cod_base;
            }else{
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {'inicio':inicio,'fin':fin,'tipo':t,'cod_base':cod_base},
                    success: function(data) {
                        if(t==1){
                            $('#lista_busqueda').html(data);
                        }else{
                            swal.fire(
                                'Registro Exitoso!',
                                '',
                                'success'
                            ).then(function() {

                            });
                        }

                    }
                });
            }

        }
    }

    function Valida_Contador_Visitas() {
        const today = new Date();
        const year = today.getFullYear();
        const month = today.getMonth() + 1;
        const day = today.getDate();

        const formattedDate = `${year}-${month.toString().padStart(2, '0')}-${day.toString().padStart(2, '0')}`;

        if ($('#inicioi').val() === '') {
            msgDate = 'Debe ingresar fecha de inicio.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#fini').val() === '') {
            msgDate = 'Debe ingresar fecha de fin.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#fini').val()>formattedDate) {
            msgDate = 'Fecha fin no debe ser después de hoy.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#fini').val()<$('#inicioi').val()) {
            msgDate = 'Fecha fin debe ser igual o despues que la fecha de inicio.';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }
        const date1 = new Date($('#inicioi').val());
        const date2 = new Date($('#fini').val());

        const diffInMs = Math.abs(date2 - date1);
        const diffInDays = Math.ceil(diffInMs / (1000 * 60 * 60 * 24));
        if(diffInDays>7){
            msgDate = 'Rango no permitido, máximo 7 días';
            Swal(
                'Ups!',
                msgDate,
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

</script>
@endsection
