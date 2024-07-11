<div class="toolbar mt-5">
    <div class="container" style="padding-left: 0px; padding-right: 0px;">
        <div class="row col-md-12">
            <div class="form-group col-md-2">
                <label for="" class="col-sm-12 control-label text-bold">Tipo</label>
            </div>
            <div class="form-group col-sm-2">
                <select name="base_sr" id="base_sr" class="form-control" onchange="Lista_Slider_Rrhh()">
                    <option value="2">Tienda</option>
                    <?php foreach($list_base as $list){?> 
                        <option value="<?= $list['cod_base']; ?>"><?= $list['cod_base']; ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-sm">
                <div align="left">
                    <?php
                    $funcioncontrolador = base64_encode('Slider_Vista_RRHH');
                    $funcioncontrolador_tienda = base64_encode('Slider_Vista_Tienda');
                    ?>
                    <div id="btn_slide">
                        <a id="hslider" target="_blank" class="btn btn-primary mb-2 mr-2" title="Registrar" href="{{ url('Slider_Vista_RRHH/'.$funcioncontrolador) }}">
                            Visualizar Slide OFC
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-sm">
                <div align="right">
                    <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalRegistroGrande" app_reg_grande="{{ url('Modal_Slider_Rrhh') }}" >
                        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
                        Registrar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@csrf
<div class="table-responsive mb-4 mt-4" id="lista_slider_rrhh">
</div>

<script>
    Lista_Slider_Rrhh();

    function Lista_Slider_Rrhh(){
        Cargando();

        var tipo = $('#base_sr').val();
        var url = "{{ url('Lista_Slider_Rrhh') }}";
        var csrfToken = $('input[name="_token"]').val();

        $.ajax({
            type: "POST",
            url: url,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            data: {'tipo':tipo},
            success: function(data) {
                $('#lista_slider_rrhh').html(data);
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

    function Validar_Archivo(v){
        var tipo_slide = $('#tipo_slide'+v).val();
        var archivoInput = document.getElementById('archivoslide'+v);
        if(tipo_slide=="0"){
            Swal({
                title: '!Ups!',
                text: 'Debe seleccionar previamente tipo de slide.',
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = '';
            return false;
        }else{
            var archivoRuta = archivoInput.value;
            if(tipo_slide=="1"){
                var extPermitidas = /(.jpg|.jpeg|.png)$/i;
                var texto = "La imagen debe estar en formato JPG, JPEG, PNG.";
            }else{
                var extPermitidas = /(.mp4)$/i;
                var texto = "El video debe de estar en formato MP4.";
            }
            if(!extPermitidas.exec(archivoRuta)){
                Swal({
                    title: '!Archivo no permitido!',
                    text: texto,
                    type: 'warning',
                    showCancelButton: false,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK',
                });
                archivoInput.value = '';
                return false;
            }
        }
    }

    function Valida_Slider_Rrhh(v) {
        if ($('#tipo'+v).val() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#orden'+v).val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Orden.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#entrada_slide'+v).val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Tiempo de entrada.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#salida_slide'+v).val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Tiempo de salida.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#entrada_slide'+v).val() > '2.0') {
            Swal(
                'Ups!',
                'Debe ingresar Tiempo de entrada menor que 2.0 segundos.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#salida_slide'+v).val() > '2.0') {
            Swal(
                'Ups!',
                'Debe ingresar Tiempo de salida menor que 2.0 segundos.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#duracion'+v).val().trim() === '') {
            Swal(
                'Ups!',
                'Debe ingresar Tiempo de duración.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#tipo_slide'+v).val() == '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Tipo de slide.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#archivoslide'+v).val() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Archivo.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Delete_Slider_Rrhh(id) {
        Cargando();
        var csrfToken = $('input[name="_token"]').val();
        var url = "{{ url('Delete_Slider_Rrhh') }}";

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
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {'id_slide': id},
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Slider_Rrhh();
                        });
                    }
                });
            }
        })
    }
</script>