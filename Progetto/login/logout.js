$(document).ready(function () {
    //La funzione riporta alla home dopo 5 secondi aggiornando il valore di span
        var seconds = 5;
        $("#seconds").html(seconds);
        setInterval(function () {
            seconds--;
            $("#seconds").html(seconds);
            if (seconds == 0) {
                window.location = "../index.php";
            }
        }, 1000);
});