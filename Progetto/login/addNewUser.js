import { special_characters, emptyDataWhiteSpaceNotAllowed } from "../functions/functions.js";

$(document).ready(function () {
    $("#submit_usandpassw").on('click', readInfo);
});

function readInfo() {
    var firstname = $("#firstname").val();
    var lastname = $("#lastname").val();
    var birth = $("#birth").val();
    var username = $("#username").val();
    var password = $("#password").val();
    var confirmpassword = $("#confirmpassword").val();
    var radio = $('input[name="admin"]:checked').val();

    if (checkDataInput(firstname, lastname, username, password, confirmpassword, birth)) {
        if (password === confirmpassword) {
            $.ajax({
                url: "login-signup-script.php",
                type: "POST",
                data: {
                    "firstname": firstname, "lastname": lastname, "birth": birth,
                    "username": username, "password": password, "radio": radio
                },
                beforeSend: function () {
                    $(".err").empty();
                },
                success: function (result) {
                    var json = JSON.parse(result);
                    if (json.error) {
                        $(".err").text(json.error);
                    }
                    else {
                        window.location = "/Progetto/search/searchpage.php";
                    }

                }
            });

        }

    }
    else {
        $(".err").html("You inserted characters not valid!");
    }

};

/*Funzione usata per semplificare il check dei caratteri non validi:
    - si controlla che firstname, lastname, password e username non contengano caratteri speciali e non siano vuote
    - si controlla che confirmpassword e birth non siano vuote
*/
function checkDataInput(f, l, p, u, cp, b) {
    return !special_characters(f) && !special_characters(l) && !special_characters(p) && !special_characters(u) &&
        !emptyDataWhiteSpaceNotAllowed(f) && !emptyDataWhiteSpaceNotAllowed(l) && !emptyDataWhiteSpaceNotAllowed(p)
        && !emptyDataWhiteSpaceNotAllowed(u) && !emptyDataWhiteSpaceNotAllowed(cp) && !emptyDataWhiteSpaceNotAllowed(b);

};
