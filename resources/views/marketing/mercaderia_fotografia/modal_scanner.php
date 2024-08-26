<!--
    <div class="modal-header">
        <h5 class="modal-title">Validar Fotografías</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>    
    
    <div class="modal-body" style="max-height:450px; overflow:auto;">
        <div class="col-md-12 row mb-2">
            <div class="form-group col-md-2">
                <label class="col-sm-12 control-label text-bold">Observación: </label>
            </div>  
            <div class="form-group col-md-10">
                <input type="text" class="form-control" name="observacion_val" id="observacion_val">
            </div>
        </div>
    </div>

    <div class="modal-footer">
    <button class="btn btn-primary mt-3" type="button" onclick="Validar_Fotografia();">Guardar</button>
        <button class="btn mt-3" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
<script>
    $('#observacion_val').bind('keyup paste', function(){
        var data=$('#observacion_val').val();
        $('#observacion_validacion').val(data);
    });
</script>-->
<script src="<?= base_url() ?>template/docs/js/jquery-3.2.1.min.js"></script>
<link href="<?php echo base_url(); ?>template/assets/libs/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
<!DOCTYPE html>
<style>
	.btn {
    display: inline-block;
    margin-bottom: 0;
    font-weight: normal;
    text-align: center;
    vertical-align: middle;
    touch-action: manipulation;
    cursor: pointer;
    background-image: none;
    border: 1px solid transparent;
    white-space: nowrap;
    padding: 7px 12px;
    font-size: 13px;
    line-height: 1.5384616;
    border-radius: 3px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
    user-select: none;
	}

	body {
    font-family: "Roboto", Helvetica Neue, Helvetica, Arial, sans-serif;
    font-size: 16px;
    line-height: 1.5384616;
    color: #333333;
    background-color: #f5f5f5;
	}
    /*#contenedor{
        height:100%;
    }*/
</style>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width">
    <title>Leer código de barras de producton</title>
    <link href="<?= base_url() ?>template/scanner/style2.css" rel="stylesheet" type="text/css">
  </head>
  <body>
        
		
        <div class="modal-body" style="max-height:500px; overflow:auto;">
            <div id="contenedor"></div>
            <div class="col-md-12 ">
                
            </div>
        </div>
        <div class="col-md-12 ">
                
                <p id="resultado">Aquí aparecerá el código</p>
                <input type="hidden" class="form-control"  id="codigo" name="codigo" autofocus>
                <input type="hidden" class="form-control"  id="mes" name="mes" autofocus value="<?php echo $mes ?>">
                <input type="hidden" class="form-control"  id="anio" name="anio" autofocus value="<?php echo $anio ?>">
                <p>A continuación, capture el codigo de barras: </p>
                <div class="form-group col-md-2">
                    <label class="col-sm-12 control-label text-bold">Observación: </label>
                </div>  
                <div class="form-group col-md-10">
                    <textarea style="width: 100%;" class="form-control" name="observacion_val" id="observacion_val" cols="30" rows="4"></textarea>
                </div>
            </div>
        <div class="modal-footer" style="float: right;">
            <br>
            <button type="button" class="btn btn-primary" onclick="Validar()" style="background-color: #1b55e2;color: #fff;border: 1px solid #1b55e2;" data-loading-text="Loading..." autocomplete="off">
                <i class="glyphicon glyphicon-ok-sign"></i> Validar
            </button>
            <button type="button" class="btn btn-default" onclick="Cerrar_Ventana_Emegente();" style="background-color: #fff;color: #1b55e2;font-weight: 700;border: 1px solid #e8e8e8;">
                <i class="glyphicon glyphicon-remove-sign"></i> Cancelar
            </button>
        </div>
        
		<script src="<?= base_url() ?>template/scanner/quagga.min.js"></script>
  </body>
