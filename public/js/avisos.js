$(document).ready(function () {
    $('#tabla').DataTable({
        "columns": [
            {"width": "60%"},
            {"width": "20%"},
            {"width": "20%"},
        ]
    });

    $(document).on('change', ".cambiar", function () {
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

    $(document).on('click', ".eliminar", function () {
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

    $(document).on('change keyup paste', ".nombre", function () {
        var valor = $(this).val();
        var renglon = $(this).parent().parent();
        var id = renglon.attr('id');
        $.ajax({
            url: "editar",
            method: "GET",
            data: {
                id: id,
                valor: valor
            }
        });
    });
});