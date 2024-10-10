<style>
    #modal_css {
        background: white;
    }

    #nombres_css,
    #apellidos_css,
    #puesto_css,
    #base_css {
        color: #7F7F7F;
        font-weight: bold;
    }

    #button_css {
        background: #00B1F4 !important;
        border-color: #00B1F4;
        color: #FFF;
    }

    #button_css:hover {
        background: #5CCDF8 !important;
        border-color: #5CCDF8;
        color: #FFF;
    }
</style>

<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="toolbar d-md-flex align-items-md-center mt-3">
        <div class="col-lg-2">
            <label class="control-label text-bold">Horario:</label>
            <div class="n-chk">
                <label class="new-control new-radio radio-primary">
                    <input type="radio" class="new-control-input" name="horario_registro" value="1" @if (date('H:i:s')<"12:00:00") checked @endif>
                    <span class="new-control-indicator"></span><span class="new-radio-content">Ingreso</span>
                </label>
            </div>
            <div class="n-chk">
                <label class="new-control new-radio radio-primary">
                    <input type="radio" class="new-control-input" name="horario_registro" value="2" @if (date('H:i:s')>="12:00:00") checked @endif>
                    <span class="new-control-indicator"></span><span class="new-radio-content">Salida</span>
                </label>
            </div>
        </div>

        @if (session('usuario')->id_puesto==19 ||
        session('usuario')->id_puesto==23 ||
        session('usuario')->id_puesto==24 ||
        session('usuario')->id_nivel==1)
        <div class="form-group col-lg-2">
            <label>Base:</label>
            <select class="form-control" id="cod_base" name="cod_base">
                @foreach ($list_base as $list)
                <option value="{{ $list->cod_base }}"
                    @if ($list->cod_base==session('usuario')->centro_labores) selected @endif>
                    {{ $list->cod_base }}
                </option>
                @endforeach
            </select>
        </div>
        @endif

        <div class="form-group col-lg-2">
            @csrf
            <label>N° Documento:</label>
            <input type="text" class="form-control" name="num_doc" id="num_doc" placeholder="N° Documento"
                onkeypress="return solo_Numeros(event);" autofocus
                onkeydown="if(event.keyCode == 13){ Insert_Asistencia_Lectora(); }">
        </div>

        <div class="col-lg-1">
            <a class="btn mb-2 mb-sm-0 mb-md-2 mb-lg-0" style="background-color: #28a745 !important;" onclick="Excel_Lectora();">
                <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;">
                    <g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal">
                        <path d="M0,172v-172h172v172z" fill="none"></path>
                        <g fill="#ffffff">
                            <path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path>
                        </g>
                    </g>
                </svg>
            </a>
        </div>
        <div class="form-group col-lg-2">
            <label>Fecha desde: </label>
            <input class="form-control" type="date" name="fec_desde" id="fec_desde">
        </div>
        <div class="form-group col-lg-2">
            <label>Fecha hasta:</label>
            <input class="form-control" type="date" name="fec_hasta" id="fec_hasta">
        </div>
        <div class="form-group col-lg-2">
            <button type="button" class="btn btn-primary mb-2 mb-sm-0 mb-md-2 mb-lg-0" title="Registrar" onclick="Lista_Lectora();">
                Buscar
            </button>
        </div>
    </div>
</form>

@csrf
<div class="table-responsive mb-4 mt-4" id="lista_lectora">
</div>

