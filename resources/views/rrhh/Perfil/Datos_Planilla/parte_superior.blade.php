<div class="col-lg-11 mx-auto">
    <div class="row">
        <div class="col-lg-12">
            <div class="col-lg-12 row">
                <div class="col-lg-1">
                    <div class="form-group">
                        <label>Estado</label></br>
                        @if (isset($get_id->id_historico_colaborador))
                            <label style="color:black"><b>{{ $get_id->nom_estado }}</b></label>
                        @endif
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>Situación&nbsp;Laboral</label></br>
                        @if (isset($get_id->id_historico_colaborador))
                            <label style="color:black"><b>{{ $get_id->nom_situacion_laboral }}</b></label>
                        @endif
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label>Fecha&nbsp;Inicio</label></br>
                        @if (isset($get_id->id_historico_colaborador))
                            <label style="color:black"><b>{{ $get_id->fec_inicio }}</b></label>
                        @endif
                    </div>
                </div>
                @if (isset($get_id->id_historico_colaborador) && $get_id->id_situacion_laboral!="1")
                    <div class="col-lg-5">
                        <div class="form-group">
                            <label>Empresa</label></br>
                            <label style="color:black"><b>{{ $get_id->nom_empresa }}</b></label>
                        </div>
                    </div>
                @endif
                @if (isset($get_id->id_historico_colaborador) && $get_id->id_situacion_laboral!="1")
                    <div class="col-lg-2">
                        <div class="form-group">
                            <label>Régimen</label></br>
                            <label style="color:black"><b>{{ $get_id->nom_regimen }}</b></label>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>