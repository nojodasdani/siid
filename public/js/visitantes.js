$(document).ready(function () {
    $('#tabla').DataTable({
        "columns": [
            {"width": "10%"},
            {"width": "20%"},
            {"width": "20%"},
            {"width": "15%"},
            {"width": "15%"},
            {"width": "10%"},
            {"width": "10%"},
        ]
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