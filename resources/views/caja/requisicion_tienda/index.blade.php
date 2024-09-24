@extends('layouts.plantilla')

@section('navbar')
    @include('caja.navbar')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Requisición tienda</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="toolbar d-md-flex align-items-md-center mt-3">
                            <div class="form-group col-lg-2">
                                <label>Base:</label>
                                <select class="form-control" name="cod_baseb" id="cod_baseb" onchange="Lista_Requisicion_Tienda();">
                                    <option value="0">Todos</option>
                                    @foreach ($list_base as $list)
                                        <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-10">
                                <button type="button" class="btn btn-primary mb-2 mb-sm-0 mb-md-2 mb-lg-0" title="Registrar" data-toggle="modal" data-target="#ModalRegistroGrande" app_reg_grande="{{ route('requisicion_tienda.create') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                    Registrar
                                </button>
                            </div>
                        </div>

                        <div class="table-responsive" id="lista_requisicion_tienda">
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
            $("#requisiciones_tiendas").addClass('active');

            Lista_Requisicion_Tienda();
        });

        function Lista_Requisicion_Tienda(){
            Cargando();

            var cod_base = $('#cod_baseb').val();
            var url = "{{ route('requisicion_tienda.list') }}";

            $.ajax({
                url: url,
                type: "POST",
                data: {'cod_base':cod_base},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#lista_requisicion_tienda').html(resp);  
                }
            });
        }

        function solo_Numeros(e) {
            var key = event.which || event.keyCode;
            if (key >= 48 && key <= 57) {
                return true;
            } else {
                return false;
            }
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

        function Descargar_Archivo(id){
            window.location.replace("{{ route('observacion.download', ':id') }}".replace(':id', id));
        }

        function Aprobar_Requisicion_Tienda(id) {
            Cargando();

            var url = "{{ route('requisicion_tienda.aprobar', ':id') }}".replace(':id', id);
            var csrfToken = $('input[name="_token"]').val();

            Swal({
                title: '¿Realmente desea aprobar la requisición?',
                text: "No podrás revertir esta acción",
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
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            Swal(
                                '¡Aprobado!',
                                'El registro ha sido aprobado satisfactoriamente.',
                                'success'
                            ).then(function() {
                                Lista_Requisicion_Tienda();
                            });    
                        }
                    });
                }
            })
        }

        function Delete_Requisicion_Tienda(id) {
            Cargando();

            var url = "{{ route('requisicion_tienda.destroy', ':id') }}".replace(':id', id);
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
                                Lista_Requisicion_Tienda();
                            });    
                        }
                    });
                }
            })
        }
    </script>
@endsection