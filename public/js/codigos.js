$(document).ready(function () {
    /*$('#tabla').DataTable({
        "columns": [
            {"width": "20%"},
            {"width": "20%"},
            {"width": "20%"},
            {"width": "20%"},
            {"width": "20%"}
        ]
    });*/

    $(document).on('show.bs.collapse', '.accordian-body', function () {
        $(this).closest("table")
            .find(".collapse.in")
            .not(this)
            .collapse('toggle')
    })

    $(document).on('click', ".eliminar", function () {
        var id = $(this).parent().parent().attr('id');
        iziToast.question({
            timeout: 20000,
            close: false,
            overlay: true,
            toastOnce: true,
            id: 'question',
            zindex: 999,
            title: '¿Estás seguro?',
            message: 'El código quedará inutilizable',
            position: 'center',
            buttons: [
                ['<button><b>Eliminar</b></button>', function (instance, toast) {
                    $.ajax({
                        url: "eliminar",
                        method: "GET",
                        data: {
                            id: id,
                        },
                        success: function (data) {
                            location.reload();
                        }
                    });
                    //instance.hide({transitionOut: 'fadeOut'}, toast, 'button');
                }, true],
                ['<button>Cancelar</button>', function (instance, toast) {
                    instance.hide({transitionOut: 'fadeOut'}, toast, 'button');
                }],
            ]
        });
    });
});