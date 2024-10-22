
<div class="toolbar">
    <div class="row">
        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label text-bold">Estado Solicitud:</label>
                <select id="estado_solicitud2" name="estado_solicitud2" class="form-control" >
                    <option value="1" selected>En Proceso de aprobacion</option>
                    <option value="2">Aprobados</option>
                    <option value="3">Denegados</option>
                    <option value="4">Todos</option>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label text-bold">Colaborador:</label>
                <select id="num_doc" name="num_doc" class="form-control basic">
                    <option value="0">TODOS</option>
                    <?php foreach($list_colaborador as $list){?>
                        <option value="<?php echo $list['num_doc']; ?>"> <?php echo $list['usuario_apater']." ".$list['usuario_amater'].", ".$list['usuario_nombres'];?> </option>
                    <?php } ?>
                </select>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label text-bold">Fecha Inicio:</label>
                <input type="date" class="form-control formcontrolarlimpiar" id="fecha_revision" value="<?php echo date("Y-m-d");?>" name="fecha_revision" >
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label class="control-label text-bold">Fecha Fin:</label>
                    <input type="date" class="form-control formcontrolarlimpiar" id="fecha_revision_fin" value="<?php echo date("Y-m-t");?>" name="fecha_revision_fin" >
            </div>
        </div>

        <div class="form-group col-md-3">
            <label class="control-label text-bold">&nbsp;</label>
            <button type="button" id="busqueda_papeleta_gestion" class="btn btn-primary mb-2 mr-2 form-control" onclick="Buscar_Papeletas_Salida_Aprobacion();" title="Buscar">
                Buscar
            </button>
        </div>
    </div>
</div>
@csrf
<div class="table-responsive mb-4 mt-4" id="lista_colaborador2" style="max-width:100%; overflow:auto;">
</div>
<script>
    $(document).ready(function() {
        Buscar_Papeletas_Salida_Aprobacion();
        $('.basic').select2();
    });

    function Buscar_Papeletas_Salida_Aprobacion() {
        Cargando();
        var estado_solicitud = $('#estado_solicitud2').val();
        var fecha_revision = $('#fecha_revision').val();
        var fecha_revision_fin = $('#fecha_revision_fin').val();
        var url = "{{ url('Papeletas/Buscar_Papeletas_Salida_Aprobacion') }}";
        var csrfToken = $('input[name="_token"]').val();

        var ini = moment(fecha_revision);
        var fin = moment(fecha_revision_fin);

        if (ini.isAfter(fin) == true) {
            msgDate = 'La Fecha de Inicio no debe ser mayor a la de Fecha de Fin. <br> Porfavor corrígelo. ';
            inputFocus = '#hora_salida_hoy';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        } else if (fecha_revision != '' && fecha_revision_fin === '') {
            msgDate = 'Si va buscar por rango de fechas porfavor ponga la fecha final también  ';
            inputFocus = '#hora_salida_hoy';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });

        } else if (fecha_revision === '' && fecha_revision_fin != '') {
            msgDate = 'Si va buscar por rango de fechas porfavor ponga la fecha inicial también  ';
            inputFocus = '#hora_salida_hoy';
            bootbox.alert(msgDate)
            var input = $(inputFocus).parent();
            $(input).addClass("has-error");
            $(input).on("change", function() {
                if ($(input).hasClass("has-error")) {
                    $(input).removeClass("has-error");
                }
            });
        } else {
            $.ajax({
                type: "POST",
                url: url,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                data: {
                    'estado_solicitud': estado_solicitud,
                    'fecha_revision': fecha_revision,
                    'fecha_revision_fin': fecha_revision_fin
                },
                success: function(data) {
                    $('#lista_colaborador2').html(data);
                }
            });
        }
    }

    function Aprobado_solicitud_papeletas_1(id) {
        Cargando();

        var id = id;
        var url = "{{ url('Papeletas/Aprobado_solicitud_papeletas_1') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea aprobar la papeleta?',
            text: "La papeleta será aprobada",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {'id_solicitudes_user': id},
                    success: function(data) {
                        Swal(
                            'Aprobado!',
                            'La papeleta ha sido aprobada satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Buscar_Papeletas_Salida_Aprobacion();
                        });
                    }
                });
            }
        })
    }

    function Anular_solicitud_papeletas_1(id) {
        Cargando();

        var id = id;
        var url = "{{ url('Papeletas/Anular_solicitud_papeletas_1') }}";
        var csrfToken = $('input[name="_token"]').val();

        Swal({
            title: '¿Realmente desea desaprobar esta Papeleta de Salida?',
            text: "El registro será desaprobado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    type: "POST",
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    data: {'id_solicitudes_user': id},
                    success: function(data) {
                        Swal(
                            'Desaprobado!',
                            'La papeleta ha sido desaprobado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Buscar_Papeletas_Salida_Aprobacion();
                        });
                    }
                });
            }
        })
    }
</script>
