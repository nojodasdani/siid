$(document).ready(function(){
    $('#tabla').DataTable({
        "columns": [
            {"width": "20%"},
            {"width": "20%"},
            {"width": "20%"},
            {"width": "20%"},
            {"width": "20%"},
        ]
    });

    $(".aceptar").click(function(){
        var renglon = $(this).parent().parent();
        var id = renglon.attr('id');

        //renglon.remove();
    });

    $(".rechazar").click(function(){
        //console.log("rechazar")
    });
});