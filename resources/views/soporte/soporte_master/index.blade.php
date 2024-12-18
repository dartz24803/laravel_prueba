@extends('layouts.plantilla')
@section('navbar')
@include($nominicio . '.navbar')
@endsection

@section('content')
<style>
    .toggle-switch {
        position: relative;
        display: inline-block;
        height: 24px;
        margin: 10px;
    }

    .toggle-switch .toggle-input {
        display: none;
    }

    .toggle-switch .toggle-label {
        position: absolute;
        top: 0;
        left: 0;
        width: 40px;
        height: 24px;
        background-color: gray;
        border-radius: 34px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .toggle-switch .toggle-label::before {
        content: "";
        position: absolute;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        top: 2px;
        left: 2px;
        background-color: #fff;
        box-shadow: 0px 2px 5px 0px rgba(0, 0, 0, 0.3);
        transition: transform 0.3s;
    }

    .toggle-switch .toggle-input:checked+.toggle-label {
        background-color: #4CAF50;
    }

    .toggle-switch .toggle-input:checked+.toggle-label::before {
        transform: translateX(16px);
    }
</style>
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Registro de Soporte Master
                </h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-2">
                    <div class="row align-items-center p-4">
                        <div class="col-md-6 col-lg-2">
                            <label>Estado</label>
                            <div>
                                <input type="checkbox" id="cpiniciar" checked name="cpiniciar" value="1" onchange="Lista_Tickets_Soporte();">
                                <span style="font-weight:normal">Por Iniciar</span><br>

                                <input type="checkbox" id="cproceso" checked name="cproceso" value="1" onchange="Lista_Tickets_Soporte();">
                                <span style="font-weight:normal">En Proceso</span><br>

                                <input type="checkbox" id="ccompletado" name="ccompletado" value="1" onchange="Lista_Tickets_Soporte();">
                                <span style="font-weight:normal">Completado</span><br>

                                <input type="checkbox" id="cstandby" name="cstandby" value="1" onchange="Lista_Tickets_Soporte();">
                                <span style="font-weight:normal">Stand by</span><br>

                                <input type="checkbox" id="ccancelado" name="ccancelado" value="1" onchange="Lista_Tickets_Soporte();">
                                <span style="font-weight:normal">Cancelado</span><br>

                                <input type="checkbox" id="cderivado" name="cderivado" value="1" onchange="Lista_Tickets_Soporte();">
                                <span style="font-weight:normal">Derivado</span>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-2">
                            <label>Fecha Inicio:</label>
                            <input type="date" class="form-control" name="fecha_iniciob"
                                id="fecha_iniciob" value="{{ date('Y-m-01') }}">
                        </div>

                        <div class="col-md-6 col-lg-2">
                            <label>Fecha Fin:</label>
                            <input type="date" class="form-control" name="fecha_finb"
                                id="fecha_finb" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="col-md-6 col-lg-1">
                            <button type="button" class="btn btn-primary mb-2 mr-2 " title="Buscar" onclick="Lista_Tickets_Soporte()">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </button>
                        </div>
                        <div class="col-md-6 col-lg-1">
                            <a class="btn mb-2 mb-sm-0 mb-md-2 mb-lg-0" style="background-color: #28a745 !important;" onclick="Excel_Tabla_General();">
                                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;">
                                    <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                        <path d="M0,172v-172h172v172z" fill="none"></path>
                                        <g fill="#ffffff">
                                            <path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path>
                                        </g>
                                    </g>
                                </svg>
                            </a>
                        </div>
                    </div>
                    <div class="toggle-switch">
                        <input class="toggle-input" id="toggle-fr" type="checkbox" checked>
                        <label class="toggle-label" for="toggle-fr"></label>
                        <span class="ml-5">Fecha Registro</span>
                    </div>
                    <div class="toggle-switch">
                        <input class="toggle-input" id="toggle-tipo" type="checkbox" checked>
                        <label class="toggle-label" for="toggle-tipo"></label>
                        <span class="ml-5">Tipo</span>
                    </div>
                    <div class="toggle-switch">
                        <input class="toggle-input" id="toggle-esp" type="checkbox" !checked>
                        <label class="toggle-label" for="toggle-esp"></label>
                        <span class="ml-5">Especialidad</span>
                    </div>
                    <div class="toggle-switch">
                        <input class="toggle-input" id="toggle-ele" type="checkbox" !checked>
                        <label class="toggle-label" for="toggle-ele"></label>
                        <span class="ml-5">Elemento</span>
                    </div>
                    <div class="toggle-switch">
                        <input class="toggle-input" id="toggle-res" type="checkbox" checked>
                        <label class="toggle-label" for="toggle-res"></label>
                        <span class="ml-5">Responsable</span>
                    </div>
                    @csrf
                    <div class="table-responsive mb-4 mt-4" id="lista_reproceso">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#soporte_master").addClass('active');
        $("#hsoporte_master").attr('aria-expanded', 'true');

        Lista_Tickets_Soporte();
    });



    function Lista_Tickets_Soporte() {
        Cargando();

        var url = "{{ route('soporte_ticket_master.list') }}";
        var csrfToken = $('input[name="_token"]').val();

        var fecha_iniciob = $('#fecha_iniciob').val();
        var fecha_finb = $('#fecha_finb').val();
        var cpiniciar = 0;
        var cproceso = 0;
        var ccompletado = 0;
        var cstandby = 0;
        var ccancelado = 0;
        var cderivado = 0;
        if ($('#cpiniciar').is(":checked")) {
            var cpiniciar = 1;
        }
        if ($('#cproceso').is(":checked")) {
            var cproceso = 1;
        }
        if ($('#ccompletado').is(":checked")) {
            var ccompletado = 1;
        }
        if ($('#cstandby').is(":checked")) {
            var cstandby = 1;
        }
        if ($('#ccancelado').is(":checked")) {
            var ccancelado = 1;
        }
        if ($('#cderivado').is(":checked")) {
            var cderivado = 1;
        }
        $.ajax({
            url: url,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                'fecha_iniciob': fecha_iniciob,
                'fecha_finb': fecha_finb,
                'cpiniciar': cpiniciar,
                'cproceso': cproceso,
                'ccompletado': ccompletado,
                'cstandby': cstandby,
                'ccancelado': ccancelado,
                'cderivado': cderivado

            },
            success: function(resp) {
                $('#lista_reproceso').html(resp);
            }
        });
    }


    function Delete_ErroresPicking(id) {
        Cargando();

        var url = "{{ route('errorespicking.destroy', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "DELETE",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Tickets_Soporte();
                        });
                    }
                });
            }
        })
    }

    function Excel_Tabla_General() {
        var fec_ini = $('#fecha_iniciob').val();
        var fec_fin = $('#fecha_finb').val();
        var cpiniciar = 0;
        var cproceso = 0;
        var ccompletado = 0;
        var cstandby = 0;
        var ccancelado = 0;

        if ($('#cpiniciar').is(":checked")) {
            var cpiniciar = 1;
        }
        if ($('#cproceso').is(":checked")) {
            var cproceso = 1;
        }
        if ($('#ccompletado').is(":checked")) {
            var ccompletado = 1;
        }
        if ($('#cstandby').is(":checked")) {
            var cstandby = 1;
        }
        if ($('#ccancelado').is(":checked")) {
            var ccancelado = 1;
        }
        console.log(ccompletado);
        window.location = "{{ route('soporte_tg.excel', [ ':fec_ini', ':fec_fin',':cpiniciar', ':cproceso', ':cstandby',':ccompletado',':ccancelado']) }}"
            .replace(':fec_ini', fec_ini)
            .replace(':fec_fin', fec_fin)
            .replace(':cpiniciar', cpiniciar)
            .replace(':cproceso', cproceso)
            .replace(':cstandby', cstandby)
            .replace(':ccompletado', ccompletado)
            .replace(':ccancelado', ccancelado);
    }
</script>
@endsection