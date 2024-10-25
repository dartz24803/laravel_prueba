<form id="formularioc" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registro pagos:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Fecha:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="date" class="form-control" name="fechac" id="fechac" value="{{ date('Y-m-d') }}">
            </div>

            <div class="form-group col-lg-2">
                <label>Monto:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" name="montoc" id="montoc" placeholder="Monto" 
                onkeypress="return solo_Numeros_Punto(event);" onpaste="return false;">
            </div>
        </div>

        <div class="row" id="lista_credito">
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Saldo:</label>
            </div>
            <div class="form-group col-lg-4">
                <input type="text" class="form-control" id="saldo" disabled>
            </div>
        </div>
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Credito();">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Adicionar
        </button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>Cerrar</button>
    </div>
</form>

<script>
    Lista_Credito();
    Saldo();

    function Lista_Credito(){
        Cargando();

        var url = "{{ route('caja_chica.list_credito') }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#lista_credito').html(resp);  
            }
        });
    }

    function Saldo(){
        Cargando();

        var url = "{{ route('caja_chica.saldo', $id) }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#saldo').val(resp);  
            }
        });
    }

    function Insert_Credito() {
        Cargando();

        var dataString = new FormData(document.getElementById('formularioc'));
        var url = "{{ route('caja_chica.store_cr', $id) }}";

        $.ajax({
            url: url,
            data: dataString,
            type: "POST",
            processData: false,
            contentType: false,
            success: function(data) {
                if(data=="error"){
                    Swal({
                        title: '¡Registro Denegado!',
                        text: "¡Está sobrepasando el monto total!",
                        type: 'error',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK',
                    });
                }else{
                    swal.fire(
                        '¡Registro Exitoso!',
                        '¡Haga clic en el botón!',
                        'success'
                    ).then(function() {
                        Lista_Credito();
                        Saldo();
                        $('#fechac').val('');
                        $('#montoc').val('');
                    })
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

    function Delete_Credito(id) {
        Cargando();

        var url = "{{ route('caja_chica.destroy_cr', ':id') }}".replace(':id', id);

        $.ajax({
            type: "DELETE",
            url: url,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function() {
                Swal(
                    '¡Eliminado!',
                    'El registro ha sido eliminado satisfactoriamente.',
                    'success'
                ).then(function() {
                    Lista_Credito();
                    Saldo();
                });    
            }
        });
    }
</script>
