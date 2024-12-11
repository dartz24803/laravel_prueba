
<div class="modal-header" style="background-color: #add8e6ed;">
    <h5 class="modal-title">Feliz Cumpleañoooos!! 🎈🎊🥳🎉🎉🍾🎊🎈</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
</div> 

<div class="modal-body" style="max-height:450px; overflow:auto; background-color: #add8e6ed;">
    <div class="col-md-12 row">
        <div class="form-group col-md-12 text-center contenedor_gif">
            <img class="fondo-imagen" style="max-width:100%;" src="https://lanumerounocloud.com/intranet/PERFIL/Saludo_Temporal/{{ $get_id->archivo }}">
            <div class="gif-overlay col-md-12"></div>
        </div>
    </div>                                
</div>

<style>
    .modal-body{
        max-height: 565px !important;
    }
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