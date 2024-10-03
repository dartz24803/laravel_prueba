<style>
    input[type="radio"]:disabled + label {
        color: inherit !important;
    }
</style>

<form id="formulariou" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title"> @if ($tipo=="1") Actualizar @else Ver @endif N° único:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-12">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="letra_descuento" name="tipo_nunicou" 
                    class="custom-control-input" value="1" onclick="Tipo_Nunico();"
                    @if ($get_id->tipo_nunico=="1") checked @endif
                    @if ($tipo=="2") disabled @endif>
                    <label class="custom-control-label" for="letra_descuento">Letra en descuento</label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="letra_cartera" name="tipo_nunicou" 
                    class="custom-control-input" value="2" onclick="Tipo_Nunico();"
                    @if ($get_id->tipo_nunico=="2") checked @endif
                    @if ($tipo=="2") disabled @endif>
                    <label class="custom-control-label" for="letra_cartera">Letra en cartera</label>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-6 div_nunicou" 
            style="display: @php if($get_id->tipo_nunico=="1"){ echo "block;"; }else{ echo "none;"; } @endphp">
                <label>N° único:</label>
                <input type="text" class="form-control" id="num_unicou" name="num_unicou" 
                placeholder="N° único" value="{{ $get_id->num_unico }}" maxlength="20" 
                @if ($tipo=="2") disabled @endif>
            </div>

            <div class="form-group col-lg-6 div_ncuentau"
            style="display: @php if($get_id->tipo_nunico=="2"){ echo "block;"; }else{ echo "none;"; } @endphp">
                <label>N° cuenta:</label>
                <input type="text" class="form-control" id="num_cuentau" name="num_cuentau" 
                placeholder="N° cuenta" value="{{ $get_id->num_cuenta }}" maxlength="20" 
                @if ($tipo=="2") disabled @endif>
            </div>

            <div class="form-group col-lg-6">
                <label>Banco:</label>
                <select class="form-control basicu" name="bancou" id="bancou" 
                @if ($tipo=="2") disabled @endif>
                    <option value="0">Seleccione</option>
                    @foreach ($list_banco as $list)
                        <option value="{{ $list->id_banco }}"
                        @if ($list->id_banco==$get_id->banco) selected @endif>
                            {{ $list->nom_banco }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        @if ($tipo=="1")
            <button class="btn btn-primary" type="button" onclick="Update_Unico();">Guardar</button>
        @endif
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".basicu").select2({
        tags: true,
        dropdownParent: $('#ModalUpdate')
    });

    function Tipo_Nunico() {
        $('#num_unicou').val('');
        $('#num_cuentau').val('');
        if ($('#letra_descuento').is(":checked")){
            $('.div_nunicou').show();
            $('.div_ncuentau').hide();
        }else{
            $('.div_nunicou').hide();
            $('.div_ncuentau').show();
        }
    }

    function Update_Unico() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulariou'));
        var url = "{{ route('letra_cobrar.update_unico', $get_id->id_cheque_letra) }}";

        var texto = "número de cuenta?";
        if ($('#letra_descuento').is(":checked")){
            var texto = "número único?";
        }

        Swal({
            title: '¿Realmente desea actualizar '+texto,
            text: "El registro será actualizado",
            type: 'question',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
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
                                text: "¡Existe un registro con el mismo número único!",
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
                                Lista_Letra_Cobrar();
                                $("#ModalUpdate .close").click();
                            })
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
        })
    }
</script>
