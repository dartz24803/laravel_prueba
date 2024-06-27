<style>
    .img-presentation-small {
        width: 80%;
        height: 30%;
        cursor: pointer;
        margin: 5px;
    }
</style>

<div class="row justify-content-center">
    @if (count($list_archivo)==0)
        No hay fotos subidas.
    @else
        @foreach ($list_archivo as $list)
            <div id="i_{{ $list->id }}" class="col-lg-4">
                <div id="lista_escogida">
                    <img loading="lazy" class="img_post img-presentation-small" 
                    alt="Evidencia" 
                    src="{{ $list->archivo }}">
                </div>
                <a href="javascript:void(0);" title="Eliminar" onclick="Delete_Archivo('{{ $list->id }}')">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2 text-danger">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </a>
            </div>
        @endforeach
    @endif
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
    
    function Delete_Archivo(id) {
        Cargando();

        var url = "{{ route('tracking.delete_archivo_temporal', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();
        var file_col = $('#i_'+id);

        $.ajax({
            type: "DELETE",
            url: url,
            data: {'id':id},
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
            success: function() {
                Lista_Archivo();
                file_col.remove();          
            }
        });
    }
</script>