<div class="toolbar d-flex">
    <div class="col-lg-12 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('insumo_en.create') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg>
            Registrar
        </button>
    </div>
</div>

<div class="table-responsive mb-4 mt-4" id="lista_entrada_insumo">
</div>

<script>
    Lista_Entrada_Insumo();

    function Lista_Entrada_Insumo(){
        Cargando();

        var url = "{{ route('insumo_en.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            success:function (resp) {
                $('#lista_entrada_insumo').html(resp);  
            }
        });
    }

    function solo_Numeros(e) {
        var key = event.which || event.keyCode;
        if (key >= 48 && key <= 57) {
            return true;
        } else {
            return false;
        }
    }

    function Valida_Archivo(val){
        Cargando();

        var archivoInput = document.getElementById(val);
        var archivoRuta = archivoInput.value;
        var extPermitidas = /(.pdf|.png|.jpg|.jpeg)$/i;

        if(!extPermitidas.exec(archivoRuta)){
            Swal({
                title: '¡Registro Denegado!',
                text: "Asegurese de ingresar archivo con extensión .pdf|.jpg|.png|.jpeg",
                type: 'error',
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK',
            });
            archivoInput.value = ''; 
            return false;
        }else{
            return true;         
        }
    }

    function Descargar_Archivo(id,tipo){
        window.location.replace("{{ route('insumo_en.download', [':id', ':tipo']) }}".replace(':id', id).replace(':tipo', tipo));
    }

    function Delete_Entrada_Insumo(id) {
        Cargando();

        var url = "{{ route('insumo_en.destroy', ':id') }}".replace(':id', id);

        Swal({
            title: '¿Realmente desea eliminar el registro?',
            text: "El registro será eliminado permanentemente",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No',
            padding: '2em'
        }).then((result) => {
            if (result.value) {
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
                            Lista_Entrada_Insumo();
                        });    
                    }
                });
            }
        })
    }
</script>