<form id="formulario" method="post" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar Nuevo Requerimiento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>

    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row mb-2">
            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Año: </label>
            </div>
            <div class="form-group col-md-3">
                <select class="form-control" id="anio" name="anio">
                    <option value="0">Seleccione</option>
                    <?php foreach($list_anio as $list){ ?>
                        <option value="<?php echo $list['cod_anio']; ?>" <?php if($list['cod_anio']==date('Y')){ echo "selected"; } ?>><?php echo $list['cod_anio'];?></option>
                    <?php } ?>
                </select>
            </div>

            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Semana: </label>
            </div>
            <div class="form-group col-sm-2">
                <select class="form-control" id="semana" name="semana">
                    <option value="0">Seleccione</option>
                    <option <?php if(date('W') === "01") {echo "selected";} ?> value="1">01</option>
                    <option <?php if(date('W') === "02") {echo "selected";} ?> value="2">02</option>
                    <option <?php if(date('W') === "03") {echo "selected";} ?> value="3">03</option>
                    <option <?php if(date('W') === "04") {echo "selected";} ?> value="4">04</option>
                    <option <?php if(date('W') === "05") {echo "selected";} ?> value="5">05</option>
                    <option <?php if(date('W') === "06") {echo "selected";} ?> value="6">06</option>
                    <option <?php if(date('W') === "07") {echo "selected";} ?> value="7">07</option>
                    <option <?php if(date('W') === "08") {echo "selected";} ?> value="8">08</option>
                    <option <?php if(date('W') === "09") {echo "selected";} ?> value="9">09</option>
                    <option <?php if(date('W') === "10") {echo "selected";} ?> value="10">10</option>
                    <option <?php if(date('W') === "11") {echo "selected";} ?> value="11">11</option>
                    <option <?php if(date('W') === "12") {echo "selected";} ?> value="12">12</option>
                    <option <?php if(date('W') === "13") {echo "selected";} ?> value="13">13</option>
                    <option <?php if(date('W') === "14") {echo "selected";} ?> value="14">14</option>
                    <option <?php if(date('W') === "15") {echo "selected";} ?> value="15">15</option>
                    <option <?php if(date('W') === "16") {echo "selected";} ?> value="16">16</option>
                    <option <?php if(date('W') === "17") {echo "selected";} ?> value="17">17</option>
                    <option <?php if(date('W') === "18") {echo "selected";} ?> value="18">18</option>
                    <option <?php if(date('W') === "19") {echo "selected";} ?> value="19">19</option>
                    <option <?php if(date('W') === "20") {echo "selected";} ?> value="20">20</option>
                    <option <?php if(date('W') === "21") {echo "selected";} ?> value="21">21</option>
                    <option <?php if(date('W') === "22") {echo "selected";} ?> value="22">22</option>
                    <option <?php if(date('W') === "23") {echo "selected";} ?> value="23">23</option>
                    <option <?php if(date('W') === "24") {echo "selected";} ?> value="24">24</option>
                    <option <?php if(date('W') === "25") {echo "selected";} ?> value="25">25</option>
                    <option <?php if(date('W') === "26") {echo "selected";} ?> value="26">26</option>
                    <option <?php if(date('W') === "27") {echo "selected";} ?> value="27">27</option>
                    <option <?php if(date('W') === "28") {echo "selected";} ?> value="28">28</option>
                    <option <?php if(date('W') === "29") {echo "selected";} ?> value="29">29</option>
                    <option <?php if(date('W') === "30") {echo "selected";} ?> value="30">30</option>
                    <option <?php if(date('W') === "31") {echo "selected";} ?> value="31">31</option>
                    <option <?php if(date('W') === "32") {echo "selected";} ?> value="32">32</option>
                    <option <?php if(date('W') === "33") {echo "selected";} ?> value="33">33</option>
                    <option <?php if(date('W') === "34") {echo "selected";} ?> value="34">34</option>
                    <option <?php if(date('W') === "35") {echo "selected";} ?> value="35">35</option>
                    <option <?php if(date('W') === "36") {echo "selected";} ?> value="36">36</option>
                    <option <?php if(date('W') === "37") {echo "selected";} ?> value="37">37</option>
                    <option <?php if(date('W') === "38") {echo "selected";} ?> value="38">38</option>
                    <option <?php if(date('W') === "39") {echo "selected";} ?> value="39">39</option>
                    <option <?php if(date('W') === "40") {echo "selected";} ?> value="40">40</option>
                    <option <?php if(date('W') === "41") {echo "selected";} ?> value="41">41</option>
                    <option <?php if(date('W') === "42") {echo "selected";} ?> value="42">42</option>
                    <option <?php if(date('W') === "43") {echo "selected";} ?> value="43">43</option>
                    <option <?php if(date('W') === "44") {echo "selected";} ?> value="44">44</option>
                    <option <?php if(date('W') === "45") {echo "selected";} ?> value="45">45</option>
                    <option <?php if(date('W') === "46") {echo "selected";} ?> value="46">46</option>
                    <option <?php if(date('W') === "47") {echo "selected";} ?> value="47">47</option>
                    <option <?php if(date('W') === "48") {echo "selected";} ?> value="48">48</option>
                    <option <?php if(date('W') === "49") {echo "selected";} ?> value="49">49</option>
                    <option <?php if(date('W') === "50") {echo "selected";} ?> value="50">50</option>
                    <option <?php if(date('W') === "51") {echo "selected";} ?> value="51">51</option>
                    <option <?php if(date('W') === "52") {echo "selected";} ?> value="52">52</option>
                </select>
            </div>
        </div>
        <div class="col-md-12 row">
            <div class="form-group col-md-4">
                <label class="col-sm-12 control-label text-bold">Adjuntar Documento: </label>
            </div>
            <div class="form-group col-sm-5">
                <input type="file" class="form-control-file" id="drequerimiento" name="drequerimiento">
            </div>
        </div>
    </div>

    <div class="modal-footer">
    <button class="btn btn-primary mt-3" type="button" onclick="Insert_Requerimiento();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>
<script>
    function Insert_Requerimiento() {
        Cargando();
        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ url('RequerimientoSurtido/Insert_Requerimiento') }}";
        var csrfToken = $('input[name="_token"]').val();

            $.ajax({
                url: url,
                data: dataString,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                type: "POST",
                processData: false,
                contentType: false,

                success: function(data) {
                    var cadena = data.trim();
                    validacion = cadena.substr(0, 1);
                    mensaje = cadena.substr(1);
                    if (validacion == 1) {
                        swal.fire(
                            'Carga con Errores!',
                            mensaje,
                            'warning'
                        ).then(function() {
                            Buscar_Semana();
                        });
                    } else if (validacion == 2) {
                        swal.fire(
                            'Carga Exitosa!',
                            mensaje,
                            'success'
                        ).then(function() {
                            $("#ModalRegistro .close").click()
                            Buscar_Semana();
                        });
                    } else if (validacion == 3) {
                        swal.fire(
                            'Archivo no subido por errores de duplicados en el mismo archivo: ',
                            mensaje,
                            'warning'
                        ).then(function() {
                            Buscar_Semana();
                        });
                    } else if (validacion == 4) {
                        swal.fire(
                            'Archivo no subido por errores de duplicados o valores inválidos con otro usuario: ',
                            mensaje,
                            'warning'
                        ).then(function() {
                            Buscar_Semana();
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
