<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Validación de registro - Movilidad:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Pago:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_pagov" id="id_pagov">
                    <option value="0">Seleccione</option>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Tipo pago:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_tipo_pagov" id="id_tipo_pagov">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Cuenta 1:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="cuenta_1v" id="cuenta_1v">
                    <option value="0">Seleccione</option>
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Cuenta 2:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="cuenta_2v" id="cuenta_2v">
                    <option value="0">Seleccione</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Fecha:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" name="fecha_pagov" id="fecha_pagov" value="{{ date('Y-m-d') }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Categoría:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->nom_categoria }}" disabled>
            </div>

            <div class="form-group col-lg-2">
                <label>Sub-Categoría:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->nombre }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Tipo comprobante:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->nom_tipo_comprobante }}" disabled>
            </div>

            <div class="form-group col-lg-2">
                <label>N° comprobante:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->n_comprobante }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" value="{{ $get_id->descripcion }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Monto:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->total }}" disabled>
            </div>

            <div class="form-group col-lg-2">
                <label>Ubicación:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->cod_ubi }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Empresa:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->nom_empresa }}" disabled>
            </div>

            <div class="form-group col-lg-2">
                <label>Parte interesada:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" value="{{ $get_id->razon_social }}" disabled>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <button class="btn btn-primary" type="button">Validar</button> <!--onclick="Update_Caja_Chica_Mo();"-->
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $(".basic").select2({
        tags: true,
        dropdownParent: $('#ModalUpdate')
    });

    function Update_Caja_Chica_Mo() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('caja_chica.update_mo', $get_id->id) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                swal.fire(
                    '¡Actualización Exitosa!',
                    '¡Haga clic en el botón!',
                    'success'
                ).then(function() {
                    Lista_Caja_Chica();
                    $("#ModalUpdate .close").click();
                })
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