</html>
<script src="<?php echo base_url(); ?>template/assets/libs/sweetalert2/dist/sweetalert2.min.js"></script>
<script>


    //formatos soportados
    //code_128_reader
    //code_39_reader
    //code_39_vin_reader
    //ean_reader
    //ean_extended_reader
    //ean_8_reader
    //upc_reader
    //upc_e_reader
    //codabar_reader
    //i2of5_reader
    //2of5_reader
    //code_93_reader
    document.addEventListener("DOMContentLoaded", () => {
	const $resultados = document.querySelector("#resultado");
    const $codigos = document.querySelector("#codigo");
	Quagga.init({
		inputStream: {
			constraints: {
				width: 1920,
				height: 1080,
			},
			name: "Live",
			type: "LiveStream",
			target: document.querySelector('#contenedor'), // Pasar el elemento del DOM
		},
		decoder: {
			readers: ["code_128_reader"]
		}
	}, function (err) {
		if (err) {
			console.log(err);
			return
		}
		console.log("Iniciado correctamente");
		Quagga.start();
	});

	Quagga.onDetected((data) => {
		$resultados.textContent = data.codeResult.code;
        $codigos.value = data.codeResult.code;
        
        
		// Imprimimos todo el data para que puedas depurar
		console.log(data);
	});

	Quagga.onProcessed(function (result) {
		var drawingCtx = Quagga.canvas.ctx.overlay,
			drawingCanvas = Quagga.canvas.dom.overlay;

		if (result) {
			if (result.boxes) {
				drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));
				result.boxes.filter(function (box) {
					return box !== result.box;
				}).forEach(function (box) {
					Quagga.ImageDebug.drawPath(box, { x: 0, y: 1 }, drawingCtx, { color: "green", lineWidth: 2 });
				});
			}

			if (result.box) {
				Quagga.ImageDebug.drawPath(result.box, { x: 0, y: 1 }, drawingCtx, { color: "#00F", lineWidth: 2 });
			}

			if (result.codeResult && result.codeResult.code) {
				Quagga.ImageDebug.drawPath(result.line, { x: 'x', y: 'y' }, drawingCtx, { color: 'red', lineWidth: 3 });
			}
		}
	});
	});

    function Cerrar_Ventana_Emegente()
    {
		window.close();
        
        window.location.href = window.location.href;
        

        var w = window.open("<?= site_url('Logistica/Mercaderia_Fotografia/2')?>","toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=400, height=400");
        w.onunload = function () {
        window.parent.popupClosing()
        };
    }
    function Validar()
    {
        var url="<?php echo site_url(); ?>Logistica/Validar_Codigo_Scanner";
        var codigo=$('#codigo').val();
        var mes=$('#mes').val();
        var anio=$('#anio').val();
        var observacion_val=$('#observacion_val').val();
        if($('#codigo').val().trim()===""){
		   Swal(
                '',
                '<b>Debe capturar un código para validar!</b>',
                'warning'
            ).then(function() { });
        }else{
            $.ajax({
                type:"POST",
                url: url,
                data:{'codigo':codigo,'mes':mes,'anio':anio,'observacion_val':observacion_val},
                success:function (data) {
                    if(data=="1"){
						Swal(
							'',
							'<b>Código no encontrado!</b>',
							'warning'
						).then(function() { });
                    }else if(data=="2"){
                        
						Swal(
							'',
							'<b>Código ya validado!</b>',
							'warning'
						).then(function() { });
                    }else{
						Swal(
							'',
							'<b>Código validado exitosamente!</b>',
							'success'
						).then(function() { 
                            window.close();
							window.location.href = window.location.href;
                            var w = window.open("<?= site_url('Logistica/Mercaderia_Fotografia/2')?>","toolbar=yes, location=yes, directories=no, status=no, menubar=yes, scrollbars=yes, resizable=no, copyhistory=yes, width=400, height=400");
                            w.onunload = function () {
                                window.parent.popupClosing()
                            };
						});
						
                    }
                    
                }
            });
        }
        
        
    }
</script>