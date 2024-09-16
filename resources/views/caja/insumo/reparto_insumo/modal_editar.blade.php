<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar reparto de insumo:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div> 

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Insumo:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_insumoe" id="id_insumoe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_insumo as $list)
                        <option value="{{ $list->id_insumo }}"
                        @if ($list->id_insumo==$get_id->id_insumo) selected @endif>
                            {{ $list->nom_insumo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Base:</label>
            </div>
            <div class="form-group col-lg-4">
                @if (session('usuario')->id_puesto=="31" || session('usuario')->id_puesto=="32")
                    <input type="text" class="form-control" name="cod_basee" id="cod_basee" 
                    value="{{ $get_id->cod_base }}" readonly>
                @else
                    <select class="form-control" name="cod_basee" id="cod_basee">
                        <option value="0">Seleccione</option>
                        @foreach ($list_base as $list)
                            <option value="{{ $list->cod_base }}"
                            @if ($list->cod_base==$get_id->cod_base) selected @endif>
                                {{ $list->cod_base }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" name="fec_repartoe" id="fec_repartoe"
                value="{{ $get_id->fec_reparto }}">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Cantidad:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="cantidad_repartoe" id="cantidad_repartoe" 
                placeholder="Cantidad" onkeypress="return solo_Numeros(event);" value="{{ $get_id->cantidad_reparto }}">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Reparto_Insumo();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_Reparto_Insumo() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('insumo_ra.update', $get_id->id_reparto_insumo) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="error"){
                    Swal({
                        title: '¡Actualización Denegada!',
                        text: "¡La cantidad de reparto no puede ser mayor al stock actual!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        '¡Actualización Exitosa!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Izquierda();
                        Lista_Derecha();
                        $("#ModalUpdate .close").click();
                    });  
                }
            },
            error:function(xhr) {
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
</script>