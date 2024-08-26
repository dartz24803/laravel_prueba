@extends('layouts.plantilla_new')

@section('navbar')
    @include('logistica.navbar')
@endsection

@section('content')
    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Solicitud de devolución</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row"> 
                <div class="col-xl-12 col-lg-12 col-sm-12 layout-spacing">
                    <div class="widget-content widget-content-area br-6 p-3">
                        <form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
                            <div class="row">
                                <div class="form-group col-lg-12">
                                    <label class="control-label text-bold">Nro. Req.: {{ $get_id->n_requerimiento }}</label>
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="table-responsive mt-4" id="lista_tracking">
                                    <table id="tabla_js" class="table" style="width:100%">
                                        <thead>
                                            <tr class="text-center">
                                                <th>Devolución</th>
                                                <th>SKU</th>
                                                <th>Descripción</th>
                                                <th>Cantidad</th>
                                                <th>Ingreso de detalle</th>
                                            </tr>
                                        </thead>
                                    
                                        <tbody>
                                            @foreach ($list_guia_remision as $list)
                                                <tr class="text-center">
                                                    <td>
                                                        <div class="custom-control custom-checkbox custom-control-inline">
                                                            <input type="checkbox" id="devolucion_{{ $list->id }}" name="devolucion[]" value="{{ $list->id }}" class="custom-control-input" onclick="Ingreso_Detalle('{{ $list->id }}');">
                                                            <label class="custom-control-label" for="devolucion_{{ $list->id }}"></label>
                                                        </div>
                                                    </td>
                                                    <td>{{ $list->sku }}</td>
                                                    <td class="text-left">{{ $list->descripcion }}</td>
                                                    <td>{{ $list->cantidad }}</td>
                                                    <td id="td_id_{{ $list->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slash text-danger">
                                                            <circle cx="12" cy="12" r="10"></circle>
                                                            <line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line>
                                                        </svg>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
    
                            <div class="modal-footer mt-3">
                                @csrf
                                <button class="btn btn-primary" type="button" onclick="Insert_Reporte_Devolucion();">Guardar</button>
                                <a class="btn" href="{{ route('tracking') }}">Cancelar</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#li_trackings").addClass('active');
            $("#a_trackings").attr('aria-expanded','true');
        });

        function Ingreso_Detalle(id){
            if($("#devolucion_"+id).is(':checked')){
                $("#td_id_"+id).html('<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route("tracking.modal_solicitud_devolucion", ":id") }}">Abrir</button>'.replace(':id', id));
            }else{
                $("#td_id_"+id).html('<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-slash text-danger"><circle cx="12" cy="12" r="10"></circle><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"></line></svg>');
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

        function Insert_Reporte_Devolucion() {
            Cargando();

            var dataString = new FormData(document.getElementById('formulario'));
            var url = "{{ route('tracking.insert_reporte_devolucion', $get_id->id) }}";

            $.ajax({
                url: url,
                data: dataString,
                type: "POST",
                processData: false,
                contentType: false,
                success: function(data) {
                    if(data=="error"){
                        Swal({
                            title: '¡Registro Denegado!',
                            text: "¡Debe completar los datos de los ítem(s) seleccionados!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            '¡Cambio de estado exitoso!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            window.location = "{{ route('tracking') }}";
                        });
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
    </script>
@endsection