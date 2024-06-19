<div class="modal-header">
    <h5 class="modal-title">Evidencia(s):</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
</div>
            
<div class="modal-body" style="max-height:700px; overflow:auto;">
    @if (count($list_archivo)>0)
        <div class="row ml-2 mr-2">
            @foreach ($list_archivo as $list)
                <div id="i_{{ $list->id }}" class="col-lg-3">
                    <div id="lista_escogida">
                        <img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" 
                        alt="Evidencia" 
                        src="{{ $list->archivo }}">
                    </div>
                    <a href="javascript:void(0);" title="Descargar" onclick="Descargar_Evidencia('{{ $list->id }}');">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download-cloud text-dark">
                            <polyline points="8 17 12 21 16 17"></polyline>
                            <line x1="12" y1="12" x2="12" y2="21"></line>
                            <path d="M20.88 18.09A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.29"></path>
                        </svg>
                    </a>
                </div>
            @endforeach
        </div>
    @endif        	                	        
</div>

<div class="modal-footer">
    <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
</div>

<script>
    $(".img_post").click(function () {
        var popupWidth = this.naturalWidth;
        var popupHeight = this.naturalHeight;
        
        // Calcular las coordenadas X e Y para centrar la ventana emergente
        var leftPosition = (window.screen.width - popupWidth) / 2;
        var topPosition = (window.screen.height - popupHeight) / 2;

        // Abrir la ventana emergente en el centro de la pantalla
        window.open($(this).attr("src"), 'popUpWindow', "height=" + popupHeight + ",width=" + popupWidth + ",top=" + topPosition + ",left=" + leftPosition + ",resizable=yes,toolbar=yes,menubar=no");
    });
</script>