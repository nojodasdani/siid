$(document).ready(function () {
    $('#tabla').DataTable({
        "columns": [
            {"width": "25%"},
            {"width": "20%"},
            {"width": "20%"},
            {"width": "10%"},
            {"width": "10%"},
            {"width": "15%"},
        ]
    });

    $(document).on('click', '.editar', function () {
        var renglon = $(this).parent().parent();
        var id = renglon.attr('id');
        $("#id_colono").val(id);
        $.ajax({
            url: "verColono",
            method: "GET",
            data: {
                id: id,
            },
            success: function (data) {
                var data = JSON.parse(data);
                $("#id_colono").val(data.id);
                $("#email").val(data.email);
                $("#calle").val(data.calle);
                $.ajax({
                    async: false,
                    url: "../register/showNumbers",
                    method: "GET",
                    data: {
                        id_calle: $("#calle").val()
                    },
                    success: function (data) {
                        $("#num").html(data);
                    }
                });
                $("#num").val(data.id_numero);
            }
        });
    });

    $("#calle").change(function () {
        $.ajax({
            url: "../register/showNumbers",
            method: "GET",
            data: {
                id_calle: $("#calle").val()
            },
            success: function (data) {
                $("#num").html(data);
            }
        });
    });

    $(document).on('click', '.eliminar', function () {
        var renglon = $(this).parent().parent();
        var id = renglon.attr('id');
        iziToast.question({
            timeout: 20000,
            close: false,
            overlay: true,
            toastOnce: true,
            id: 'question',
            zindex: 999,
            title: '¿Estás seguro?',
            message: 'El usuario será eliminado del sistema',
            position: 'center',
            buttons: [
                ['<button><b>Eliminar</b></button>', function (instance, toast) {
                    $.ajax({
                        url: "eliminarColono",
                        method: "GET",
                        data: {
                            id_colono: id,
                        },
                        success: function () {
                            location.reload();
                        }
                    });
                }, true],
                ['<button>Cancelar</button>', function (instance, toast) {
                    instance.hide({transitionOut: 'fadeOut'}, toast, 'button');
                }],
            ]
        });
    });

    $(document).on('change', '.sistema', function () {
        var valor = $(this).prop('checked');
        var id = $(this).parent().parent().attr('id');
        valor = (valor) ? 1 : 0;
        $.ajax({
            url: "accesoSistema",
            method: "GET",
            data: {
                id_colono: id,
                valor: valor
            }
        });
    });

    $(document).on('change', '.fracc', function () {
        var valor = $(this).prop('checked');
        var id = $(this).parent().parent().attr('id');
        valor = (valor) ? 1 : 0;
        $.ajax({
            url: "accesoFracc",
            method: "GET",
            data: {
                id_colono: id,
                valor: valor
            }
        });
    });
});