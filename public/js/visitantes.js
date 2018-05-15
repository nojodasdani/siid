$(document).ready(function () {
    $('#tabla').DataTable({
        "columns": [
            null,
            {"width": "10%"},
            {"width": "20%"},
            {"width": "20%"},
            {"width": "15%"},
            {"width": "15%"},
            {"width": "10%"},
            {"width": "10%"},
        ],
        "aaSorting": [[0, 'desc']],
        "columnDefs": [
            {
                "targets": [0],
                "visible": false,
                "searchable": false
            },
        ],
    });

    $(document).on('change', '.cambiar', function () {
        var valor = $(this).prop('checked');
        var id = $(this).parent().parent().attr('id');
        valor = (valor) ? 1 : 0;
        $.ajax({
            url: "accesoVisitante",
            method: "GET",
            data: {
                id_visitante: id,
                valor: valor
            }
        });
    });
});