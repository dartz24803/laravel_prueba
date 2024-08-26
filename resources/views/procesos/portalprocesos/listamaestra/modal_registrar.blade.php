<form id="formulario_insert" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Portal</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="row">

            <div class="form-group col-md-4">
                <label>Nombre: </label>
                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresar nombre">
            </div>


            <div class="form-group col-lg-4">
                <label class="control-label text-bold">Tipo: </label>

                <select class="form-control basicm" name="id_tipo_portal" id="id_tipo_portal">
                    <option value="0">Seleccione</option>
                    @foreach ($list_tipo as $list)
                    <option value="{{ $list->id_tipo_portal }}">{{ $list->nom_tipo }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group col-lg-4">
                <label class="control-label text-bold">Fecha: </label>

                <input class="form-control" type="date" name="fecha" id="fecha" value="{{ date('Y-m-d') }}">
            </div>
        </div>

        <div class="row">

            <div class="form-group col-md-6">
                <label>Responsable: </label>
                <select class="form-control basicm" name="id_puesto" id="id_puesto">
                    <option value="0">Seleccione</option>
                    @foreach ($list_responsable as $list)
                    <option value="{{ $list->id_puesto }}">{{ $list->nom_puesto }}</option>
                    @endforeach
                </select>
            </div>


            <div class="form-group col-lg-6">
                <label>Area:</label>

                <select class="form-control multivalue" name="id_area[]" id="id_area" multiple="multiple">
                    @foreach ($list_area as $list)
                    <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="row">

            <div class="form-group col-md-4">
                <label>N° Documento: </label>
                <input type="text" class="form-control" id="ndocumento" name="ndocumento" placeholder="Ingresar documento">
            </div>
            <div class="form-group col-md-2">
                <label>Código: </label>
                <div>
                    <input type="hidden" name="codigo" id="codigo" class="form-control">
                    <label id="miLabel" style="color:black"></label>
                </div>
            </div>



            <div class="form-group col-lg-6">
                <label>Descripción:</label>

                <textarea name="descripcion" id="descripcion" cols="1" rows="2" class="form-control"></textarea>

            </div>
        </div>
        <div class="row d-flex">
            <div class="form-group col-md-2">
                <label class="control-label text-bold">Accesos: </label>
            </div>
            <div class="form-group col-md-2">
                <label class="switch s-primary mr-2">
                    <input type="checkbox" id="acceso_todo" name="acceso_todo" onclick="Acceso_Todo(1)" value="1">
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="form-group col-md-8">
                <label class="control-label text-bold">Todos </label>
                <div class="form-group">
                    <label class="control-label text-bold">Seleccionar acceso por: </label>
                </div>
                <div class="form-group">
                    <select name="tipo_acceso" id="tipo_acceso" class="form-control">
                        <option value="0">Seleccione</option>
                        <option value="1">Por Puesto</option>
                        <option value="2">Por Centro de Labores</option>
                        <option value="3">Por Área</option>
                        <option value="4">Por Gerencia</option>
                        <option value="5">Por Nivel</option>
                    </select>
                </div>
            </div>


        </div>

        <div class="form-group col-md-6">
            <button class="btn btn-primary mt-2 " id="btn_seccion" onclick="Seccion_Portal(1);" type="button">
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle">
                    <circle cx="12" cy="12" r="10"></circle>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                    <line x1="8" y1="12" x2="16" y2="12"></line>
                </svg>
            </button>
            <input type="hidden" name="div_puesto" id="div_puesto" value="0">
            <input type="hidden" name="div_base" id="div_base" value="0">
            <input type="hidden" name="div_area" id="div_area" value="0">
            <input type="hidden" name="div_nivel" id="div_nivel" value="0">
            <input type="hidden" name="div_gerencia" id="div_gerencia" value="0">
        </div>

        <div class="row d-flex">
            <div class="form-group col-md-2" id="div_puesto1" style="display:none">
                <label class="control-label text-bold">Por Puesto: </label>
            </div>
            <div class="form-group col-md-8" id="div_puesto2" style="display:none">
                <div class="n-chk">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                        <input type="checkbox" class="new-control-input" id="todos_puesto" name="todos_puesto" value="99" onchange="Toda_Puesto('1')">
                        <span class="new-control-indicator"></span>&nbsp;Seleccionar todos
                    </label>
                </div>
                <div id="cmb_puesto">

                    <select class="form-control multivalue" name="id_puesto[]" id="id_puesto" multiple="multiple">
                        @foreach ($list_responsable as $list)
                        <option value="{{ $list->id_puesto }}">{{ $list->nom_puesto }}</option>
                        @endforeach
                    </select>

                </div>
            </div>
            <div class="form-group col-md-2" id="div_puesto3" style="display:none">
                <div class="n-chk">
                    &nbsp;
                </div>
                <button class="btn btn-danger mt-3 " id="createProductBtn" onclick="Delete_Seccion_Portal(1,1);" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </button>
            </div>
        </div>


        <div class="row d-flex">
            <div class="form-group col-md-2" id="div_base1" style="display:none">
                <label class="control-label text-bold">Por Centro Labores: </label>
            </div>
            <div class="form-group col-md-8" id="div_base2" style="display:none">
                <div class="n-chk">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                        <input type="checkbox" class="new-control-input" id="todos_base" name="todos_base" value="99" onchange="Toda_Base('1')">
                        <span class="new-control-indicator"></span>&nbsp;Seleccionar todos
                    </label>
                </div>
                <div id="cmb_base">
                    <select class="form-control multivalue" name="cod_base[]" id="cod_base" multiple="multiple">
                        @foreach ($list_base as $list)
                        <option value="{{ $list->cod_base }}">{{ $list->cod_base }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-md-2" id="div_base3" style="display:none">

                <button class="btn btn-danger mt-3 " id="createProductBtn" onclick="Delete_Seccion_Portal(2,1);" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </button>
            </div>
        </div>



        <div class="row d-flex">
            <div class="form-group col-md-2" id="div_area1" style="display:none">
                <label class="control-label text-bold">Por Área: </label>
            </div>
            <div class="form-group col-md-8" id="div_area2" style="display:none">
                <div class="n-chk">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                        <input type="checkbox" class="new-control-input" id="todos_area" name="todos_area" value="99" onchange="Toda_Area('1')">
                        <span class="new-control-indicator"></span>&nbsp;Seleccionar todos
                    </label>
                </div>
                <div id="cmb_area">

                    <select class="form-control multivalue" name="id_area_acceso[]" id="id_area_acceso" multiple="multiple">
                        @foreach ($list_area as $list)
                        <option value="{{ $list->id_area }}">{{ $list->nom_area }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-md-2" id="div_area3" style="display:none">
                <div class="n-chk">
                    &nbsp;
                </div>
                <button class="btn btn-danger mt-3 " id="createProductBtn" onclick="Delete_Seccion_Portal(3,1);" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </button>
            </div>
        </div>


        <div class="row d-flex">
            <div class="form-group col-md-2" id="div_gerencia1" style="display:none">
                <label class="control-label text-bold">Por Gerencia: </label>
            </div>
            <div class="form-group col-md-8" id="div_gerencia2" style="display:none">
                <div class="n-chk">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                        <input type="checkbox" class="new-control-input" id="todos_gerencia" name="todos_gerencia" value="99" onchange="Toda_Gerencia('1')">
                        <span class="new-control-indicator"></span>&nbsp;Seleccionar todos
                    </label>
                </div>
                <div id="cmb_gerencia">

                    <select class="form-control multivalue" name="id_gerencia_acceso[]" id="id_gerencia_acceso" multiple="multiple">
                        @foreach ($list_gerencia as $list)
                        <option value="{{ $list->id_gerencia }}">{{ $list->nom_gerencia }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-md-2" id="div_gerencia3" style="display:none">
                <div class="n-chk">
                    &nbsp;
                </div>
                <button class="btn btn-danger mt-3 " id="createProductBtn" onclick="Delete_Seccion_Portal(4,1);" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </button>
            </div>
        </div>



        <div class="row d-flex">
            <div class="form-group col-md-2" id="div_nivel1" style="display:none">
                <label class="control-label text-bold">Por Nivel: </label>
            </div>
            <div class="form-group col-md-8" id="div_nivel2" style="display:none">
                <div class="n-chk">
                    <label class="new-control new-checkbox new-checkbox-rounded checkbox-primary">
                        <input type="checkbox" class="new-control-input" id="todos_nivel" name="todos_nivel" value="99" onchange="Toda_Nivel('1')">
                        <span class="new-control-indicator"></span>&nbsp;Seleccionar todos
                    </label>
                </div>
                <div id="cmb_nivel">

                    <select class="form-control multivalue" name="id_nivel_acceso[]" id="id_nivel_acceso" multiple="multiple">
                        @foreach ($list_nivel as $list)
                        <option value="{{ $list->id_nivel }}">{{ $list->nom_nivel }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group col-md-2" id="div_nivel3" style="display:none">
                <div class="n-chk">
                    &nbsp;
                </div>
                <button class="btn btn-danger mt-3 " id="createProductBtn" onclick="Delete_Seccion_Portal(5,1);" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                        <polyline points="3 6 5 6 21 6"></polyline>
                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                        <line x1="10" y1="11" x2="10" y2="17"></line>
                        <line x1="14" y1="11" x2="14" y2="17"></line>
                    </svg>
                </button>
            </div>
        </div>


        <div class="form-group col-md-2">
            <label class="control-label text-bold">Etiquetas: </label>
        </div>
        <div class="form-group col-md-10">
            <div>
                <select name="etiqueta[]" id="etiqueta" class="form-control tagging" multiple="multiple">

                </select>
            </div>
        </div>
        <div class="form-group col-md-2">
            <label>Archivo 1:</label>
        </div>
        <div class="form-group col-md-10">
            <input type="file" class="form-control-file" id="archivo" name="archivo" onchange="return Validar_Archivo_Portal('archivo')" />
        </div>
        <div class="form-group col-md-2">
            <label>Archivo 2:</label>
        </div>
        <div class="form-group col-md-10">
            <input type="file" class="form-control-file" id="archivo2" name="archivo2" onchange="return Validar_Archivo_Portal('archivo2')" />
        </div>
        <div class="form-group col-md-2">
            <label>Archivo 3:</label>
        </div>
        <div class="form-group col-md-10">
            <input type="file" class="form-control-file" id="archivo3" name="archivo3" onchange="return Validar_Archivo_Portal('archivo3')" />
        </div>
        <div class="form-group col-md-2">
            <label>Documento:</label>
        </div>
        <div class="form-group col-md-10">
            <input type="file" class="form-control-file" id="archivo4" name="archivo4" onchange="return Validar_Archivo_Backup('archivo4')" />
        </div>
        <div class="form-group col-md-2">
            <label>Diagrama:</label>
        </div>
        <div class="form-group col-md-10">
            <input type="file" class="form-control-file" id="archivo5" name="archivo5" onchange="return Validar_Archivo_Backup('archivo5')" />
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Funcion_Temporal();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    $('.multivalue').select2({
        dropdownParent: $('#ModalRegistro')
    });

    function Seccion_Portal(t) {
        v = "";
        if (t == 2) {
            v = "e";
        } else if (t == 3) {
            v = "nv";
        }
        var div_puesto1 = document.getElementById("div_puesto1" + v);
        var div_puesto2 = document.getElementById("div_puesto2" + v);
        var div_puesto3 = document.getElementById("div_puesto3" + v);
        var div_area1 = document.getElementById("div_area1" + v);
        var div_area2 = document.getElementById("div_area2" + v);
        var div_area3 = document.getElementById("div_area3" + v);
        var div_nivel1 = document.getElementById("div_nivel1" + v);
        var div_nivel2 = document.getElementById("div_nivel2" + v);
        var div_nivel3 = document.getElementById("div_nivel3" + v);
        var div_base1 = document.getElementById("div_base1" + v);
        var div_base2 = document.getElementById("div_base2" + v);
        var div_base3 = document.getElementById("div_base3" + v);
        var div_gerencia1 = document.getElementById("div_gerencia1" + v);
        var div_gerencia2 = document.getElementById("div_gerencia2" + v);
        var div_gerencia3 = document.getElementById("div_gerencia3" + v);
        if ($('#tipo_acceso' + v).val() == 1) {
            if ($('#div_puesto' + v).val() == 0) {
                div_puesto1.style.display = "block";
                div_puesto2.style.display = "block";
                div_puesto3.style.display = "block";
                $('#div_puesto' + v).val('1');
            }
        }
        if ($('#tipo_acceso' + v).val() == 2) {
            if ($('#div_base' + v).val() == 0) {
                div_base1.style.display = "block";
                div_base2.style.display = "block";
                div_base3.style.display = "block";
                $('#div_base' + v).val('1');
            }
        }
        if ($('#tipo_acceso' + v).val() == 3) {
            if ($('#div_area' + v).val() == 0) {
                div_area1.style.display = "block";
                div_area2.style.display = "block";
                div_area3.style.display = "block";
                $('#div_area' + v).val('1');
            }
        }
        if ($('#tipo_acceso' + v).val() == 4) {
            if ($('#div_gerencia' + v).val() == 0) {
                div_gerencia1.style.display = "block";
                div_gerencia2.style.display = "block";
                div_gerencia3.style.display = "block";
                $('#div_gerencia' + v).val('1');
            }
        }
        if ($('#tipo_acceso' + v).val() == 5) {
            if ($('#div_nivel' + v).val() == 0) {
                div_nivel1.style.display = "block";
                div_nivel2.style.display = "block";
                div_nivel3.style.display = "block";
                $('#div_nivel' + v).val('1');
            }
        }
    }

    function Delete_Seccion_Portal(div, t) {
        v = "";
        if (t == 2) {
            v = "e";
        } else if (t == 3) {
            v = "nv";
        }
        var div_puesto1 = document.getElementById("div_puesto1" + v);
        var div_puesto2 = document.getElementById("div_puesto2" + v);
        var div_puesto3 = document.getElementById("div_puesto3" + v);
        var div_area1 = document.getElementById("div_area1" + v);
        var div_area2 = document.getElementById("div_area2" + v);
        var div_area3 = document.getElementById("div_area3" + v);
        var div_nivel1 = document.getElementById("div_nivel1" + v);
        var div_nivel2 = document.getElementById("div_nivel2" + v);
        var div_nivel3 = document.getElementById("div_nivel3" + v);
        var div_base1 = document.getElementById("div_base1" + v);
        var div_base2 = document.getElementById("div_base2" + v);
        var div_base3 = document.getElementById("div_base3" + v);
        var div_gerencia1 = document.getElementById("div_gerencia1" + v);
        var div_gerencia2 = document.getElementById("div_gerencia2" + v);
        var div_gerencia3 = document.getElementById("div_gerencia3" + v);
        if (div == 1) {
            div_puesto1.style.display = "none";
            div_puesto2.style.display = "none";
            div_puesto3.style.display = "none";
            $('#div_puesto' + v).val('0');
            $('#id_puesto' + v).val('');
            $('#todos_puesto' + v).prop('checked', false);
            if (t == 1) {
                $('.multivalue_puesto').select2({
                    dropdownParent: $('#ModalRegistroSlide')
                });
            } else if (t == 3) {
                $('.multivalue_nv').select2({
                    dropdownParent: $('#ModalUpdateFull')
                });
            } else {
                $('.multivalue_puestoe').select2({
                    dropdownParent: $('#ModalUpdateSlide')
                });
            }
        }
        if (div == 2) {
            div_base1.style.display = "none";
            div_base2.style.display = "none";
            div_base3.style.display = "none";
            $('#div_base' + v).val('0');
            $('#cod_base' + v).val('');
            $('#todos_base' + v).prop('checked', false);
            if (t == 1) {
                $('.multivalue_base').select2({
                    dropdownParent: $('#ModalRegistroSlide')
                });
            } else if (t == 3) {
                $('.multivalue_nv').select2({
                    dropdownParent: $('#ModalUpdateFull')
                });
            } else {
                $('.multivalue_basee').select2({
                    dropdownParent: $('#ModalUpdateSlide')
                });
            }
        }
        if (div == 3) {
            div_area1.style.display = "none";
            div_area2.style.display = "none";
            div_area3.style.display = "none";
            $('#div_area' + v).val('0');
            $('#id_area_acceso' + v).val('');
            $('#todos_area' + v).prop('checked', false);
            if (t == 1) {
                $('.multivalue_area').select2({
                    dropdownParent: $('#ModalRegistroSlide')
                });
            } else if (t == 3) {
                $('.multivalue_nv').select2({
                    dropdownParent: $('#ModalUpdateFull')
                });
            } else {
                $('.multivalue_areae').select2({
                    dropdownParent: $('#ModalUpdateSlide')
                });
            }
        }
        if (div == 4) {
            div_gerencia1.style.display = "none";
            div_gerencia2.style.display = "none";
            div_gerencia3.style.display = "none";
            $('#div_gerencia' + v).val('0');
            $('#id_gerencia_acceso' + v).val('');
            $('#todos_gerencia' + v).prop('checked', false);
            if (t == 1) {
                $('.multivalue_gerencia').select2({
                    dropdownParent: $('#ModalRegistroSlide')
                });
            } else if (t == 3) {
                $('.multivalue_nv').select2({
                    dropdownParent: $('#ModalUpdateFull')
                });
            } else {
                $('.multivalue_gerenciae').select2({
                    dropdownParent: $('#ModalUpdateSlide')
                });
            }
        }
        if (div == 5) {
            div_nivel1.style.display = "none";
            div_nivel2.style.display = "none";
            div_nivel3.style.display = "none";
            $('#div_nivel' + v).val('0');
            $('#id_nivel_acceso' + v).val('');
            $('#todos_nivel' + v).prop('checked', false);
            if (t == 1) {
                $('.multivalue_nivel').select2({
                    dropdownParent: $('#ModalRegistroSlide')
                });
            } else if (t == 3) {
                $('.multivalue_nv').select2({
                    dropdownParent: $('#ModalUpdateFull')
                });
            } else {
                $('.multivalue_nivele').select2({
                    dropdownParent: $('#ModalUpdateSlide')
                });
            }
        }
    }


    function Insert_Funcion_Temporal() {
        // Cargando();

        // var dataString = new FormData(document.getElementById('formulario_insert'));
        // var url = "{{ route('funcion_temporal.store') }}";

        // $.ajax({
        //     url: url,
        //     data: dataString,
        //     type: "POST",
        //     processData: false,
        //     contentType: false,
        //     success: function(data) {
        //         swal.fire(
        //             '¡Registro Exitoso!',
        //             '¡Haga clic en el botón!',
        //             'success'
        //         ).then(function() {
        //             Lista_Funcion_Temporal();
        //             $("#ModalRegistro .close").click();
        //         });
        //     },
        //     error: function(xhr) {
        //         var errors = xhr.responseJSON.errors;
        //         var firstError = Object.values(errors)[0][0];
        //         Swal.fire(
        //             '¡Ups!',
        //             firstError,
        //             'warning'
        //         );
        //     }
        // });
    }
</script>