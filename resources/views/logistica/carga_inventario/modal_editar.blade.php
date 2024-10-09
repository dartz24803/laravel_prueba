<form id="formularioe" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Inventario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row mb-2">
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Fecha: </label>
                <div class="">
                    <input type="date" id="fechae" name="fechae" value="{{ $get_id->fecha }}" class="form-control">
                </div>
            </div>
            <div class="form-group col-md-6">
                <label class="control-label text-bold">Base: </label>
                <div class="">
                    <select name="basee" id="basee" class="form-control">
                        <option value="0">Seleccione</option>
                        @foreach ($list_base as $list)
                        <option value="{{ $list->cod_base }}" {{ $get_id->base == $list->cod_base ? 'selected' : '' }}>
                            {{ $list->cod_base }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Responsable: </label>
                <div class="">
                    <select name="id_responsablee" id="id_responsablee" class="form-control">
                        <option value="0">Seleccione</option>
                        @foreach ($list_usuario as $list)
                        <option value="{{ $list->id_usuario }}" {{ $get_id->id_responsable == $list->id_usuario ? 'selected' : '' }}>
                            {{ $list->usuario_nombres . ' ' . $list->usuario_apater . ' ' . $list->usuario_amater }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group col-md-6">
                <label class="control-label text-bold">Archivo: </label>
                <div class="">
                    <input type="file" class="form-control-file" id="archivoe" name="archivoe" onchange="return Validar_Archivo('archivoe')" />
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <input type="hidden" name="id_inventario" id="id_inventario" value="{{ $get_id->id_inventario }}">
        <button class="btn btn-primary mt-3" type="button" onclick="Update_Carga_Inventario();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>