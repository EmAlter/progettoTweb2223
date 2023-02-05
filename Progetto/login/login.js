import { special_characters, emptyDataWhiteSpaceNotAllowed } from "../functions/functions.js";

$(document).ready(function () {
    $("#submit_usandpassw").on('click', readInfo);
});

function readInfo() {
    var user = $("#username").val();
    var pssw = $("#password").val();

    if ((!special_characters(user) && !special_characters(pssw))
        && (!emptyDataWhiteSpaceNotAllowed(user) && !emptyDataWhiteSpaceNotAllowed(pssw))) {
        $.ajax({
            url: "login-signup-script.php",
            type: "POST",
            data: { "user": user, "pssw": pssw },
            beforeSend: function () {
                $(".err").empty();
            },
            success: function (result) {
                var jsonData = JSON.parse(result);
                if (jsonData.error) {
                    $(".err").html(jsonData.error);
                }
                else {
                    window.location = "/Progetto/search/search.php";
                }
            }
        });
    }
    else {
        $(".err").html("You have inserted characters not valid!");
    }
};