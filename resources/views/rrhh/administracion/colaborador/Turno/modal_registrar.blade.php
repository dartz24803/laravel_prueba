
<form id="formulario_turno"  method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Turno</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label>Centro de Labores:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="base" id="base" class="form-control">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_base as $list){?>
                        <option value="<?php echo $list->cod_base ?>"><?php echo $list->cod_base ?></option>
                    <?php }?>
                </select>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-2">
                <label>Entrada:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="entrada" id="entrada" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label>Salida:</label>
            </div>
            <div class="form-group col-md-4">
                <input type="time" name="salida" id="salida" class="form-control">
            </div>
            <div class="form-group col-md-2">
                <label>Tipo de Refrigerio:</label>
            </div>
            <div class="form-group col-md-4">
                <select name="t_refrigerio" id="t_refrigerio" class="form-control" onchange="Tipo_Refrigerio('')">
                    <option value="0">Seleccione</option>
                    <option value="1" selected>Refrigerio Fijo</option>
                    <option value="2" >Sin Refrigerio</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 row" >
            <div class="form-group col-md-2" id="div_refri1">
                <label>Inicio Refrigerio:</label>
            </div>
            <div class="form-group col-md-4" id="div_refri2">
                <input type="time" name="ini_refri" id="ini_refri" class="form-control">
            </div>
            <div class="form-group col-md-2" id="div_refri3">
                <label>Fin Refrigerio:</label>
            </div>
            <div class="form-group col-md-4" id="div_refri4">
                <input type="time" name="fin_refri" id="fin_refri" class="form-control">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Turno();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Turno() {
        var dataString = $("#formulario_turno").serialize();
        var url = "{{ url('ColaboradorConfController/Insert_Turno') }}";
        var csrfToken = $('input[name="_token"]').val();
        $.ajax({
            type: "POST",
            url: url,
            data: dataString,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            },
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
                        $("#ModalRegistro .close").click()
                        TablaTurno();
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

    function Tipo_Refrigerio(v){
        var div1 = document.getElementById("div_refri1"+v);
        var div2 = document.getElementById("div_refri2"+v);
        var div3 = document.getElementById("div_refri3"+v);
        var div4 = document.getElementById("div_refri4"+v);
        $('#ini_refri'+v).val('00:00:00');
        $('#fin_refri'+v).val('00:00:00');
        if($('#t_refrigerio'+v).val()=="1"){
            div1.style.display = "block";
            div2.style.display = "block";
            div3.style.display = "block";
            div4.style.display = "block";
        }else{
            div1.style.display = "none";
            div2.style.display = "none";
            div3.style.display = "none";
            div4.style.display = "none";
            $('#ini_refri'+v).val('00:00:00');
            $('#fin_refri'+v).val('00:00:00');
        }
    }
</script>
