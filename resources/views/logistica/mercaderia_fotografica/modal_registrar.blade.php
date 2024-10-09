<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nueva Mercadería</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row mb-2">
            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Año</label>
                <select class="form-control" id="anioc" name="anioc">
                    @for ($year = date('Y'); $year >= 1990; $year--) <!-- Invertir el orden -->
                    <option value="{{ $year }}" {{ date('Y') == $year ? 'selected' : '' }}>
                        {{ $year }}
                    </option>
                    @endfor
                </select>
            </div>
            <div class="form-group col-lg-6">
                <label class="control-label text-bold">Mes</label>
                <select class="form-control" id="mesic" name="mesic">
                    <option value="0">Seleccione</option>
                    @foreach ([
                    ['cod_mes' => '01', 'nom_mes' => 'Enero'],
                    ['cod_mes' => '02', 'nom_mes' => 'Febrero'],
                    ['cod_mes' => '03', 'nom_mes' => 'Marzo'],
                    ['cod_mes' => '04', 'nom_mes' => 'Abril'],
                    ['cod_mes' => '05', 'nom_mes' => 'Mayo'],
                    ['cod_mes' => '06', 'nom_mes' => 'Junio'],
                    ['cod_mes' => '07', 'nom_mes' => 'Julio'],
                    ['cod_mes' => '08', 'nom_mes' => 'Agosto'],
                    ['cod_mes' => '09', 'nom_mes' => 'Septiembre'],
                    ['cod_mes' => '10', 'nom_mes' => 'Octubre'],
                    ['cod_mes' => '11', 'nom_mes' => 'Noviembre'],
                    ['cod_mes' => '12', 'nom_mes' => 'Diciembre']
                    ] as $list)
                    <option value="{{ $list['cod_mes'] }}" {{ date('m') == $list['cod_mes'] ? 'selected' : '' }}>
                        {{ $list['nom_mes'] }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Adjuntar Documento: </label>
            </div>
            <div class="form-group col-sm-4">
                <input type="file" class="form-control-file" id="doc_mercaderia" name="doc_mercaderia">
            </div>
        </div>
    </div>

    <div class="modal-footer">
        <button class="btn btn-primary mt-3" type="button" onclick="Insert_Mercaderia_Fotografia();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>