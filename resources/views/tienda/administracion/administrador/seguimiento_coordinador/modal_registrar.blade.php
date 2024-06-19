<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Seguimiento al coordinador:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Base:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control multivalue" name="bases[]" id="bases" multiple="multiple">
                    @foreach ($list_base as $list)
                        <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-6">
                <input type="checkbox" name="todos" id="todos" value="1">
                <label for="todos">Seleccionar todas las bases</label>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Área:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_area" id="id_area">
                    <option value="0">Seleccione</option>
                    @foreach ($list_area as $list)
                        <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Periocidad:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_periocidad" id="id_periocidad" onchange="Periocidad('');">
                    <option value="0">Seleccione</option>
                    <option value="1">Diario</option>
                    <option value="2">Semanal</option>
                    <option value="3">Quincenal</option>
                    <option value="4">Mensual</option>
                    <option value="5">Anual</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2 div_semanal" style="display: none;">
                <label>Día 1:</label>
            </div>
            <div class="form-group col-lg-4 div_semanal" style="display: none;">
                <select class="form-control" name="nom_dia_1" id="nom_dia_1">
                    <option value="0">Seleccione</option>
                    @foreach ($list_dia_semana as $list)
                        <option value="{{ $list->id }}">{{ $list->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 div_semanal" style="display: none;">
                <label>Día 2:</label>
            </div>
            <div class="form-group col-lg-4 div_semanal" style="display: none;">
                <select class="form-control" name="nom_dia_2" id="nom_dia_2">
                    <option value="0">Seleccione</option>
                    @foreach ($list_dia_semana as $list)
                        <option value="{{ $list->id }}">{{ $list->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 div_semanal" style="display: none;">
                <label>Día 3:</label>
            </div>
            <div class="form-group col-lg-4 div_semanal" style="display: none;">
                <select class="form-control" name="nom_dia_3" id="nom_dia_3">
                    <option value="0">Seleccione</option>
                    @foreach ($list_dia_semana as $list)
                        <option value="{{ $list->id }}">{{ $list->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 div_quincenal" style="display: none;">
                <label>Día 1:</label>
            </div>
            <div class="form-group col-lg-4 div_quincenal" style="display: none;">
                <select class="form-control" name="dia_1" id="dia_1">
                    <option value="0">Seleccione</option>
                    @php $i=1; @endphp
                    @while ($i<=28)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @php $i++; @endphp
                    @endwhile
                </select>
            </div>

            <div class="form-group col-lg-2 div_quincenal" style="display: none;">
                <label>Día 2:</label>
            </div>
            <div class="form-group col-lg-4 div_quincenal" style="display: none;">
                <select class="form-control" name="dia_2" id="dia_2">
                    <option value="0">Seleccione</option>
                    @php $i=1; @endphp
                    @while ($i<=28)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @php $i++; @endphp
                    @endwhile
                </select>
            </div>

            <div class="form-group col-lg-2 div_anual" style="display: none;">
                <label>Mes:</label>
            </div>
            <div class="form-group col-lg-4 div_anual" style="display: none;">
                <select class="form-control" name="mes" id="mes">
                    <option value="0">Seleccione</option>
                    @foreach ($list_mes as $list)
                        <option value="{{ $list->id_mes }}">{{ $list->nom_mes }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 div_mensual" style="display: none;">
                <label>Día:</label>
            </div>
            <div class="form-group col-lg-4 div_mensual" style="display: none;">
                <select class="form-control" name="dia" id="dia">
                    <option value="0">Seleccione</option>
                    @php $i=1; @endphp
                    @while ($i<=28)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @php $i++; @endphp
                    @endwhile
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" name="descripcion" id="descripcion" placeholder="Ingresar Descripción">
            </div>
        </div>   
    </div>

    <div class="modal-footer">
        @csrf
        <input type="hidden" name="dummy_field" value="0">
        <button class="btn btn-primary" type="button" onclick="Insert_C_Seguimiento_Coordinador();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    var ss = $(".multivalue").select2({
        tags: true
    });

    $('.multivalue').select2({
        dropdownParent: $('#ModalRegistro')
    });
    
    function Periocidad(v){
        var id_periocidad = $("#id_periocidad"+v).val();

        if(id_periocidad==2){
            $(".div_semanal"+v).show();
            $(".div_quincenal"+v).hide();
            $("#dia_1"+v).val(0);
            $("#dia_2"+v).val(0);
            $(".div_mensual"+v).hide();
            $("#dia"+v).val(0);
            $(".div_anual"+v).hide();
            $("#mes"+v).val(0);
        }else if(id_periocidad==3){
            $(".div_quincenal"+v).show();
            $(".div_semanal"+v).hide();
            $("#nom_dia_1"+v).val(0);
            $("#nom_dia_2"+v).val(0);
            $("#nom_dia_3"+v).val(0);
            $(".div_mensual"+v).hide();
            $("#dia"+v).val(0);
            $(".div_anual"+v).hide();
            $("#mes"+v).val(0);
        }else if(id_periocidad==4){
            $(".div_mensual"+v).show();
            $(".div_semanal"+v).hide();
            $("#nom_dia_1"+v).val(0);
            $("#nom_dia_2"+v).val(0);
            $("#nom_dia_3"+v).val(0);
            $(".div_quincenal"+v).hide();
            $("#dia_1"+v).val(0);
            $("#dia_2"+v).val(0);
            $(".div_anual"+v).hide();
            $("#mes"+v).val(0);
            $("#dia"+v).val(0);
        }else if(id_periocidad==5){
            $(".div_mensual"+v).show();
            $(".div_semanal"+v).hide();
            $("#nom_dia_1"+v).val(0);
            $("#nom_dia_2"+v).val(0);
            $("#nom_dia_3"+v).val(0);
            $(".div_quincenal"+v).hide();
            $("#dia_1"+v).val(0);
            $("#dia_2"+v).val(0);
            $("#dia"+v).val(0);
            $(".div_anual"+v).show();
        }else{
            $(".div_semanal"+v).hide();
            $("#nom_dia_1"+v).val(0);
            $("#nom_dia_2"+v).val(0);
            $("#nom_dia_3"+v).val(0);
            $(".div_quincenal"+v).hide();
            $("#dia_1"+v).val(0);
            $("#dia_2"+v).val(0);
            $(".div_mensual"+v).hide();
            $("#dia"+v).val(0);
            $(".div_anual"+v).hide();
            $("#mes"+v).val(0);
        }
    }

    function Insert_C_Seguimiento_Coordinador() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('administrador_conf_sc.store') }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="error"){
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡El registro ya existe!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        '¡Registro Exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        @if ($validador!=1)
                            Lista_C_Seguimiento_Coordinador();
                        @endif
                        $("#ModalRegistro .close").click();
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
</script>
