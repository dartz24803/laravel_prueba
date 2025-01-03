@extends('layouts.plantilla')

@section('navbar')
@include('comercial.navbar')
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
                <h3>Sugerencia de Precios
                </h3>
            </div>
        </div>

        <div class="row" id="cancel-row">

            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-6 p-3">
                    <div class="toolbar">
                        <form id="formulario" class="control">
                            <div class="col-md-12 row">
                                <div class="col-lg-2">
                                    <label>Base:</label>
                                    <select class="form-control" id="base_sp" name="base_sp" onchange="Busqueda_Sugerencia_Precio();">
                                        <option value="0">Todos</option>
                                        <?php foreach ($list_base as $list) { ?>
                                            <option value="<?php echo $list->cod_base; ?>"><?php echo $list->cod_base; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>


                                <div class="col-lg-3 mt-2 mt-lg-0">
                                    <label>Categoría:</label>
                                    <select class="form-control" id="categoria_sp" name="categoria_sp" onchange="Busqueda_Sugerencia_Precio();">
                                        <option value="0">Todos</option>
                                    </select>
                                </div>
                                <div class="toggle-switch">
                                    <input class="toggle-input" id="toggle-coment" type="checkbox" checked>
                                    <label class="toggle-label" for="toggle-coment"></label>
                                    <span class="ml-5">Comentario</span>
                                </div>
                                <div class="toggle-switch">
                                    <input class="toggle-input" id="toggle-eviden" type="checkbox" checked>
                                    <label class="toggle-label" for="toggle-eviden"></label>
                                    <span class="ml-5">Evidencia</span>
                                </div>
                                <div class="form-group col-md-2" id="btnregistarm">
                                    <label class="control-label text-bold">&nbsp;</label>
                                    <button class="btn btn-primary hidden-sm" type="button" onclick="Formato_Requerimiento_Precios();" style="margin-top:33px;background-color: #28a745!important;border-color:#28a745!important">
                                        <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;">
                                            <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                                                <path d="M0,172v-172h172v172z" fill="none"></path>
                                                <g fill="#ffffff">
                                                    <path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path>
                                                </g>
                                            </g>
                                        </svg>
                                        Formato
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    @csrf
                    <div class="table-responsive mb-4 mt-4" id="busqueda">

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $(document).ready(function() {

        $("#comercial").addClass('active');
        $("#hcomercial").attr('aria-expanded', 'true');
        $("#rsugerenciaprecio").addClass('active');
        Busqueda_Sugerencia_Precio();
    });

    function Busqueda_Sugerencia_Precio() {
        Cargando();

        var base = $('#base_sp').val();
        var categoria = $('#categoria_sp').val();
        var url = "{{ url('SugerenciadePrecios/Busqueda_Sugerencia_Precio') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                'base': base,
                'categoria': categoria
            },
            type: "POST",

            success: function(data) {
                $('#busqueda').html(data);
            }
        });
    }


    function Formato_Requerimiento_Precios() {
        var base = $('#base_sp').val();
        var categoria = $('#categoria_sp').val();
        var url = "{{ route('SugerenciadePrecios.Formato_Requerimiento_Precios', ['base' => ':base', 'categoria' => ':categoria']) }}";

        // Reemplazar los placeholders con los valores reales
        url = url.replace(':base', base).replace(':categoria', categoria);

        // Redirigir a la URL generada
        window.location.href = url;
    }


    function Delete_Requerimiento_Prenda(id, anio, mes) {
        var id = id;
        var url = "{{ url('RequerimientoPrenda/Delete_Requerimiento_Prenda') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            //title: '¿Realmente quieres eliminar el registro de '+ nombre +'?',
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
                    data: {
                        'codigo': id,
                        'anio': anio,
                        'mes': mes
                    },
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Busqueda_Sugerencia_Precio();
                        });
                    }
                });
            }
        })
    }

    function Eliminar_Todo_Requerimiento_Prenda() {
        var url = "{{ url('RequerimientoPrenda/Delete_Todo_Requerimiento_Prenda') }}";
        var csrfToken = $('input[name="_token"]').val();

        var anio = $('#anioi').val();
        var mes = $('#mesi').val();
        Swal({
            title: '¿Realmente desea eliminar todos los registros?',
            text: "Los registros serán eliminados permanentemente",
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
                        'anio': anio,
                        'mes': mes
                    },
                    success: function(data) {
                        if (data == "0") {
                            Swal(
                                'Eliminación Denegada!',
                                'No se encontraron registros por eliminar.',
                                'error'
                            ).then(function() {});
                        } else {
                            Swal(
                                'Eliminado!',
                                'Los registros han sido eliminados satisfactoriamente.',
                                'success'
                            ).then(function() {
                                Busqueda_Sugerencia_Precio();
                            });
                        }

                    }
                });
            }
        })
    }
</script>
@endsection