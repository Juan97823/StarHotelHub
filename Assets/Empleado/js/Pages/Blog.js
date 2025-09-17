$(document).ready(function () {
    // Si la tabla ya está inicializada, destrúyela antes de crear una nueva
    if ($.fn.DataTable.isDataTable('#tblBlog')) {
        $('#tblBlog').DataTable().clear().destroy();
    }

    const tabla = $('#tblBlog').DataTable({
        ajax: {
            url: 'admin/blog/listarEntradas',
            dataSrc: 'data'
        },
        columns: [
            { data: 0 },
            { data: 1 },
            { data: 2 },
            { data: 3 },
            { data: 4 },
            { data: 5 }
        ],
        language: {
            language: {
                url: '/StarHotelHub/assets/admin/js/lang/es-ES.json'
            }

        },
        columnDefs: [
            { targets: 3, orderable: false, searchable: false },
            { targets: 5, orderable: false, searchable: false }
        ]
    });

    $('#tblBlog tbody').on('click', '.btn-eliminar', function () {
        const fila = $(this).closest('tr');
        const data = tabla.row(fila).data();
        const id = data[0];

        if (confirm('¿Estás seguro de eliminar esta entrada?')) {
            $.ajax({
                url: 'admin/blog/eliminar/' + id,
                type: 'POST',
                success: function () {
                    alert('Entrada eliminada correctamente.');
                    tabla.ajax.reload(null, false);
                },
                error: function () {
                    alert('Error al eliminar la entrada.');
                }
            });
        }
    });
});
