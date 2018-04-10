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

    $('.accordian-body').on('show.bs.collapse', function () {
        $(this).closest("table")
            .find(".collapse.in")
            .not(this)
            .collapse('toggle')
    })
});