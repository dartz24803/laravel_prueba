<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Editar Seguimiento al coordinador:</h5>
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
                <select class="form-control" name="basese" id="basese">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                        <option value="{{ $list->cod_base }}"
                        @if ($list->cod_base==$get_id->base) selected @endif>
                            {{ $list->cod_base }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Área:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_areae" id="id_areae">
                    <option value="0">Seleccione</option>
                    @foreach ($list_area as $list)
                        <option value="{{ $list->id_area }}" 
                        @if ($list->id_area==$get_id->id_area) selected @endif>
                            {{ $list->nom_area }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Periocidad:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_periocidade" id="id_periocidade" onchange="Periocidad('e');">
                    <option value="0">Seleccione</option>
                    <option value="1" @if ($get_id->id_periocidad==1) selected @endif>Diario</option>
                    <option value="2" @if ($get_id->id_periocidad==2) selected @endif>Semanal</option>
                    <option value="3" @if ($get_id->id_periocidad==3) selected @endif>Quincenal</option>
                    <option value="4" @if ($get_id->id_periocidad==4) selected @endif>Mensual</option>
                    <option value="5" @if ($get_id->id_periocidad==5) selected @endif>Anual</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2 div_semanale" @if ($get_id->id_periocidad!=2) style="display: none;" @endif>
                <label>Día 1:</label>
            </div>
            <div class="form-group col-lg-4 div_semanale" @if ($get_id->id_periocidad!=2) style="display: none;" @endif>
                <select class="form-control" name="nom_dia_1e" id="nom_dia_1e">
                    <option value="0">Seleccione</option>
                    @foreach ($list_dia_semana as $list)
                        <option value="{{ $list->id }}"
                        @if ($list->id==$get_id->nom_dia_1) selected @endif>
                            {{ $list->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 div_semanale" @if ($get_id->id_periocidad!=2) style="display: none;" @endif>
                <label>Día 2:</label>
            </div>
            <div class="form-group col-lg-4 div_semanale" @if ($get_id->id_periocidad!=2) style="display: none;" @endif>
                <select class="form-control" name="nom_dia_2e" id="nom_dia_2e">
                    <option value="0">Seleccione</option>
                    @foreach ($list_dia_semana as $list)
                        <option value="{{ $list->id }}"
                        @if ($list->id==$get_id->nom_dia_2) selected @endif>
                            {{ $list->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 div_semanale" @if ($get_id->id_periocidad!=2) style="display: none;" @endif>
                <label>Día 3:</label>
            </div>
            <div class="form-group col-lg-4 div_semanale" @if ($get_id->id_periocidad!=2) style="display: none;" @endif>
                <select class="form-control" name="nom_dia_3e" id="nom_dia_3e">
                    <option value="0">Seleccione</option>
                    @foreach ($list_dia_semana as $list)
                        <option value="{{ $list->id }}"
                        @if ($list->id==$get_id->nom_dia_3) selected @endif>
                            {{ $list->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 div_quincenale" @if ($get_id->id_periocidad!=3) style="display: none;" @endif>
                <label>Día 1:</label>
            </div>
            <div class="form-group col-lg-4 div_quincenale" @if ($get_id->id_periocidad!=3) style="display: none;" @endif>
                <select class="form-control" name="dia_1e" id="dia_1e">
                    <option value="0">Seleccione</option>
                    @php $i=1; @endphp
                    @while ($i<=28)
                        <option value="{{ $i }}"
                        @if ($i==$get_id->dia_1) selected @endif>
                            {{ $i }}
                        </option>
                        @php $i++; @endphp
                    @endwhile
                </select>
            </div>

            <div class="form-group col-lg-2 div_quincenale" @if ($get_id->id_periocidad!=3) style="display: none;" @endif>
                <label>Día 2:</label>
            </div>
            <div class="form-group col-lg-4 div_quincenale" @if ($get_id->id_periocidad!=3) style="display: none;" @endif>
                <select class="form-control" name="dia_2e" id="dia_2e">
                    <option value="0">Seleccione</option>
                    @php $i=1; @endphp
                    @while ($i<=28)
                        <option value="{{ $i }}"
                        @if ($i==$get_id->dia_2) selected @endif>
                            {{ $i }}
                        </option>
                        @php $i++; @endphp
                    @endwhile
                </select>
            </div>

            <div class="form-group col-lg-2 div_anuale" @if ($get_id->id_periocidad!=5) style="display: none;" @endif>
                <label>Mes:</label>
            </div>
            <div class="form-group col-lg-4 div_anuale" @if ($get_id->id_periocidad!=5) style="display: none;" @endif>
                <select class="form-control" name="mese" id="mese">
                    <option value="0">Seleccione</option>
                    @foreach ($list_mes as $list)
                        <option value="{{ $list->id_mes }}"
                        @if ($list->id_mes==$get_id->mes) selected @endif>
                            {{ $list->nom_mes }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2 div_mensuale" @if ($get_id->id_periocidad!=5 && $get_id->id_periocidad!=4) style="display: none;" @endif>
                <label>Día:</label>
            </div>
            <div class="form-group col-lg-4 div_mensuale" @if ($get_id->id_periocidad!=5 && $get_id->id_periocidad!=4) style="display: none;" @endif>
                <select class="form-control" name="diae" id="diae">
                    <option value="0">Seleccione</option>
                    @php $i=1; @endphp
                    @while ($i<=28)
                        <option value="{{ $i }}"
                        @if ($i==$get_id->dia) selected @endif>
                            {{ $i }}
                        </option>
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
                <input type="text" class="form-control" name="descripcione" id="descripcione" placeholder="Ingresar Descripción" value="{{ $get_id->descripcion }}">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        @method('PUT')
        <input type="hidden" name="dummy_fielde" value="0">
        <button class="btn btn-primary" type="button" onclick="Update_C_Seguimiento_Coordinador();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Update_C_Seguimiento_Coordinador() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioe'));
        var url = "{{ route('administrador_conf_sc.update', $get_id->id) }}";

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
                        Lista_C_Seguimiento_Coordinador();
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