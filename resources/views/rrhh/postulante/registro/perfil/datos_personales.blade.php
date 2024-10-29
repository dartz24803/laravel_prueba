<link href="{{ asset('template/assets/css/users/account-setting.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('template/assets/js/users/account-settings.js') }}"></script>

<div class="col-lg-2 col-md-4 d-lg-block d-flex justify-content-center">
    <div class="upload mt-4 pr-md-4">
        <input type="file" class="dropify" id="foto" name="foto"
        data-default-file="@php if($get_id->foto!=""){ echo $get_id->foto; }else{ echo asset('template/assets/img/200x200.jpg'); } @endphp" onchange="Valida_Archivo('foto');">
        <p class="mt-2"><i class="flaticon-cloud-upload mr-1"></i> Actualizar imagen</p>
    </div>
</div>
<div class="col-lg-10 col-md-8 mt-md-0 mt-4">
    <div class="form">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="postulante_apater">Apellido paterno</label>
                    <input type="text" class="form-control" 
                    id="postulante_apater" name="postulante_apater" 
                    placeholder="Apellido paterno" 
                    value="{{ $get_id->postulante_apater }}">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="postulante_amater">Apellido materno</label>
                    <input type="text" class="form-control" 
                    id="postulante_amater" name="postulante_amater" 
                    placeholder="Apellido materno" value="{{ $get_id->postulante_amater }}">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="postulante_nombres">Nombres</label>
                    <input type="text" class="form-control" 
                    id="postulante_nombres" name="postulante_nombres" 
                    placeholder="Nombres" value="{{ $get_id->postulante_nombres }}">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="id_tipo_documento">Tipo de documento</label>
                    <select class="form-control" name="id_tipo_documento" id="id_tipo_documento">
                        <option value="0">Seleccione</option>
                        @foreach ($list_tipo_documento as $list)
                            <option value="{{ $list->id_tipo_documento }}"
                            @if ($list->id_tipo_documento==$get_id->id_tipo_documento) selected @endif>
                                {{ $list->cod_tipo_documento }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="num_doc">Número de documento</label>
                    <input type="text" class="form-control" 
                    id="num_doc" name="num_doc" 
                    placeholder="Número de documento" onkeypress="return solo_Numeros(event);"
                    value="{{ $get_id->num_doc }}">
                </div>
            </div>                                                                
        </div>
        <div class="row">
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="id_nacionalidad">Nacionalidad</label>
                    <select class="form-control" name="id_nacionalidad" id="id_nacionalidad">
                        <option value="0">Seleccione</option>
                        @foreach ($list_nacionalidad as $list)
                            <option value="{{ $list->id_nacionalidad }}"
                            @if ($list->id_nacionalidad==$get_id->id_nacionalidad) selected @endif>
                                {{ $list->nom_nacionalidad }}
                            </option>
                        @endforeach                                                                            
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="id_genero">Género</label>
                    <select class="form-control" name="id_genero" id="id_genero">
                        <option value="0">Seleccione</option>
                        @foreach ($list_genero as $list)
                            <option value="{{ $list->id_genero }}"
                            @if ($list->id_genero==$get_id->id_genero) selected @endif>
                                {{ $list->nom_genero }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="id_estado_civil">Estado civil</label>
                    <select class="form-control" name="id_estado_civil" id="id_estado_civil">
                        <option value="0">Seleccione</option>
                        @foreach ($list_estado_civil as $list)
                            <option value="{{ $list->id_estado_civil }}"
                            @if ($list->id_estado_civil==$get_id->id_estado_civil) selected @endif>
                                {{ $list->nom_estado_civil }}
                            </option>
                        @endforeach                                                                            
                    </select>
                </div>
            </div>
            <div class="col-xl-2 col-lg-3">
                <div class="form-group">
                    <label for="fullName">Fecha de nacimiento</label>
                    <input type="date" class="form-control" 
                    id="fec_nac" name="fec_nac" 
                    value="{{ $get_id->fec_nac }}" onblur="Traer_Edad();">
                </div>
            </div>
            <div class="col-xl-1 d-xl-block d-none">
                <div class="form-group">
                    <label for="fullName">Edad</label>
                    <input type="text" class="form-control" id="edad" value="{{ $get_id->edad }}" readonly>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <label for="emailp">Correo electrónico</label>
                    <input type="text" class="form-control" 
                    id="emailp" name="emailp" 
                    placeholder="Correo electrónico"
                    value="{{ $get_id->emailp }}">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="num_celp">Número celular</label>
                    <input type="text" class="form-control" 
                    id="num_celp" name="num_celp" 
                    placeholder="Número celular" onkeypress="return solo_Numeros(event);"
                    value="{{ $get_id->num_celp }}">
                </div>
            </div>
            <div class="col-lg-3">
                <div class="form-group">
                    <label for="num_fijop">Teléfono fijo</label>
                    <input type="text" class="form-control" 
                    id="num_fijop" name="num_fijop" 
                    placeholder="Teléfono fijo" onkeypress="return solo_Numeros(event);"
                    value="{{ $get_id->num_fijop }}">
                </div>
            </div>
        </div>
    </div>
</div>