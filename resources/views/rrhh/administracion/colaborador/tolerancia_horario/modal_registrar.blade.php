<form id="formulario_tolerancia" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nueva Tolerancia</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tipo:</label>
            </div>
            <div class="form-group col-sm-4">
                <select class="form-control" name="tipo" id="tipo">
                    <option value="0">Seleccionar</option>
                    <option value="1">Minutos</option>
                    <option value="2">Horas</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Tolerancia:</label>
            </div>
            <div class="form-group col-sm-4">
                <input type="text" name="tolerancia" id="tolerancia" onkeypress="return soloNumeros(event)" class="form-control">
            </div>

        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_ToleranciaHorario();">Guardar1</button>

        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_ToleranciaHorario() {
        var dataString = new FormData(document.getElementById('formulario_tolerancia'));
        var url = "{{ url('ToleranciaHorario/Insert_ToleranciaHorario') }}";
        var csrfToken = $('input[name="_token"]').val();
        if (Valida_ToleranciaHorario('1')) {
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: dataString,
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data == "error") {
                        Swal({
                            title: 'Registro Denegado',
                            text: "¡El registro ya existe!",
                            type: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK',
                        });
                    } else {
                        swal.fire(
                            'Registro Exitoso!',
                            'Haga clic en el botón!',
                            'success'
                        ).then(function() {
                            TablaToleranciaHorario();
                            $("#ModalRegistro .close").click();
                        });
                    }
                }
            });
        } else {
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        }
    }




    function soloNumeros(e) {
        var key = e.keyCode || e.which,
            tecla = String.fromCharCode(key).toLowerCase(),
            //letras = " áéíóúabcdefghijklmnñopqrstuvwxyz",
            letras = "0123456789",
            especiales = [8, 37, 39, 46],
            tecla_especial = false;

        for (var i in especiales) {
            if (key == especiales[i]) {
                tecla_especial = true;
                break;
            }
        }

        if (letras.indexOf(tecla) == -1 && !tecla_especial) {
            return false;
        }
    }
</script>