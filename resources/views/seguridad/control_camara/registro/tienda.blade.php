@if (count($list_tienda_base)>0)
    <div class="form-group col-lg-12">
        <label class="control-label text-bold">Bases a Monitorear:</label>
    </div>

    @foreach ($list_tienda_base as $list)
        <div class="col-lg-12 row justify-content-center">
            <div class="form-group col-lg-3">
                <label class="control-label text-bold">{{ $list->descripcion }}:</label>
            </div>
            <div class="form-group row col-lg-4">
                <select class="form-control" id="id_ocurrencia_{{ $list->id_tienda }}" name="id_ocurrencia_{{ $list->id_tienda }}">
                    <option value="0">Seleccione</option>
                    @foreach ($list_ocurrencia as $ocurrencia)
                        <option value="{{ $ocurrencia->id_ocurrencias_camaras }}">
                            {{ $ocurrencia->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex align-items-center justify-content-center col-lg-1 ml-3 mb-3">
                <button type="button" class="btn btn-secondary" id="btn_camara_{{ $list->id_tienda }}" title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('control_camara_reg.modal_imagen', $list->id_tienda) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera text-light">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                </button>
            </div>
        </div>
    @endforeach
@endif
@if (count($list_tienda_sede)>0)
    <div class="form-group col-lg-12">
        <label class="control-label text-bold">Sede a Monitorear:</label>
    </div>

    @foreach ($list_tienda_sede as $list)
        <div class="col-lg-12 row justify-content-center">
            <div class="form-group col-lg-3">
                <label class="control-label text-bold">{{ $list->descripcion }}:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" id="id_ocurrencia_{{ $list->id_tienda }}" name="id_ocurrencia_{{ $list->id_tienda }}">
                    <option value="0">Seleccione</option>
                    @foreach ($list_ocurrencia as $ocurrencia)
                        <option value="{{ $ocurrencia->id_ocurrencias_camaras }}">
                            {{ $ocurrencia->descripcion }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex align-items-center justify-content-center col-lg-1 ml-3 mb-3">
                <button type="button" class="btn btn-secondary" id="btn_camara_{{ $list->id_tienda }}" title="Registrar" data-toggle="modal" data-target="#ModalUpdate" app_elim="{{ route('control_camara_reg.modal_imagen', $list->id_tienda) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-camera text-light">
                        <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                        <circle cx="12" cy="13" r="4"></circle>
                    </svg>
                </button>
            </div>
        </div>
    @endforeach
@endif