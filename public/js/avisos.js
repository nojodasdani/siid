$(document).ready(function () {
    $('#tabla').DataTable({
        "columns": [
            {"width": "60%"},
            {"width": "20%"},
            {"width": "20%"},
        ]
    });

    $(".cambiar").click(function () {
        var renglon = $(this).parent().parent();
        var id = renglon.attr('id');
        var valor = ($(this).prop('checked')) ? 1 : 0;
        $.ajax({
            url: "visible",
            method: "GET",
            data: {
                id: id,
                valor: valor
            }
        });
    });

    $(".eliminar").click(function () {
        var renglon = $(this).parent().parent();
        var id = renglon.attr('id');
        $.ajax({
            url: "eliminar",
            method: "GET",
            data: {
                id: id,
            },
            success: function () {
                location.reload();
            }
        });
    });
});