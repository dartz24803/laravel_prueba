<div class="toolbar d-flex justify-content-end">
    <button type="button" class="btn btn-primary mb-2 mr-2" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg_metalikas="<?= site_url('Recursos_Humanos/Modal_Anuncio_Intranet') ?>" >
        <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
        Registrar
    </button>
</div>

<div class="table-responsive mb-4 mt-4" id="lista_anuncio_intranet">
</div>

<script>
    Lista_Anuncio_Intranet();

    function Lista_Anuncio_Intranet(){
        Cargando();

        var url = "<?php echo site_url(); ?>Recursos_Humanos/Lista_Anuncio_Intranet";
        
        $.ajax({
            type: "POST",
            url: url,
            success: function(data) {
                $('#lista_anuncio_intranet').html(data);
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

    function Validar_Archivo(v){
        var archivoInput = document.getElementById('imagen'+v);
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.jpeg|.png|.jpg)$/i;
  
        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: '!Archivo no permitido!',
                text: "Asegurese de ingresar archivo PNG, JPEG o JPG.",
                type: 'warning',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = '';
            return false;
        }else{
            /*let img = new Image()
            img.src = window.URL.createObjectURL(event.target.files[0])
            img.onload = () => {
                if(img.width==1280 && img.height==852){*/
                    return true;
                /*}else{
                    Swal({
                        title: '!Archivo no permitido!',
                        text: "Asegurese de ingresar imagen de 1280x852.",
                        type: 'warning',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                    archivoInput.value = '';
                    return false;
                }                
            }*/
        }
    }
    
    function Valida_Anuncio_Intranet(v) {
        if ($('#cod_base'+v).val().trim() === '0') {
            Swal(
                'Ups!',
                'Debe seleccionar Base.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#orden'+v).val().trim() === '') {
            Swal(
                'Ups!',
                'Debe seleccionar Orden.',
                'warning'
            ).then(function() { });
            return false;
        }
        if ($('#imagen'+v).val().trim() === '' && v!="e") {
            Swal(
                'Ups!',
                'Debe seleccionar Imagen.',
                'warning'
            ).then(function() { });
            return false;
        }
        return true;
    }

    function Delete_Anuncio_Intranet(id) {
        Cargando();

        var url = "<?php echo site_url(); ?>Recursos_Humanos/Delete_Anuncio_Intranet";

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
                    data: {'id_bolsa_trabajo': id},
                    success: function() {
                        Swal(
                            'Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Anuncio_Intranet();
                        });
                    }
                });
            }
        })
    }
</script>