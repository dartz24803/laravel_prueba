@extends('layouts.plantilla')

@section('navbar')
    @include('logistica.navbar')
@endsection

@section('content')
    <style>
        input[type=radio]:checked{
            border-color: #00B1F4 !important;
            background-color: #00B1F4 !important;
        }
    </style>

    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Evaluación de devolución</h3>
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
                                                <th>SKU</th>
                                                <th>Descripción</th>
                                                <th>Cantidad</th>
                                                <th>Detalle</th>
                                            </tr>
                                        </thead>
                                    
                                        <tbody>
                                            @foreach ($list_devolucion as $list)
                                                <tr class="text-center">
                                                    <td>{{ $list->sku }}</td>
                                                    <td class="text-left">{{ $list->descripcion }}</td>
                                                    <td>{{ $list->cantidad }}</td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#ModalUpdate" 
                                                        app_elim="{{ route("tracking.modal_evaluacion_devolucion", $list->id) }}">
                                                            Abrir
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="form-group col-lg-1">
                                    <label class="control-label text-bold">Comentario: </label>
                                </div>
                                <div class="form-group col-lg-11">
                                    <textarea class="form-control" name="comentario" 
                                    id="comentario" placeholder="Comentario" rows="3"></textarea>
                                </div>
                            </div>
    
                            <div class="modal-footer mt-3">
                                @csrf
                                <input type="hidden" name="id" value="{{ $get_id->id }}">
                                <button class="btn btn-primary" type="button" onclick="Insert_Autorizacion_Devolucion();">Guardar</button>
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
            $("#logisticas").addClass('active');
            $("#hlogisticas").attr('aria-expanded', 'true');
            $("#trackings").addClass('active');
        });

        function Insert_Autorizacion_Devolucion() { 
            Cargando();

            var dataString = new FormData(document.getElementById('formulario'));
            var url = "{{ route('tracking.insert_autorizacion_devolucion', $get_id->id) }}";

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
                            text: "¡Debe evaluar todas las devoluciones!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            '¡Registro Exitoso!',
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