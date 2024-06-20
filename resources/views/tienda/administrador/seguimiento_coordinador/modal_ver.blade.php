<div class="modal-header">
    <h5 class="modal-title">Ver seguimiento al coordinador:</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
    </button>
</div> 

<div class="modal-body" style="max-height:700px; overflow:auto;">
    <div class="row ml-2 mr-2">
        <table class="table">
            <tr>
                <td><label class="control-label text-bold">Si</label></td>
                <td><label class="control-label text-bold">No</label></td>
                <td><label class="control-label text-bold">Tarea</label></td>
                <td><label class="control-label text-bold">Periocidad</label></td>
            </tr>
            @foreach ($list_contenido as $list)
                <tr>
                    <td>
                        <div class="radio-buttons">
                            <label class="radio-button radio-button-si">
                                <input type="radio" value="1" 
                                @if ($list_detalle->pluck('id_contenido')->contains($list->id))
                                    @php
                                        $posicion = $list_detalle->search(function($item) use ($list) {
                                            return $item->id_contenido == $list->id;
                                        });
                                    @endphp

                                    @if ($list_detalle[$posicion]->valor == 1)
                                        checked
                                    @endif
                                @endif disabled>
                                <div class="radio-circle"></div>
                            </label>
                        </div>
                    </td>
                    <td> 
                        <div class="radio-buttons">
                            <label class="radio-button radio-button-no">
                                <input type="radio" value="2"
                                @if ($list_detalle->pluck('id_contenido')->contains($list->id))
                                    @php
                                        $posicion = $list_detalle->search(function($item) use ($list) {
                                            return $item->id_contenido == $list->id;
                                        });
                                    @endphp

                                    @if ($list_detalle[$posicion]->valor == 2)
                                        checked
                                    @endif
                                @endif disabled>
                                <div class="radio-circle"></div>
                            </label>
                        </div>
                    </td>
                    <td>
                        <label class="control-label text-bold">{{ $list->descripcion }}</label>
                    </td>
                    <td class="text-center">
                        <label class="control-label text-bold">{{ $list->periocidad }}</label>
                    </td>
                </tr>
            @endforeach
        </table>
    </div>

    <div class="row ml-2 mr-2">
        <div class="form-group col-md-12">
            <label class="control-label text-bold">Observación: </label>
            <textarea class="form-control" rows="5" placeholder="Observación" disabled>{{ $get_id->observacion }}</textarea>
        </div>  
    </div>

    @if (count($list_archivo)>0)
        <div class="row ml-2 mr-2">
            <label class="control-label text-bold">Evidencia(s) actual(es): <a href="#" title="Estos archivos sirven como evidencia del seguimiento al coordinador" class="anchor-tooltip tooltiped"><div class="divdea">?</div></a></label>
        </div>
        <div class="row ml-2 mr-2">
            @foreach ($list_archivo as $list)
                <div class="col-lg-3">
                    <div>
                        <img loading="lazy" class="img_post img-thumbnail img-presentation-small-actualizar_support" 
                        alt="Evidencia" 
                        src="{{ $list->archivo }}">
                    </div>
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