@extends('layouts.plantilla')

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

        input[disabled] {
            background-color: white !important;
            color: black;
        }
    </style>

    <div id="content" class="main-content">
        <div class="layout-px-spacing">
            <div class="page-header">
                <div class="page-title">
                    <h3>Mercadería nueva</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="toolbar d-md-flex mt-3">
                            <div class="form-group col-lg-2">
                                <label>Usuario:</label>
                                <select class="form-control" id="cod_baseb" name="cod_baseb" onchange="Lista_Mercaderia_Nueva();">
                                    <option value="0">TODOS</option>
                                    @foreach ($list_usuario as $list)
                                        <option value="{{ $list->par_codusuario }}">{{ $list->par_desusuario }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-lg-2">
                                <label>Tipo de prenda:</label>
                                <select class="form-control" id="cod_baseb" name="cod_baseb" onchange="Lista_Mercaderia_Nueva();">
                                    <option value="0">TODOS</option>
                                    @foreach ($list_tipo_prenda as $list)
                                        <option value="{{ $list->sfa_codigo }}">{{ $list->sfa_descrip }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-lg-8 mt-2 mt-lg-0 d-flex align-items-center justify-content-start">
                                <div class="toggle-switch">
                                    <input class="toggle-input" id="toggle" type="checkbox" checked>
                                    <label class="toggle-label" for="toggle"></label>
                                    <span class="ml-5">Descripción</span>
                                </div>
                                <div class="toggle-switch">
                                    <input class="toggle-input" id="toggle2" type="checkbox" checked>
                                    <label class="toggle-label" for="toggle2"></label>
                                    <span class="ml-5">SKU</span>
                                </div>
                            </div>
                        </div>

                        @csrf
                        <div class="table-responsive mt-4" id="lista_mercaderia_nueva">
                        </div>
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

            Lista_Mercaderia_Nueva();
        });

        function Lista_Mercaderia_Nueva(){
            Cargando();

            var url = "{{ route('tracking.list_mercaderia_nueva') }}";
            var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                url: url,
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success:function (resp) {
                    $('#lista_mercaderia_nueva').html(resp);  
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
    </script>
@endsection