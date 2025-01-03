<form id="formulario" method="POST" enctype="multipart/form-data" class="needs-validation">
    <div class="modal-header">
        <h5 class="modal-title">Registrar nueva complejidad:</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <svg aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
        </button>
    </div>
                
    <div class="modal-body" style="max-height:700px; overflow:auto;">
        <div class="row">
            <div class="form-group col-lg-2">
                <label>Módulo:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="id_modulo" id="id_modulo">
                    <option value="0">Seleccione</option>
                    @foreach ($list_modulo as $list)
                        <option value="{{ $list->id_modulo }}">{{ $list->nom_modulo }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-lg-2">
                <label>Dificultad:</label>
            </div>
            <div class="form-group col-lg-4">
                <select class="form-control" name="dificultad" id="dificultad">
                    <option value="0">Seleccione</option>
                    @php $i = 1; @endphp
                    @while ($i<=7)
                        <option value="{{ $i }}">{{ $i }}</option>
                        @php $i++; @endphp
                    @endwhile
                </select>
            </div>
        </div>

        <div class="row">
            <div class="form-group col-lg-2">
                <label>Descripción:</label>
            </div>
            <div class="form-group col-lg-10">
                <input type="text" class="form-control" id="descripcion" name="descripcion" 
                placeholder="Descripción">
            </div>
        </div> 
    </div>

    <div class="modal-footer">
        @csrf
        <button class="btn btn-primary" type="button" onclick="Insert_Complejidad();">Guardar</button>
        <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i> Cancelar</button>
    </div>
</form>

<script>
    function Insert_Complejidad() {
        Cargando();

        var dataString = new FormData(document.getElementById('formulario'));
        var url = "{{ route('ticket_conf_co.store') }}";

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
                        text: "¡El registro ya existe!",
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
                        Lista_Complejidad();
                        $("#ModalRegistro .close").click();
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
</script>
