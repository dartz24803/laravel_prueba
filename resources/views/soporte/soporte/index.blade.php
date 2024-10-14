@extends('layouts.plantilla')

@section('navbar')
@include('logistica.navbar')
@endsection

@section('content')
<div id="content" class="main-content">
    <div class="layout-px-spacing">
        <div class="page-header">
            <div class="page-title">
                <h3>Soporte
                </h3>
            </div>
        </div>

        <div class="row" id="cancel-row">
            <div class="col-xl-12 col-lg-12 col-sm-12  layout-spacing">
                <div class="widget-content widget-content-area br-2">
                    <div class="toolbar d-flex p-4">

                        <button type="button" class="btn btn-primary" title="Registrar" data-toggle="modal" data-target="#ModalRegistro" app_reg="{{ route('errorespicking.create') }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-square">
                                <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="12" y1="8" x2="12" y2="16"></line>
                                <line x1="8" y1="12" x2="16" y2="12"></line>
                            </svg>
                            Registrar
                        </button>
                    </div>
                    @csrf
                    <div class="table-responsive mb-4 mt-4" id="lista_reproceso">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#soporte").addClass('active');
        $("#hsoporte").attr('aria-expanded', 'true');

        Lista_Tickets_Soporte();
    });

    function Lista_Tickets_Soporte() {
        Cargando();

        var url = "{{ route('soporte_ticket.list') }}";

        $.ajax({
            url: url,
            type: "GET",
            success: function(resp) {
                $('#lista_reproceso').html(resp);
            }
        });
    }


    function Delete_ErroresPicking(id) {
        Cargando();

        var url = "{{ route('errorespicking.destroy', ':id') }}".replace(':id', id);
        var csrfToken = $('input[name="_token"]').val();

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
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function() {
                        Swal(
                            '¡Eliminado!',
                            'El registro ha sido eliminado satisfactoriamente.',
                            'success'
                        ).then(function() {
                            Lista_Tickets_Soporte();
                        });
                    }
                });
            }
        })
    }
</script>

@endsection