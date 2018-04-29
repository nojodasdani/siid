$(document).ready(function () {
    $("#calle").change(function () {
        if ($(this).val() != "") {
            var id = $(this).val();
            $.ajax({
                url: "register/showNumbers",
                method: "GET",
                data: {
                    id_calle: id
                },
                success: function (data) {
                    $("#num").html(data);
                }
            });
        } else {
            $("#num").html("<option value=''>Selecciona...</option>");
        }
    });

    $("#visitas").change(function () {
        var valor = $(this).prop('checked');
        if (valor) {
            $(this).val(1);
        } else {
            $(this).val(0);
        }
    })
});