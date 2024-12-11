
<div class="modal-header" style="background-color: #add8e6ed;">
    <div class="col-md-12 row">
        <h5 class="modal-title col-md-12 text-center">Feliz Cumpleañoooos!! 🎈🎊🥳🎉🎉🍾🎊🎈</h5>
    </div>
</div> 

<div class="modal-body" style="max-height:565px; overflow:auto; background-color: #add8e6ed;">
    <div class="col-md-12 row">
        <div class="form-group col-md-12 text-center contenedor_gif">
            <img class="fondo-imagen" style="max-width:100%;" src="https://lanumerounocloud.com/intranet/PERFIL/Saludo_Temporal/{{ $get_id->archivo }}">
            <div class="gif-overlay col-md-12"></div>
        </div>
    </div>                                
</div>

<style>
    .contenedor_gif {
        position: relative; /* Crea un contexto de posición */
    }

    .fondo-imagen {
        position: relative;
        z-index: 1; /* Coloca la imagen en un nivel más bajo */
    }

    .gif-overlay {
        position: absolute;
        top: 2%;
        left: 2%;
        width: 88%;
        height: 88%;
        background-image: url('{{ asset('template/assets/especiales/fuego1.gif') }}');
        background-size: cover;
        background-position: center;
        background-repeat: no-repeat;
        z-index: 2; /* Coloca el GIF encima de la imagen */
        pointer-events: none; /* Permite interacción con elementos debajo del GIF */
    }
</style>
<script>
    $(document).ready(function() {
        $(document).on('click', function(event) {
            // Verificar si el clic está fuera del modal
            if (!$(event.target).closest('.modal-content').length && $('.modal.show').length) {
                $('#ModalUpdateSlide').modal('hide'); // Cierra el modal
            }
        });
    });
</script>