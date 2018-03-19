$(document).ready(function () {
    $('#tabla').DataTable({
        "columns": [
            {"width": "20%"},
            {"width": "20%"},
            {"width": "20%"},
            {"width": "20%"},
            {"width": "20%"},
        ]
    });

    $(".aceptar").click(function () {
        var renglon = $(this).parent().parent();
        var id = renglon.attr('id');
        $.ajax({
            url: "aceptarSolicitud",
            method: "GET",
            data: {
                id: id
            },
            success: function () {
                location.reload();
            }
        });
    });

    $(".rechazar").click(function () {
        var renglon = $(this).parent().parent();
        var id = renglon.attr('id');
        $.ajax({
            url: "rechazarSolicitud",
            method: "GET",
            data: {
                id: id
            },
            success: function () {
                location.reload();
            }
        });
    });
});