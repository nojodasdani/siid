$(document).ready(function () {
    if (flag) {
        var url = (location.href.includes('home') || location.href.includes('micuenta') || location.href.includes('changepassword')) ? "showNotifications" : "../showNotifications";
        setInterval(function () {
            $.ajax({
                url: url,
                method: "GET",
                success: function (data) {
                    if (data == "quitar") {
                        $("#numNot").hide();
                    } else {
                        $("#numNot").html(data);
                        $("#numNot").show();
                    }
                }
            });
        }, 1000)
    }
});