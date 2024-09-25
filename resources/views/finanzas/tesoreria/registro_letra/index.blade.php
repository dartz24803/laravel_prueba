@extends('layouts.plantilla')

@section('navbar')
    @include('finanzas.navbar')
@endsection

@section('content')
    <style>
        input[disabled] {
            background-color: white !important;
            color: black;
        }
    </style>

    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Cheques y letras</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="toolbar d-md-flex mt-3">
                            <div class="form-group col-lg-2">
                                <label>Estado:</label>
                                <select class="form-control" name="estadob" id="estadob" 
                                onchange="Lista_Registro_Letra();">
                                    <option value="0">Todos</option>
                                    <option value="1">Por Cancelar</option>
                                    <option value="2">Cancelado</option>
                                </select>
                            </div>

                            <div class="form-group col-lg-3">
                                <label>Empresa:</label>
                                <select class="form-control basicb" name="id_empresab" id="id_empresab" 
                                onchange="Lista_Registro_Letra();">
                                    <option value="0">Todos</option>
                                    @foreach ($list_empresa as $list)
                                        <option value="{{ $list->id_empresa }}">
                                            {{ $list->nom_empresa }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-3">
                                <label>Aceptante:</label>
                                <select class="form-control basicb" name="id_aceptanteb" 
                                id="id_aceptanteb" onchange="Lista_Registro_Letra();">
                                    <option value="0">Todos</option>
                                    @foreach ($list_aceptante as $list)
                                        <option value="{{ $list->id_aceptante }}">
                                            {{ $list->nom_aceptante }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-1 mb-0">
                                <label>Fecha</label>
                                <div class="n-chk">
                                    <label class="new-control new-radio radio-primary">
                                        <input type="radio" id="emision" class="new-control-input" 
                                        name="fecha_radiob" value="1" checked 
                                        onchange="Lista_Registro_Letra();">
                                        <span class="new-control-indicator"></span>Emisión
                                    </label>
                                    <label class="new-control new-radio radio-primary">
                                        <input type="radio" id="vencimiento" class="new-control-input" 
                                        name="fecha_radiob" value="2" onchange="Lista_Registro_Letra();">
                                        <span class="new-control-indicator"></span>Venc.
                                    </label>
                                </div>
                            </div>
                            
                            <div class="form-group col-lg-1">
                                <label>Mes:</label>
                                <select class="form-control" name="mesb" id="mesb" onchange="Lista_Registro_Letra();">
                                    <option value="0">Todos</option>
                                    @foreach ($list_mes as $list)
                                        <option value="{{ $list->cod_mes }}"
                                        @if ($list->cod_mes==date('m')) selected @endif>
                                            {{ $list->abr_mes }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="form-group col-lg-1">
                                <label>Año:</label>
                                <select class="form-control" name="aniob" id="aniob" onchange="Lista_Registro_Letra();">
                                    <option value="0">Todos</option>
                                    @foreach ($list_anio as $list)
                                        <option value="{{ $list->cod_anio }}"
                                        @if ($list->cod_anio==date('Y')) selected @endif>
                                            {{ $list->cod_anio }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-10 d-flex align-items-center">
                                <button type="button" class="btn btn-primary mb-4" title="Registrar" data-toggle="modal" data-target="#ModalRegistroGrande" app_reg_grande="{{ route('registro_letra.create') }}">
                                    Nuevo
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive" id="lista_registro_letra">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#tesorerias").addClass('active');
            $("#htesorerias").attr('aria-expanded', 'true');
            $("#registros_letras").addClass('active');

            $(".basicb").select2({
                tags: true
            });
            Lista_Registro_Letra();
        });

        function Lista_Registro_Letra(){
            Cargando();

            var estado = $('#estadob').val();
            var id_empresa = $('#id_empresab').val();
            var id_aceptante = $('#id_aceptanteb').val();
            var tipo_fecha = $('input:radio[name=fecha_radiob]:checked').val();
            var mes = $('#mesb').val();
            var anio = $('#aniob').val();
            var url = "{{ route('registro_letra.list') }}";

            $.ajax({
                url: url,
                type: "POST",
                data:{
                    'estado':estado,
                    'id_empresa':id_empresa,
                    'id_aceptante':id_aceptante,
                    'tipo_fecha':tipo_fecha,
                    'mes':mes,
                    'anio':anio
                },
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#lista_registro_letra').html(resp);  
                }
            });
        }

        function solo_Numeros_Punto(e) {
            var key = event.which || event.keyCode;
            if ((key >= 48 && key <= 57) || key == 46) {
                if (key == 46 && event.target.value.indexOf('.') !== -1) {
                    return false;
                }
                return true;
            } else {
                return false;
            }
        }

        function solo_Numeros(e) {
            var key = event.which || event.keyCode;
            if (key >= 48 && key <= 57) {
                return true;
            } else {
                return false;
            }
        }

        function Negociado_Endosado(v) {
            Cargando();

            var negociado_endosado = $('#negociado_endosado'+v).val();

            if (negociado_endosado=="2") {
                $('.empresa_vinculada'+v).show();
                $(".basic"+v).select2({
                    dropdownParent: $('#ModalRegistroGrande')
                });
            }else{
                $('.empresa_vinculada'+v).hide();
                $('#id_empresa_vinculada'+v).val('0');
            }
        }

        function Valida_Archivo(val){
            Cargando();

            var archivoInput = document.getElementById(val);
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.pdf|.png|.jpg|.jpeg)$/i;

            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: 'Registro Denegado',
                    text: "Asegurese de ingresar archivo con extensión .pdf|.jpg|.png|.jpeg",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                archivoInput.value = ''; 
                return false;
            }else{
                return true;         
            }
        }

        function Delete_Registro_Letra(id) {
            Cargando();

            var url = "{{ route('registro_letra.destroy', ':id') }}".replace(':id', id);
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
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function() {
                            Swal(
                                '¡Eliminado!',
                                'El registro ha sido eliminado satisfactoriamente.',
                                'success'
                            ).then(function() {
                                Lista_Registro_Letra();
                            });    
                        }
                    });
                }
            })
        }
    </script>
@endsection