<form id="formulario_update" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Ver función temporal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Colaborador: </label>
            </div>
            <div class="form-group col-lg-10">
                <select class="form-control" disabled>
                    <option value="0">Seleccione</option>
                    @foreach ($list_usuario as $list)
                        <option value="{{ $list->id_usuario }}"
                        @if ($list->id_usuario==$get_id->id_usuario) selected @endif>
                            {{ $list->nom_usuario }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        
        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Tipo: </label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" disabled>
                    <option value="0">Seleccione</option>
                    <option value="1" @if ($get_id->id_tipo==1) selected @endif>Función</option>
                    <option value="2" @if ($get_id->id_tipo==2) selected @endif>Tarea</option>
                </select>
            </div>
        </div>

        <div class="row" id="div_tipoe">
            @if ($get_id->id_tipo=="1")
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Función: </label> 
                </div>
                <div class="form-group col-lg-10">
                    <select class="form-control" disabled>
                        <option value="0">Seleccione</option> 
                        @foreach ($list_puesto as $list)
                            <option value="{{ $list->id_puesto }}"
                            @if ($list->id_puesto==$get_id->tarea) selected @endif>
                                {{ $list->nom_puesto }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @else
                <div class="form-group col-lg-2">
                    <label class="control-label text-bold">Tipo de tarea: </label>
                </div>
                <div class="form-group col-lg-10">
                    <select class="form-control" disabled>
                        <option value="0">Seleccione</option>
                        @foreach ($list_tarea as $list)
                            <option value="{{ $list->id }}"
                            @if ($list->id==$get_id->select_tarea) selected @endif>
                                {{ $list->descripcion }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-lg-2 esconder">
                    <label class="control-label text-bold">Tarea: </label>
                </div>
                <div class="form-group col-lg-10 esconder">
                    <input type="text" class="form-control" placeholder="Ingresar tarea" value="{{ $get_id->tarea }}" disabled>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Fecha: </label>
            </div>
            <div class="form-group col-lg-4">
                <input class="form-control" type="date" value="{{ $get_id->fecha }}" disabled>
            </div>

            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Hora de inicio: </label>
            </div>
            <div class="form-group col-lg-4">
                <input class="form-control" type="time" value="{{ $get_id->hora_inicio }}" disabled>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label class="control-label text-bold">Hora de fin: </label>
            </div>
            <div class="form-group col-lg-4">
                <input class="form-control" type="time" value="{{ $get_id->hora_fin }}" disabled>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>