@extends('layouts.plantilla')

@section('content')
    @foreach ($list_tipo_calendario_todo as $list)
        <style>
            .form-group label{
                color: black !important;
            }
            .radio-{{ $list->id_tipo_calendario }} span.new-control-indicator {
                border: 2px solid {{ $list->color }}; 
            }
            .new-control.new-checkbox.new-checkbox-text.checkbox-{{ $list->id_tipo_calendario }} > input:checked ~ span.new-chk-content, .new-control.new-checkbox.new-checkbox-text.checkbox-outline-{{ $list['id_tipo_calendario']; }} > input:checked ~ span.new-chk-content {
                color: {{ $list->color }}; 
            }
            .new-control.new-checkbox.checkbox-{{ $list->id_tipo_calendario }} > input:checked ~ span.new-control-indicator {
                background: {{ $list->color }}; 
            }
            .new-control.new-checkbox.checkbox-outline-{{ $list->id_tipo_calendario }} > input:checked ~ span.new-control-indicator {
                border: 2px solid {{ $list->color }}; 
            }
            .new-control.new-checkbox.checkbox-outline-{{ $list->id_tipo_calendario }} > input:checked ~ span.new-control-indicator:after {
                border-color: {{ $list->color }}; 
            }
            .new-control.new-radio.radio-{{ $list->id_tipo_calendario }} > input:checked ~ span.new-control-indicator {
                background: {{ $list->color }}; 
            }
            .new-control.new-radio.radio-classic-{{ $list->id_tipo_calendario }} > input:checked ~ span.new-control-indicator {
                border: 3px solid {{ $list->color }}; 
            }
            .new-control.new-radio.radio-classic-{{ $list->id_tipo_calendario }} > input:checked ~ span.new-control-indicator:after {
                background-color: {{ $list->color }}; 
            }
            .new-control.new-radio.new-radio-text.radio-{{ $list->id_tipo_calendario }} > input:checked ~ span.new-radio-content, .new-control.new-radio.new-radio-text.radio-classic-{{ $list->id_tipo_calendario }} > input:checked ~ span.new-radio-content {
                color: {{ $list->color }}; 
            }
            .label-{{ $list->id_tipo_calendario }}:before {
                background: {{ $list->color." !important" }};
            }
            .bg-{{ $list->id_tipo_calendario }} {
                background-color: {{ $list->background." !important" }};
                border-color: {{ $list->color." !important" }};
                color: #fff;
                -webkit-box-shadow: none !important;
                box-shadow: none !important; 
            }
            a.bg-{{ $list->id_tipo_calendario }}:hover {
                background-color: inherit !important;
                border-width: 2px !important; 
            }
            .fc-day-grid-event.bg-{{ $list->id_tipo_calendario }} .fc-content:before {
                background: {{ $list->color }}; 
            }
        </style>
    @endforeach

    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="row layout-top-spacing" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-md-12">
                    <div class="statbox widget box box-shadow">
                        <div class="widget-content widget-content-area p-3">
                            <div class="calendar-upper-section">
                                <div class="row">
                                    <div class="col-md-8 col-12">
                                        <div class="labels">
                                            @foreach ($list_tipo_calendario_todo as $list)
                                                <p class="label label-{{ $list->id_tipo_calendario }}">{{ $list->nom_tipo_calendario }}</p>
                                            @endforeach
                                        </div>
                                    </div>                                                
                                    <div class="col-md-4 col-12">
                                        <form action="javascript:void(0);" class="form-horizontal mt-md-0 mt-3 text-md-right text-center">
                                            <button id="myBtn" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar mr-2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg> Agregar Cita</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div id="lista_calendario">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- The Modal -->
                <div id="addEventsModal" data-backdrop="static"  class="modal animated fadeIn">

                    <div class="modal-dialog modal-lg modal-dialog-centered">
                        
                        <!-- Modal content -->
                        <div class="modal-content">

                            <div class="modal-body">

                                <span id="close_modal" class="close">&times;</span>

                                <div class="add-edit-event-box">
                                    <div class="add-edit-event-content">
                                        <h5 class="add-event-title modal-title">Registrar Nueva Cita</h5>
                                        <h5 class="edit-event-title modal-title">Editar Cita</h5>

                                        <form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="start-date" class="">De:</label>
                                                        <div class="d-flex">
                                                            <input id="start-date" placeholder="Fecha Inicial" class="form-control" type="text" 
                                                            name="start-date" value="{{ date('Y-m-d h:i') }}">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="end-date" class="">Hasta:</label>
                                                        <div class="d-flex">
                                                            <input id="end-date" placeholder="Fecha Final" type="text" class="form-control" 
                                                            name="end-date">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="task" class="">Título:</label>
                                                        <div class="d-flex">
                                                            <input id="task" type="text" placeholder="Título" class="form-control" 
                                                            name="task">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="taskdescription" class="">Descripción:</label>
                                                        <div class="d-flex">
                                                            <textarea id="taskdescription" placeholder="Descripción" rows="2" 
                                                            class="form-control" name="taskdescription"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mt-3">
                                                <div class="col-lg-12">
                                                    <div class="form-group">
                                                        <label for="id_proveedor" class="">Proveedor:</label>
                                                        <div id="div_proveedor" class="d-flex">
                                                            <select class="form-control basicp" name="id_proveedor" id="id_proveedor">
                                                                <option value="0">Seleccione</option>
                                                                @if (session('usuario')->id_puesto=="75")
                                                                    @foreach ($list_proveedor as $list)
                                                                        <option value="{{ $list->clp_codigo."-1" }}">{{ $list->clp_razsoc }}</option>
                                                                    @endforeach
                                                                    @foreach ($list_proveedor_taller as $list)
                                                                        <option value="{{ $list->id_proveedor."-0" }}">{{ $list->nombre_proveedor }}</option>
                                                                    @endforeach
                                                                @endif
                                                                @if (session('usuario')->id_puesto=="83" || 
                                                                session('usuario')->id_puesto=="195")
                                                                    @foreach ($list_proveedor_taller as $list)
                                                                        <option value="{{ $list->id_proveedor."-0" }}">{{ $list->nombre_proveedor }}</option>
                                                                    @endforeach
                                                                @endif
                                                                @if (session('usuario')->id_puesto=="122")
                                                                    @foreach ($list_proveedor_tela as $list)
                                                                        <option value="{{ $list->id_proveedor."-0" }}">{{ $list->nombre_proveedor }}</option>
                                                                    @endforeach
                                                                @endif
                                                                @if (session('usuario')->id_nivel=="1")
                                                                    @foreach ($list_proveedor as $list)
                                                                        <option value="{{ $list->clp_codigo."-1" }}">{{ $list->clp_razsoc }}</option>
                                                                    @endforeach
                                                                    @foreach ($list_proveedor_taller as $list)
                                                                        <option value="{{ $list->id_proveedor."-0" }}">{{ $list->nombre_proveedor }}</option>
                                                                    @endforeach
                                                                    @foreach ($list_proveedor_tela as $list)
                                                                        <option value="{{ $list->id_proveedor."-0" }}">{{ $list->nombre_proveedor }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row mt-3">
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="cod_base" class="">Base:</label>
                                                        <div id="div_base" class="d-flex">
                                                            <select class="form-control" name="cod_base" id="cod_base">
                                                                <option value="0" >Seleccione</option>
                                                                @foreach ($list_base as $list)
                                                                    <option value="{{ $list->cod_base }}"
                                                                    @if ($list->cod_base==session('usuario')->centro_labores) selected @endif>
                                                                        {{ $list->cod_base }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="form-group">
                                                        <label for="cant_prendas" class="">Cantidad:</label>
                                                        <div class="d-flex">
                                                            <input id="cant_prendas" type="text" placeholder="Cantidad" class="form-control" 
                                                            name="cant_prendas" onkeypress="return solo_Numeros(event);">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="form-group col-lg-12">
                                                    <label>Tipo:</label>
                                                </div>
                                                @foreach ($list_tipo_calendario as $list)
                                                    <div class="form-group col-lg-3">
                                                        <label class="new-control new-radio 
                                                        radio-<?= $list->id_tipo_calendario ?>">
                                                            <input type="radio" 
                                                            <?php if($list->id_tipo_calendario=="2" && 
                                                            session('usuario')->id_puesto=="75"){ echo "checked"; 
                                                            }elseif($list->id_tipo_calendario=="3" && 
                                                            (session('usuario')->id_nivel=="1" || 
                                                            session('usuario')->id_puesto=="83" ||
                                                            session('usuario')->id_puesto=="122" ||
                                                            session('usuario')->id_puesto=="195")){ echo "checked"; } ?> 
                                                            class="new-control-input mr-2"
                                                            id="r_{{ $list->id_tipo_calendario }}" 
                                                            name="id_tipo_calendario" 
                                                            value="{{ $list->id_tipo_calendario }}">
                                                            <span class="new-control-indicator"></span>
                                                            {{ $list->nom_tipo_calendario }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <input type="hidden" class="form-control" id="id_calendario" name="id_calendario">
                                        </form>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button id="add-e" class="btn">Guardar</button>
                                <button id="edit-event" class="btn">Guardar</button>
                                <div id="div_eliminar"></div>
                                <button id="discard_modal" class="btn" data-dismiss="modal">Cerrar</button>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $("#calendarios_logisticos").attr('aria-expanded','true');
            $("#calendarios_logisticos").addClass('active');

            $(".basicp").select2({
                dropdownParent: $('#addEventsModal')
            });

            Lista_Calendario_Logistico();
        });

        function Lista_Calendario_Logistico(){
            Cargando();

            var url = "{{ route('calendario_logistico.list') }}";

            $.ajax({
                url: url,
                type: "GET",
                success:function (resp) {
                    $('#lista_calendario').html(resp);  
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

        function Insert_Calendario_Logistico(){
            Cargando();

            var dataString = new FormData(document.getElementById('formulario'));
            var url = "{{ route('calendario_logistico.store') }}";

            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (data) {
                    swal.fire(
                        '¡Registro Exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Calendario_Logistico();
                        $("#addEventsModal .close").click();
                    });
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

        function Update_Calendario_Logistico(id){
            Cargando();

            var dataString = new FormData(document.getElementById('formulario'));
            var url = "{{ route('calendario_logistico.update', ':id') }}".replace(':id', id);

            $.ajax({
                type:"POST",
                url:url,
                data:dataString,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (data) {
                    if(data=="error"){
                        Swal({
                            title: '¡Actualización Denegada!',
                            html: "¡La cita no puede ser modificada por tener registros en <b>Reporte de Proveedores!</b>",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    }else{
                        swal.fire(
                            '¡Actualización Exitosa!',
                            '¡Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            Lista_Calendario_Logistico();
                            $("#addEventsModal .close").click();
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

        function Delete_Calendario_Logistico(id) {
            Cargando();

            var url = "{{ route('calendario_logistico.destroy', ':id') }}".replace(':id', id);
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
                                Lista_Calendario_Logistico();
                                $("#addEventsModal .close").click();
                            });    
                        }
                    });
                }
            })
        }
    </script>
@endsection