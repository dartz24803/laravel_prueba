@extends('layouts.plantilla')

@section('navbar')
    @include('finanzas.navbar')
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

        .drop-zone {
            max-width: 300px;
            height: 200px;
            padding: 16px;
            border: 2px dashed #007bff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            cursor: pointer;
        }

        .drop-zone--over {
            border-style: solid;
            background-color: #f0f0f0;
        }

        .drop-zone input {
            display: none;
        }

        .preview {
            margin-top: 10px;
            max-width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .preview img {
            max-width: 200px;
            margin-bottom: 10px;
        }

        .preview embed {
            width: 100%;
            height: 500px;
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
                    <h3>Caja chica</h3>
                </div>
            </div>
            
            <div class="row" id="cancel-row">
                <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                    <div class="widget-content widget-content-area br-6">
                        <div class="toolbar mt-2">
                            <div class="col-lg-12 text-center text-sm-right">
                                <button type="button" class="btn btn-primary mb-1 mb-sm-0" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('caja_chica.create_mo') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                    Movilidad
                                </button>

                                <button type="button" class="btn btn-primary mb-1 mb-sm-0" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('caja_chica.create_pv') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                                    Pagos varios
                                </button>
                        
                                <a class="btn mb-1 mb-sm-0 mt-lg-2 mt-xl-0" style="background-color: #28a745 !important;" onclick="Excel_Caja_Chica();">
                                    <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path></g></g></svg>                                
                                </a>
                            </div>
                        </div>

                        <div class="row mr-1 ml-1 mt-2">
                            <div class="col-sm-5 col-lg-2">
                                <label>Fecha Inicio:</label>
                                <input type="date" class="form-control" name="fec_iniciob" 
                                id="fec_iniciob" value="{{ date('Y-m-01') }}">
                            </div>

                            <div class="col-sm-5 col-lg-2">
                                <label>Fecha Fin:</label>
                                <input type="date" class="form-control" name="fec_finb" 
                                id="fec_finb" value="{{ date('Y-m-d') }}">
                            </div>

                            <div class="col-sm-2 col-lg-1 d-sm-flex align-items-sm-center mt-1 mt-sm-0">
                                <a type="button" class="btn btn-primary" title="Buscar" 
                                onclick="Lista_Caja_Chica();">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search toggle-search">
                                        <circle cx="11" cy="11" r="8"></circle>
                                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                    </svg>
                                </a>
                            </div>
                        </div>

                        <div class="row mr-1 ml-1 mt-3">
                            <div class="toggle-switch">
                                <input class="toggle-input" id="toggle-sc" type="checkbox">
                                <label class="toggle-label" for="toggle-sc"></label>
                                <span class="ml-5">Sub-Categoría</span>
                            </div>
                            <div class="toggle-switch">
                                <input class="toggle-input" id="toggle-em" type="checkbox">
                                <label class="toggle-label" for="toggle-em"></label>
                                <span class="ml-5">Empresa</span>
                            </div>
                            <div class="toggle-switch">
                                <input class="toggle-input" id="toggle-mo" type="checkbox">
                                <label class="toggle-label" for="toggle-mo"></label>
                                <span class="ml-5">Movimiento</span>
                            </div>
                            <div class="toggle-switch">
                                <input class="toggle-input" id="toggle-nc" type="checkbox">
                                <label class="toggle-label" for="toggle-nc"></label>
                                <span class="ml-5">N° de comprobante</span>
                            </div>
                            <div class="toggle-switch">
                                <input class="toggle-input" id="toggle-ru" type="checkbox">
                                <label class="toggle-label" for="toggle-ru"></label>
                                <span class="ml-5">RUC</span>
                            </div>
                            <div class="toggle-switch">
                                <input class="toggle-input" id="toggle-de" type="checkbox">
                                <label class="toggle-label" for="toggle-de"></label>
                                <span class="ml-5">Detalle</span>
                            </div>
                        </div>

                        <div class="table-responsive" id="lista_caja_chica">
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
            $("#cajas_chicas").addClass('active');

            Lista_Caja_Chica();
        });

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

        function Lista_Caja_Chica(){
            Cargando();

            var fec_inicio = $('#fec_iniciob').val();
            var fec_fin = $('#fec_finb').val();
            var url = "{{ route('caja_chica.list') }}";

            var ini = moment(fec_inicio);
            var fin = moment(fec_fin);
            if (ini.isAfter(fin) == true) {
                Swal({
                    title: '¡Selección Denegada!',
                    html: "Fecha inicio no debe ser mayor a fecha fin. <br> Por favor corrígelo.",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
            }else{
                $.ajax({
                    url: url,
                    type: "POST",
                    data:{
                        'fec_inicio':fec_inicio,
                        'fec_fin':fec_fin
                    },
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    success:function (resp) {
                        $('#lista_caja_chica').html(resp);  
                    }
                });
            }
        }

        function Traer_Sub_Categoria(v){
            Cargando();

            var url = "{{ route('caja_chica.traer_sub_categoria_mo') }}";
            var id_ubicacion = $('#id_ubicacion'+v).val();

            $.ajax({
                url: url,
                type: "POST",
                data: {'id_ubicacion':id_ubicacion},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#id_sub_categoria'+v).html(resp);
                }
            });
        }

        function Poner_Persona(v){
            var valores = [$('#id_usuario'+v).val()];
            $('#personas'+v).val(valores);
            if(v=="e"){
                $('.multivaluee').select2({
                    dropdownParent: $('#ModalUpdate')
                });
            }else{
                $('.multivalue').select2({
                    dropdownParent: $('#ModalRegistro')
                });
            }
        }

        function Traer_Categoria(v){
            Cargando();

            var url = "{{ route('caja_chica.traer_categoria_pv') }}";
            var id_ubicacion = $('#id_ubicacion'+v).val();

            $.ajax({
                url: url,
                type: "POST",
                data: {'id_ubicacion':id_ubicacion},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#id_categoria'+v).html(resp);
                    $('#id_sub_categoria'+v).html('<option value="0">Seleccione</option>');
                }
            });
        }

        function Traer_Sub_Categoria_Pv(v){
            Cargando();

            var url = "{{ route('caja_chica.traer_sub_categoria_pv') }}";
            var id_categoria = $('#id_categoria'+v).val();

            $.ajax({
                url: url,
                type: "POST",
                data: {'id_categoria':id_categoria},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#id_sub_categoria'+v).html(resp);
                }
            });
        }

        function Tipo_Movimiento(v){
            var tipo_movimiento = $('input[name="tipo_movimiento'+v+'"]:checked').val();

            if(tipo_movimiento=="1"){
                $('#proveedores_mo-tab'+v).html('Cliente');
            }else{
                $('#proveedores_mo-tab'+v).html('Proveedor');
            }
        }

        function Cambiar_Nombre_Comprobante(v){
            var id_tipo_comprobante = $('#id_tipo_comprobante'+v).val();

            if(id_tipo_comprobante=="6"){
                $('#nombre_comprobante'+v).html('N° ticket:');
            }else{
                $('#nombre_comprobante'+v).html('N° comprobante:');
            }
        }

        function Traer_Pago(v){
            Cargando();

            var url = "{{ route('caja_chica.traer_tipo_pago') }}";
            var id_pago = $('#id_pago'+v).val();

            $.ajax({
                url: url,
                type: "POST",
                data: {'id_pago':id_pago},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    $('#id_tipo_pago'+v).html(resp);
                }
            });
        }

        function validarArchivoImgPrevisualizar(inputId, previewDivId) {
            const input = document.getElementById(inputId);
            const previewDiv = document.getElementById(previewDivId);

            if (input.files && input.files[0]) {
                const file = input.files[0];
                const fileType = file.type;

                const reader = new FileReader();
                
                reader.onload = function (e) {
                    previewDiv.innerHTML = '';

                    if (fileType.startsWith('image/')) {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        previewDiv.appendChild(img);
                    } else if (fileType === 'application/pdf') {
                        const embed = document.createElement('embed');
                        embed.src = e.target.result;
                        previewDiv.appendChild(embed);
                    } else {
                        previewDiv.innerHTML = 'No se puede previsualizar este tipo de archivo';
                    }
                };
                
                reader.readAsDataURL(file);
            } else {
                previewDiv.innerHTML = 'No se seleccionó ningún archivo';
            }
            return true;
        }

        function Valida_Archivo(val){
            Cargando();

            var archivoInput = document.getElementById(val);
            var archivoRuta = archivoInput.value;
            var extPermitidas = /(.pdf|.png|.jpg|.jpeg)$/i;

            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: '¡Carga Denegada!',
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

        function Consultar_Ruc(v){
            Cargando();

            var url = "{{ route('caja_chica.consultar_ruc') }}";
            var ruc = $('#ruc'+v).val();

            $.ajax({
                url: url,
                type: "POST",
                data: {'ruc':ruc},
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success:function (resp) {
                    var texto = resp.trim();
                    var partes = texto.split('@@@');
                    if(partes[0]=="error"){
                        Swal({
                            title: '¡Búsqueda Denegada!',
                            text: partes[1],
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                        $('#razon_social'+v).val('');
                        $('#direccion'+v).val('');
                    }else{
                        $('#razon_social'+v).val(partes[0]);
                        $('#direccion'+v).val(partes[1]);
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

        function Descargar_Archivo(id){
            window.location.replace("{{ route('caja_chica.download', ':id') }}".replace(':id', id));
        }

        function Anular_Caja_Chica(id) {
            Cargando();

            var url = "{{ route('caja_chica.anular', ':id') }}".replace(':id', id);

            Swal({
                title: '¿Realmente desea anular el registro?',
                text: "El registro será anulado permanentemente",
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
                        success: function() {
                            Swal(
                                '¡Anulado!',
                                'El registro ha sido anulado satisfactoriamente.',
                                'success'
                            ).then(function() {
                                Lista_Caja_Chica();
                            });    
                        }
                    });
                }
            })
        }

        function Delete_Caja_Chica(id) {
            Cargando();

            var url = "{{ route('caja_chica.destroy', ':id') }}".replace(':id', id);

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
                                Lista_Caja_Chica();
                            });    
                        }
                    });
                }
            })
        }

        function Excel_Caja_Chica() {
            var fec_inicio = $('#fec_iniciob').val();
            var fec_fin = $('#fec_finb').val();

            var ini = moment(fec_inicio);
            var fin = moment(fec_fin);
            if (ini.isAfter(fin) == true) {
                Swal({
                    title: '¡Selección Denegada!',
                    html: "Fecha inicio no debe ser mayor a fecha fin. <br> Por favor corrígelo.",
                    type: 'error',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
            }else{
                window.location = "{{ route('caja_chica.excel', [':fec_inicio', ':fec_fin']) }}".replace(':fec_inicio', fec_inicio).replace(':fec_fin', fec_fin);
            }
        }
    </script>
@endsection