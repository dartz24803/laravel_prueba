<div class="toolbar d-md-flex align-items-md-center mt-3">
    @if (session('usuario')->id_puesto==19 || 
    session('usuario')->id_puesto==21 || 
    session('usuario')->id_puesto==279 || 
    session('usuario')->id_puesto==23 || 
    session('usuario')->id_puesto==24 || 
    session('usuario')->id_nivel==1 || 
    session('usuario')->id_puesto==22 || 
    session('usuario')->id_puesto==209)
        <div class="form-group col-lg-2">
            <label>Base:</label>
            <select class="form-control" id="cod_baseb" name="cod_baseb" onchange="Traer_Colaborador('b'); Lista_Manual();">
                <option value="0">TODOS</option>
                @foreach ($list_base as $list)
                    <option value="{{ $list->cod_base }}">
                        {{ $list->cod_base }}
                    </option>
                @endforeach
            </select>
        </div>
    @else
        <input type="text" name="cod_baseb" id="cod_baseb" value="{{ session('usuario')->centro_labores }}">
    @endif

    <div class="form-group col-lg-3 mt-4">
        <label>Colaborador:</label>
        <select class="form-control basic" id="id_colaboradorb" name="id_colaboradorb" onchange="Lista_Manual();">
            <option value="0">TODOS</option>
            @foreach ($list_colaborador as $list)
                <option value="{{ $list->id_usuario }}">
                    {{ $list->nom_usuario }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-lg-2">
        <label>Fecha Inicio:</label>
        <input type="date" class="form-control" name="fecha_iniciob" id="fecha_iniciob" value="{{ date('Y-m-d') }}">
    </div>

    <div class="form-group col-lg-2">
        <label>Fecha Fin:</label>
        <input type="date" class="form-control" name="fecha_finb" id="fecha_finb" value="{{ date('Y-m-d') }}">
    </div>

    <div class="col-lg-3">
        <button type="button" class="btn btn-primary mb-2 mb-sm-0 mb-md-2 mb-lg-0" title="Registrar" onclick="Lista_Manual();">
            Buscar
        </button>

        <button type="button" class="btn btn-primary mb-2 mb-sm-0 mb-md-2 mb-lg-0" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('asistencia_seg_man.create') }}">
            Nuevo
        </button>

        <a class="btn mb-2 mb-sm-0 mb-md-2 mb-lg-0 mt-lg-2 mt-xl-0" style="background-color: #28a745 !important;" onclick="Excel_Lectora();">
            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="64" height="64" viewBox="0 0 172 172" style=" fill:#000000;"><g fill="none" fill-rule="nonzero" stroke="none" stroke-width="1" stroke-linecap="butt" stroke-linejoin="miter" stroke-miterlimit="10" stroke-dasharray="" stroke-dashoffset="0" font-family="none" font-weight="none" font-size="none" text-anchor="none" style="mix-blend-mode: normal"><path d="M0,172v-172h172v172z" fill="none"></path><g fill="#ffffff"><path d="M94.42993,6.41431c-0.58789,-0.021 -1.17578,0.0105 -1.76367,0.11548l-78.40991,13.83642c-5.14404,0.91333 -8.88135,5.3645 -8.88135,10.58203v104.72852c0,5.22803 3.7373,9.6792 8.88135,10.58203l78.40991,13.83643c0.46191,0.08398 0.93433,0.11548 1.39624,0.11548c1.88965,0 3.71631,-0.65088 5.17554,-1.87915c1.83716,-1.53272 2.88696,-3.7898 2.88696,-6.18335v-12.39819h51.0625c4.44067,0 8.0625,-3.62183 8.0625,-8.0625v-96.75c0,-4.44067 -3.62183,-8.0625 -8.0625,-8.0625h-51.0625v-12.40869c0,-2.38306 -1.0498,-4.64014 -2.88696,-6.17285c-1.36474,-1.15479 -3.05493,-1.80566 -4.8081,-1.87915zM94.34595,11.7998c0.68237,0.06299 1.17578,0.38843 1.43823,0.60889c0.36743,0.30444 0.96582,0.97632 0.96582,2.05762v137.68188c0,1.0918 -0.59839,1.76367 -0.96582,2.06812c-0.35693,0.30444 -1.11279,0.77685 -2.18359,0.58789l-78.40991,-13.83643c-2.57202,-0.45142 -4.44067,-2.677 -4.44067,-5.29102v-104.72852c0,-2.61401 1.86865,-4.8396 4.44067,-5.29102l78.39941,-13.83642c0.27295,-0.04199 0.5249,-0.05249 0.75586,-0.021zM102.125,32.25h51.0625c1.48022,0 2.6875,1.20728 2.6875,2.6875v96.75c0,1.48022 -1.20728,2.6875 -2.6875,2.6875h-51.0625v-16.125h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625v-10.75h8.0625c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875h-8.0625zM120.9375,48.375c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM34.46509,53.79199c-0.34643,0.06299 -0.68237,0.18897 -0.99732,0.38843c-1.23877,0.80835 -1.5957,2.47754 -0.78735,3.72681l16.52393,25.40527l-16.52393,25.40527c-0.80835,1.24927 -0.45141,2.91846 0.78735,3.72681c0.46191,0.29395 0.96582,0.43042 1.46973,0.43042c0.87134,0 1.74268,-0.43042 2.25708,-1.21777l15.21167,-23.41064l15.21167,23.41064c0.51441,0.78735 1.38574,1.21777 2.25708,1.21777c0.50391,0 1.00781,-0.13647 1.46973,-0.43042c1.23877,-0.80835 1.5957,-2.47754 0.78735,-3.72681l-16.52393,-25.40527l16.52393,-25.40527c0.80835,-1.24927 0.45142,-2.91846 -0.78735,-3.72681c-1.24927,-0.80835 -2.91846,-0.45141 -3.72681,0.78735l-15.21167,23.41065l-15.21167,-23.41065c-0.60889,-0.93433 -1.70068,-1.36474 -2.72949,-1.17578zM120.9375,64.5c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,80.625c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,96.75c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875zM120.9375,112.875c-1.48022,0 -2.6875,1.19678 -2.6875,2.6875c0,1.49072 1.20728,2.6875 2.6875,2.6875h16.125c1.48022,0 2.6875,-1.19678 2.6875,-2.6875c0,-1.49072 -1.20728,-2.6875 -2.6875,-2.6875z"></path></g></g></svg>                                
        </a>
    </div>
