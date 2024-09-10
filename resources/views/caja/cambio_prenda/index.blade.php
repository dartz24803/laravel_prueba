@extends('layouts.plantilla')

@section('navbar')
    @include('caja.navbar')
@endsection

@section('content')
    <style>
        input[disabled] {
            background-color: white !important;
            color: black;
        }

        select[disabled] {
            background-color: white !important;
            color: black;
        }
    </style>

    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Cambio de prenda</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="toolbar d-md-flex align-items-md-center mt-3">
                            <div class="form-group col-lg-2">
                                <label>Año:</label>
                                <select class="form-control" name="aniob" id="aniob" onchange="Lista_Cambio_Prenda();">
                                    @foreach ($list_anio as $list)
                                        <option value="{{ $list->cod_anio }}"
                                        @if ($list->cod_anio==date('Y')) selected @endif>
                                            {{ $list->cod_anio }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-2">
                                <label>Tipo:</label>
                                <select class="form-control" name="tipob" id="tipob" onchange="Lista_Cambio_Prenda();">
                                    <option value="1" selected>Con boleta</option>
                                    <option value="2">Sin boleta</option>
                                </select>
                            </div>
                        
                            <div id="div_boton" class="col-lg-3">
                                @if (session('usuario')->id_nivel=="1" || 
                                session('usuario')->id_puesto=="36" || 
                                session('usuario')->id_puesto=="23" || 
                                session('usuario')->id_puesto=="29" || 
                                session('usuario')->id_puesto=="167" || 
                                session('usuario')->id_puesto=="161" || 
                                session('usuario')->id_puesto=="197")
                                    <button type="button" class="btn btn-primary mb-2 mb-sm-0 mb-md-2 mb-lg-0" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('cambio_prenda_con.create') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                        Registrar
                                    </button>
                                @endif
                            </div>
                        </div>

                        <div class="table-responsive" id="lista_cambio_prenda">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#cajas").addClass('active');
            $("#hcajas").attr('aria-expanded', 'true');
            $("#cambios_prendas").addClass('active');

            Lista_Cambio_Prenda();
        });

        function Lista_Cambio_Prenda(){
            Cargando();

            var anio = $('#aniob').val();
            var tipo = $('#tipob').val();
            var url = "{{ route('cambio_prenda.list') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: {'anio':anio,'tipo':tipo},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#lista_cambio_prenda').html(resp);
                    if(tipo=="1"){
                        $('#div_boton').html('<button type="button" class="btn btn-primary mb-2 mb-sm-0 mb-md-2 mb-lg-0" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route("cambio_prenda_con.create") }}"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>Registrar</button>');
                    }else{
                        $('#div_boton').html('<button type="button" class="btn btn-primary mb-2 mb-sm-0 mb-md-2 mb-lg-0" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route("cambio_prenda_sin.create") }}"><svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>Registrar</button>');
                    }
                }
            });
        }

        function Buscar_Comprobante(v) {
            Cargando();

            var base = $('#base'+v).val();
            var tipo_comprobante = $('#tipo_comprobante'+v).val();
            var serie = $('#serie'+v).val();
            var n_documento = $('#n_documento'+v).val();
            var url = "{{ route('cambio_prenda.comprobante') }}";
            
            $.ajax({
                url: url,
                type: "POST",
                data: {'base':base,'tipo_comprobante':tipo_comprobante,'serie':serie,'n_documento':n_documento,'valida':v},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    if(data=="error"){
                            Swal({
                            title: '¡Sin Resultados!',
                            text: "¡Verificar datos!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        $('#div_detalle'+v).html(data);
                    }
                },
                error:function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var firstError = Object.values(errors)[0][0];
                    Swal.fire(
                        '¡Ups!',
                        firstError,
                        'warning'
                    );
                }
            });
        }

        function Mostrar_Otro(v){
            Cargando();

            if($('#id_motivo'+v).val() == "6"){
                $('.mostrar'+v).show();
            }else{
                $('.mostrar'+v).hide();
                $('#otro'+v).val('');
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

        function Habilitar_Checkbox(id,v){
            if ($("#cb_"+id+v).is(":checked")){
                $("#cb_"+id+v).prop('checked', false);
            }else{
                $("#cb_"+id+v).prop('checked', true);
            }
        }

        function Buscar_Producto(v) {
            Cargando();

            var n_codi_arti = $('#n_codi_arti'+v).val();
            var url = "{{ route('cambio_prenda.producto') }}";
            
            $.ajax({
                url: url,
                type: "POST",
                data: {'n_codi_arti':n_codi_arti,'valida':v},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(data) {
                    if(data=="error"){
                            Swal({
                            title: '¡Sin Resultados!',
                            text: "¡Verificar datos!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        $('#div_detalle'+v).html(data);
                    }
                },
                error:function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    var firstError = Object.values(errors)[0][0];
                    Swal.fire(
                        '¡Ups!',
                        firstError,
                        'warning'
                    );
                }
            });
        }

        /*function Descargar_Archivo(id){
            window.location.replace("{{ route('observacion.download', ':id') }}".replace(':id', id));
        }*/

        function Cambiar_Estado_Cambio_Prenda(id,estado_cambio) {
            Cargando();

            if(estado_cambio=="2"){
                titulo = "¿Realmente desea aprobar la solicitud?";
            }else{
                titulo = "¿Realmente desea denegar la solicitud?";
            }

            var url = "{{ route('cambio_prenda.cambiar_estado', ':id') }}".replace(':id', id);

            Swal({
                title: titulo,
                text: "El cambio será permanentemente.",
                type: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Si',
                cancelButtonText: 'No',
                padding: '2em'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        type: "PUT",
                        url: url,
                        data: {'id_cambio_prenda': id,'estado_cambio':estado_cambio},
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            Swal(
                                '¡Actualización Exitosa!',
                                'El registro ha sido actualizado satisfactoriamente.',
                                'success'
                            ).then(function() {
                                Lista_Cambio_Prenda();
                            });    
                        }
                    });
                }
            })
        }

        function Delete_Cambio_Prenda(id) {
            Cargando();

            var url = "{{ route('cambio_prenda.destroy', ':id') }}".replace(':id', id);

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
                                Lista_Cambio_Prenda();
                            });    
                        }
                    });
                }
            })
        }
    </script>
@endsection