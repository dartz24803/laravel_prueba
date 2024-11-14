<link href="{{ asset('template/smart_wizard/style.css')}}" rel="stylesheet" type="text/css" />
<script src="https://cdn.jsdelivr.net/npm/smartwizard@6/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>

<div class="toolbar d-flex mt-3">
    <div class="col-lg-12 d-flex justify-content-end">
        <a href="{{ route('tracking.detalle_transporte_inicial') }}" class="btn btn-danger" 
        title="Detalle de transporte inicial">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-truck">
                <rect x="1" y="3" width="15" height="13"></rect>
                <polygon points="16 8 20 8 23 11 23 16 16 16 16 8"></polygon>
                <circle cx="5.5" cy="18.5" r="2.5"></circle>
                <circle cx="18.5" cy="18.5" r="2.5"></circle>
            </svg>
        </a>
        <!-- PUESTO DE MAYRA TORRES (76) y JAIME SAAVEDRA (97) -->
        @if (session('usuario')->id_puesto==76 ||
        session('usuario')->id_puesto==97 ||
        session('usuario')->id_nivel==1)
            <a class="btn btn-warning" title="Guía remisión de transporte" data-toggle="modal" 
            data-target="#ModalRegistro" app_reg="{{ route('tracking.modal_guia_transporte') }}">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                    <polyline points="10 9 9 9 8 9"></polyline>
                </svg>
            </a>
        @endif
        <a href="{{ route('tracking.pago_transporte_general') }}" class="btn btn-primary" 
        title="Pago de transporte">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-credit-card">
                <rect x="1" y="4" width="22" height="16" rx="2" ry="2"></rect>
                <line x1="1" y1="10" x2="23" y2="10"></line>
            </svg>
        </a>  
        <a title="Actualizar" class="btn btn-dark" onclick="Tracking();">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw">
                <polyline points="23 4 23 10 17 10"></polyline>
                <polyline points="1 20 1 14 7 14"></polyline>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
            </svg>
        </a>
        <!--<button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('tracking.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Registrar
        </button>-->
        <!--<a title="Actualizar" class="btn btn-danger" onclick="Iniciar_Tracking();">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-refresh-cw">
                <polyline points="23 4 23 10 17 10"></polyline>
                <polyline points="1 20 1 14 7 14"></polyline>
                <path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path>
            </svg>
        </a>-->
        <a type="button" class="btn btn-@php if($list_mercaderia_nueva){ "light"; }else{ echo "info"; } @endphp p-2" href="{{ route('tracking.mercaderia_nueva') }}">
            MERCADERÍA NUEVA
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 207.96 230.17" style="fill: yellow; margin-left:10px;">
                <path d="M973.47,431.83h5c7.77,2.87,10.63,8.51,8.84,16.6,2.58.52,4.69.89,6.77,1.36,17.35,4,30.83,12.86,35.88,30.81,1.85,6.61,2,13.79,2.31,20.74,1.92,41,14.94,77.13,45.92,105.52a6.81,6.81,0,0,1,1.5,5.52c-1.61,7.69-8.13,12.32-17.09,12.36-16.33.08-32.66,0-49,0H937.83c-16.17,0-32.33,0-48.49,0-8.53,0-14.69-4.36-17-11.36-1-3-.56-5.11,2-7.36a121.64,121.64,0,0,0,28-36.1c12-23.41,17.13-48.37,17.52-74.58.35-23.82,12.09-38.42,35.12-44.8,3.13-.86,6.33-1.47,9.42-2.18C963.84,438.11,965.13,435.82,973.47,431.83Z" transform="translate(-871.83 -431.83)"/>
                <circle cx="103.17" cy="199.17" r="31"/>
            </svg>
        </a>
    </div>
</div>

<div class="table-responsive mt-4" id="lista_tracking">
</div>

<script>
    Lista_Tracking();

    function Iniciar_Tracking(){
        Cargando();

        var url = "{{ route('tracking.iniciar_tracking') }}";

        $.ajax({
            url: url,
            type: "GET",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success:function (resp) {
                Lista_Tracking();
            }
        });
    }

    function Lista_Tracking(){
        Cargando();

        var url = "{{ route('tracking.list') }}";

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success:function (resp) {
                $('#lista_tracking').html(resp);  
            }
        });
    }

    function soloNumeros(e) {
        var key = e.keyCode || e.which,
        tecla = String.fromCharCode(key).toLowerCase(),
        letras = "0123456789",
        especiales = [8, 37, 39, 46],
        tecla_especial = false;

        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }

        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
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

    function Limpiar_Ifile(val){
        $('#'+val+'').val('');
    }
</script>