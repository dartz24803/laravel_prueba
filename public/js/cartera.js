$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
const form_registrar = $('#form_cartera');
$('#NuevaCartera').on('click', function() {
    form_registrar[0].reset();
});
/**EDITAR */
function editar(id_cartera) {
    $.get( "http://127.0.0.1:8000/buscarCartera", { id: id_cartera },
        function (data) {
            $('#collapseCardCartera').collapse('show');
            $('#id_cartera').val(data.data[0].id_cartera);
            $('#codigo').val(data.data[0].codigo);
            $('#ruc').val(data.data[0].ruc);
            $('#razon_social').val(data.data[0].razon_social);
            $('#nombre_comercial').val(data.data[0].nombre_comercial);
        },
        "json"
    );
}
//CRUD
/* REGISTRAR Y EDITAR */
$(form_registrar).submit(function (e) {
    e.preventDefault();
    const dato = new FormData(form_registrar[0]);
    $.ajax({
        type: "post",
        url: "http://127.0.0.1:8000/registraryeditarCartera",
        data: dato,
        dataType: "json",
        cache: false,
        contentType: false,
        processData: false,
        success: function (response) {
            if (response.error == "") {
                $('#table_carteras').DataTable().ajax.reload();
                form_registrar[0].reset();
                swal.fire({
                    title: response.ok,
                    html: "¡Correcto!",
                    icon: "success",
                    timer: 3000,
                    showConfirmButton: false,
                });
                $('#collapseCardCartera').collapse('hide');
                return false;
            } else {
                swal.fire({
                    title: "¡Cuidado con ingresar datos erroneos!",
                    html: response.error,
                    icon: "error",
                    showConfirmButton: true,
                });
            }
        }
    });
});


/**Listar */
$(document).ready(function () {
    listar();
});
function listar() {
    $('#table_carteras').DataTable({
        "aProcessing": true,
        "aServerSide": true,
        dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row'<'col-sm-12 col-md-6'i><'col-sm-12 col-md-6'p>>",
        "ajax": {
            url: "http://127.0.0.1:8000/Carteralistar",
            type: "post"
        },
        "bDestroy": true,
        "responsive": true,
        "bInfo": true,
        "iDisplayLength": 5,
        "order": [[0, "desc"]],
        "language": {
            "sProcessing": "Procesando...",
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "Buscar:",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        },
        "pagingType": "simple_numbers",
        "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
    });
}

/**ELIMINAR */
function eliminar(id_cartera) {
    swal.fire({
        title: "Eliminar!",
        text: "Desea Eliminar el Registro?",
        icon: "error",
        confirmButtonText: "Si",
        showCancelButton: true,
        cancelButtonText: "No",
    }).then((result) => {
        if (result.value) {
            $.get("http://127.0.0.1:8000/eliminarCartera", { id: id_cartera },
                function (data, textStatus, jqXHR) {
                    console.log(data);
                    if (data.error == "") {
                        $('#table_carteras').DataTable().ajax.reload();
                        Swal.fire({
                            title: 'Correcto!',
                            text: data.ok,
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    } else {
                        Swal.fire({
                            title: 'Error!',
                            text: data.error,
                            icon: 'error',
                            showConfirmButton: true,
                        })
                    }
                },
                "json"
            );
        }
    });
}
