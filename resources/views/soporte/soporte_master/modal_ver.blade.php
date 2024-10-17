<form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Ver error de picking:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Semana: </label>
            </div>
            <div class="form-group col-lg-4">
                <input disabled type="text" class="form-control" name="semanae" id="semanae" placeholder="Semana" value="{{ $get_id->semana }}" onkeypress="return soloNumeros(event)">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Pertenece: </label>
            </div>
            <div class="form-group col-lg-4">
                <select disabled class="form-control" id="pertenecee" name="pertenecee">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                    <option value="{{ $list->cod_base }}" {{ $list->cod_base == $get_id->pertenece ? 'selected' : '' }}>
                        {{ $list->cod_base }}
                    </option>
                    @endforeach
                    <option value="BEC" {{ $get_id->pertenece == 'BEC' ? 'selected' : '' }}>BEC</option>
                </select>

            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Encontrado: </label>
            </div>
            <div class="form-group col-lg-4">
                <select disabled class="form-control" id="encontradoe" name="encontradoe">
                    <option value="0">Seleccione</option>
                    @foreach ($list_base as $list)
                    <option value="{{ $list->cod_base }}" {{ $list->cod_base == $get_id->encontrado ? 'selected' : '' }}>
                        {{ $list->cod_base }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Área: </label>
            </div>
            <div class="form-group col-lg-4">
                <select disabled class="form-control" id="id_areae" name="id_areae">
                    <option value="0">Seleccione</option>
                    @foreach ($list_area as $list)
                    <option value="{{ $list->id }}" {{ $list->id == $get_id->id_area ? 'selected' : '' }}>
                        {{ $list->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Estilo: </label>
            </div>
            <div class="form-group col-lg-4">
                <input disabled type="text" class="form-control" name="estiloe" id="estiloe" placeholder="Estilo" value="{{ $get_id->estilo }}">
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Color: </label>
            </div>
            <div class="form-group col-lg-4">
                <input disabled type="text" class="form-control" name="colore" id="colore" placeholder="Color" value="{{ $get_id->color }}">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Talla: </label>
            </div>
            <div class="form-group col-lg-4">
                <select disabled class="form-control" id="id_tallae" name="id_tallae">
                    <option value="0">Seleccione</option>
                    @foreach ($list_talla as $list)
                    <option value="{{ $list->id }}" {{ $list->id == $get_id->id_talla ? 'selected' : '' }}>
                        {{ $list->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Prendas devueltas: </label>
            </div>
            <div class="form-group col-lg-4">
                <input disabled type="text" class="form-control" name="prendas_devueltase" id="prendas_devueltase" placeholder="Prendas devueltas" value="{{ $get_id->prendas_devueltas }}" onkeypress="return soloNumeros(event)">
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo de error: </label>
            </div>
            <div class="form-group col-lg-4">
                <select disabled class="form-control" name="id_tipo_errore" id="id_tipo_errore">
                    <option value="0">Seleccione</option>
                    @foreach ($list_tipo_error as $list)
                    <option value="{{ $list->id }}" {{ $list->id == $get_id->id_tipo_error ? 'selected' : '' }}>
                        {{ $list->nombre }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Responsable: </label>
            </div>
            <div class="form-group col-lg-4">
                <select disabled class="form-control" name="id_responsablee" id="id_responsablee">
                    <option value="0">Seleccione</option>
                    @foreach ($list_responsable as $list)
                    <option value="{{ $list['id_usuario'] }}" {{ $list['id_usuario'] == $get_id->id_responsable ? 'selected' : '' }}>
                        {{ $list['usuario_nombres'] }}
                    </option>
                    @endforeach
                </select>
            </div>

        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Solución: </label>
            </div>
            <div class="form-group col-lg-4">
                <select disabled class="form-control" id="solucione" name="solucione">
                    <option value="0">Seleccione</option>
                    <option value="1" {{ $get_id->solucion == 1 ? 'selected' : '' }}>SI</option>
                    <option value="2" {{ $get_id->solucion == 2 ? 'selected' : '' }}>NO</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Observación: </label>
            </div>
            <div class="form-group col-lg-10">
                <textarea disabled class="form-control" name="observacione" id="observacione" rows="5" placeholder="Observación">{{ $get_id->observacion }}</textarea>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Aceptar</button>
    </div>
</form>