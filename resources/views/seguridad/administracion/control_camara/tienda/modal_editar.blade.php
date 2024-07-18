<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar tienda:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Sede:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_sedee" id="id_sedee">
                    <option value="0">Seleccione</option>
                    @foreach ($list_sede as $list)
                        <option value="{{ $list->id_sede }}" 
                        @if ($list->id_sede==$get_id->id_sede) selected @endif>
                            {{ $list->nombre_sede }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Local:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_locale" id="id_locale">
                    <option value="0">Seleccione</option>
                    @foreach ($list_local as $list)
                        <option value="{{ $list->id_local }}"
                        @if ($list->id_local==$get_id->id_local) selected @endif>
                            {{ $list->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <input type="checkbox" name="ronda" id="ronda" value="1" 
                @if ($get_id->ronda=="1") checked @endif onclick="Traer_Ronda();">
                <label for="ronda">Rondas:</label>
            </div>
            <div class="form-group col-lg-10" id="div_rondas">
                @if ($get_id->ronda=="1")
                    <select class="form-control multivalue" name="rondas[]" id="rondas" multiple="multiple">
                        @foreach ($list_ronda as $list)
                            <option value="{{ $list->id }}"
                            @if(in_array($list->id, array_column($list_tienda_ronda, 'id_ronda'))) selected @endif>
                                {{ $list->descripcion }}
                            </option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button" onclick="Update_Tienda();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('.multivalue').select2({
        dropdownParent: $('#ModalUpdate')
    });

    function Traer_Ronda(){
        Cargando();

        if($('#ronda').is(':checked')){
            var url = "{{ route('control_camara_conf_ti.traer_ronda') }}";
            var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                type: "GET",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(data) {
                    $('#div_rondas').html(data);
                }
            });
        }else{
            $('#div_rondas').html('');
        }
    }

    function Update_Tienda() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('control_camara_conf_ti.update', $get_id->id_tienda) }}";

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
                        text: "¡El registro ya existe!",
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
                        Lista_Tienda();
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