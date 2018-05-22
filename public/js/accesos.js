$(document).ready(function () {
    $('#tabla').DataTable({
        "columns": [
            {"width": "10%"},
            {"width": "20%"},
            {"width": "20%"},
            {"width": "20%"},
            {"width": "20%"},
            {"width": "10%"},
        ],
        "order": [[ 0, "desc" ]]
    });

    $('#fechaI').datepicker({
        dateFormat: 'dd-mm-yy'
    });
    $('#fechaF').datepicker({
        dateFormat: 'dd-mm-yy'
    });
    var MyDate = new Date();
    var fecha;
    MyDate.setDate(MyDate.getDate());
    fecha = ('0' + MyDate.getDate()).slice(-2) + '-'
        + ('0' + (MyDate.getMonth() + 1)).slice(-2) + '-'
        + MyDate.getFullYear();
    $('#fechaI').val(fecha);
});