<div class="modal fade profile-modal" id="modal_asistencia_lectora" tabindex="-1" role="dialog" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div id="modal_css" class="modal-content">
            <div class="justify-content-end mt-3 mr-3">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <svg fill="#00B1F4" height="14px" width="14px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 460.775 460.775" xml:space="preserve">
                        <path d="M285.08,230.397L456.218,59.27c6.076-6.077,6.076-15.911,0-21.986L423.511,4.565c-2.913-2.911-6.866-4.55-10.992-4.55
                        c-4.127,0-8.08,1.639-10.993,4.55l-171.138,171.14L59.25,4.565c-2.913-2.911-6.866-4.55-10.993-4.55
                        c-4.126,0-8.08,1.639-10.992,4.55L4.558,37.284c-6.077,6.075-6.077,15.909,0,21.986l171.138,171.128L4.575,401.505
                        c-6.074,6.077-6.074,15.911,0,21.986l32.709,32.719c2.911,2.911,6.865,4.55,10.992,4.55c4.127,0,8.08-1.639,10.994-4.55
                        l171.117-171.12l171.118,171.12c2.913,2.911,6.866,4.55,10.993,4.55c4.128,0,8.081-1.639,10.992-4.55l32.709-32.719
                        c6.074-6.075,6.074-15.909,0-21.986L285.08,230.397z" />
                    </svg>
                </button>
            </div>

            <div class="modal-header justify-content-center" id="profileModalLabel">
                <div id="foto_confirmacion" class="modal-profile mt-4">
                </div>
            </div>

            <div class="modal-body text-center">
                <div id="nombres_confirmacion" class="col-12">
                </div>
                <div id="apellidos_confirmacion" class="col-12 mb-3">
                </div>
                <div id="puesto_confirmacion" class="col-12 mb-3">
                </div>
                <div id="base_confirmacion" class="col-12">
                </div>
            </div>

            <div class="modal-footer justify-content-center mb-4">
                <button id="button_css" type="button" class="btn" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

<script>
    Lista_Lectora();

    function Lista_Lectora() {
        Cargando();

        var url = "{{ url('asistencia_seg_lec/list') }}";
        var csrfToken = $('input[name="_token"]').val();
        var fec_desde = $('#fec_desde').val();
        var fec_hasta = $('#fec_hasta').val();

        $.ajax({
            url: url,
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {
                'fec_desde': fec_desde,
                'fec_hasta': fec_hasta
            },
            success: function(resp) {
                $('#lista_lectora').html(resp);
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

    function Valida_Archivo(val) {
        Cargando();

        var archivoInput = document.getElementById(val);
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.pdf|.png|.jpg|.jpeg)$/i;

        if (!extPermitidas.exec(archivoRuta)) {
            Swal({
                title: 'Registro Denegado',
                text: "Asegurese de ingresar archivo con extensión .pdf | .jpg | .png | .jpeg",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = '';
            return false;
        } else {
            return true;
        }
    }

    function Descargar_Archivo(id) {
        window.location.replace("{{ route('asistencia_seg_lec.download', ':id') }}".replace(':id', id));
    }

    function Insert_Asistencia_Lectora() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('asistencia_seg_lec.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if (data == "error") {
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡No se encontró al colaborador!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else if (data == "sin_ingreso") {
                    Swal({
                        title: 'Registro Denegado',
                        text: "¡No se ha registrado el ingreso del colaborador!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                } else {
                    $('#foto_confirmacion').html('<img alt="avatar" width="90" height="90" src="' + data.split("*")[0] + '" class="rounded-circle">');
                    $('#nombres_confirmacion').html('<span id="nombres_css">' + data.split("*")[1] + '</span>');
                    $('#apellidos_confirmacion').html('<span id="apellidos_css">' + data.split("*")[2] + '</span>');
                    $('#puesto_confirmacion').html('<span id="puesto_css">' + data.split("*")[3] + '</span>');
                    $('#base_confirmacion').html('<span id="base_css">' + data.split("*")[4] + '</span>');
                    $("#num_doc").val('');
                    $('#modal_asistencia_lectora').modal('show');
                    Lista_Lectora();
                    setTimeout(function() {
                        $('#modal_asistencia_lectora').modal("hide");
                    }, 4000);
                }
            },
            error: function(xhr) {
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

    function Delete_Lectora(id) {
        Cargando();

        var url = "{{ route('asistencia_seg_lec.destroy', ':id') }}".replace(':id', id);
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
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Lectora();
                        });
                    }
                });
            }
        })
    }

    function Excel_Lectora() {
        window.location = "{{ route('asistencia_seg_lec.excel') }}";
    }
</script>
