<div class="toolbar d-flex">
    <div class="col-lg-12 d-flex justify-content-end">
        <a type="button" class="btn btn-primary" title="Registrar" 
        href="{{ route('avisita_conf_pr.create', $tipo) }}" target="_blank">
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                <line x1="12" y1="8" x2="12" y2="16"></line>
                <line x1="8" y1="12" x2="16" y2="12"></line>
            </svg>
            Registrar
        </a>
    </div>
</div>

<div class="table-responsive mb-4 mt-4" id="lista_proveedor">
</div>

<script>
    Lista_Proveedor();

    function Lista_Proveedor(){
        Cargando();

        var url = "{{ route('avisita_conf_pr.list') }}";

        $.ajax({
            url: url,
            type: "POST",
            data:{'tipo':{{ $tipo }}},
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success:function (resp) {
                $('#lista_proveedor').html(resp);  
            }
        });
    }

    function Delete_Proveedor(id) {
        Cargando();

        var url = "{{ route('avisita_conf_pr.destroy', ':id') }}".replace(':id', id);

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
                            Lista_Proveedor();
                        });    
                    }
                });
            }
        })
    }
</script>