</div>

@csrf
<div class="table-responsive mb-4" id="lista_manual">
</div>

<script>
    var ss = $(".basic").select2({
        tags: true,
    });

    Lista_Manual();

    function Lista_Manual(){
        Cargando();

        var cod_base = $('#cod_baseb').val();
        var id_colaborador = $('#id_colaboradorb').val();
        var fecha_inicio = $('#fecha_iniciob').val();
        var fecha_fin = $('#fecha_finb').val();
        var url = "{{ route('asistencia_seg_man.list') }}";
        var csrfToken = $('input[name="_token"]').val();

        var ini = moment(fecha_inicio);
        var fin = moment(fecha_fin);
        if (ini.isAfter(fin) == true) {
            Swal({
                title: '¡Selección Denegada!',
                html: "Fecha inicio no debe ser mayor a fecha fin. <br> Por favor corrígelo. ",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
        }else if(fin.diff(ini, 'days')>31){
            Swal({
                title: '¡Selección Denegada!',
                text: "Solo se permite búsquedas de hasta 31 días",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
        }else{
            $.ajax({
                url: url,
                type: "POST",
                data: {'cod_base':cod_base,'id_colaborador':id_colaborador,'fecha_inicio':fecha_inicio,'fecha_fin':fecha_fin},
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success:function (resp) {
                    $('#lista_manual').html(resp);  
                }
            });
        }
    }

    function Traer_Colaborador(v){
        Cargando();

        var url = "{{ route('asistencia_seg_man.traer_colaborador') }}";
        var cod_base = $('#cod_base'+v).val();
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            url: url,
            type: "POST",
            data: {'cod_base':cod_base,'validacion':v},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success:function (resp) {
                $('#id_colaborador'+v).html(resp);
            }
        });
    }

    function Valida_Archivo(val){
        Cargando();

        var archivoInput = document.getElementById(val);
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.pdf|.png|.jpg|.jpeg)$/i;

        if(!extPermitidas.exec(archivoRuta)){
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
        }else{
            return true;         
        }
    }

    function Delete_Manual(id) {
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
                            Lista_Manual();
                        });    
                    }
                });
            }
        })
    }

    function Excel_Lectora() {
        var cod_base = $('#cod_baseb').val();
        var id_colaborador = $('#id_colaboradorb').val();
        var fecha_inicio = $('#fecha_iniciob').val();
        var fecha_fin = $('#fecha_finb').val();
        window.location = "{{ route('asistencia_seg_man.excel', [':cod_base', ':id_colaborador', ':fecha_inicio', ':fecha_fin']) }}".replace(':cod_base', cod_base).replace(':id_colaborador', id_colaborador).replace(':fecha_inicio', fecha_inicio).replace(':fecha_fin', fecha_fin);
    }
</script>