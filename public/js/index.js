$(document).ready(function () {
    setInterval(function () {
        $.ajax({
            url: "/siid/public/showNotifications",
            method: "GET",
            success: function (data) {
                if(data=="quitar"){
                    $("#numNot").hide();
                }else{
                    $("#numNot").show();
                    $("#numNot").html(data);
                }
            }
        });
    }, 1000)
});