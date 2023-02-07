/* 
Questo documento si occupa della gestione della pagina book.php
*/

$(document).ready(function () {

    /*Richiama la funzione che legge l'ID salvato nel file ../bookid.txt*/
    var path = "../bookinfo/bookid.txt"
    readFile(path);

    /*Richiama la funzione che aggiunge un libro al database dell'utente*/
    $(".add").on('click', addtoLibrary);

    $("#ratg").hide();

    $(document).on('change', "#ratg", addYourVote);

});

/*Invia una richiesta ajax che otterrà un ID che verrà passato alla funzione showInfoBook(id)*/
function readFile(path) {
    $.ajax({
        url: "/Progetto/readwrite/read.php", //script alla quale invio i dati
        type: "GET",
        contentType: "application/json",
        data: { "path": path },
        success: function (result) {
            var id = JSON.parse(result);
            showInfoBook(id);

        }
    });
}

/*In base all'ID passato mostra tutte le informazioni del libro*/
function showInfoBook(id) {
    $.ajax({
        url: "../bookinfo/book_searched.php",
        type: "GET",
        contentType: "application/json", //script alla quale invio i dati
        data: { "id": id },
        success: function (data) {
            var jsonData = JSON.parse(data);

            if (!jsonData.main_character) {
                jsonData.main_character = "";
            }

            $("#poster").html('<img width="164" height="300" src="data:image/jpg;charset=utf8;base64,' + jsonData.poster + '"></img>');
            $("#number").html(jsonData.book_id);
            $("#title").html(jsonData.name);
            $("#year").html(jsonData.year);
            $("#author").html(jsonData.fullname);
            $("#main_c").html(jsonData.main_character);
            $(".synopsis p").html(jsonData.synopsis);
            sumAllRatings();
            bookInList();
        }
    });
};

/*Invia una richiesta ajax che permette l'aggiunta di un libro al database dell'utente*/
function addtoLibrary() {
    var title = $("#title").text();
    var id = $("#number").text();
    var today = new Date();

    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;

    $.ajax({
        url: "../profile/profileinfo.php", //script alla quale invio i dati
        type: "POST",
        data: { "title": title, "today": today, "id": id, "data_books": 1 },
        success: function (data) {
            var json = JSON.parse(data);
            if (json.added) {
                $(".add").html(json.added);
                $("#ratg").show();

            }
        }
    });


};
/*Somma tutti i voti del libro passato e e ne mostra la percentuale di apprezzamento*/
function sumAllRatings() {
    var id = $("#number").text();

    $.ajax({
        url: "../bookinfo/book_searched.php", //script alla quale invio i dati
        type: "POST",
        data: { "id_rating": id },
        success: function (data) {
            var json_rating = JSON.parse(data);
            var count = json_rating.count;
            var sum = Math.ceil((json_rating.sum * 100) / (count * 10));
            $("#rating").html(addIconToRating(sum));
        }
    });
};
/*In base alla percentuale di apprezzamento viene aggiunta un'icona affianco del voto*/
function addIconToRating(value) {
    if (value <= 25) {
        return value += "%" + '<img id="icon" src="/Progetto/img/rating/really_bad.png">';
    }
    else if (value > 25 && value <= 50) {
        return value += "%" + '<img id="icon" src="/Progetto/img/rating/bad.png">';
    }
    else if (value > 50 && value <= 75) {
        return value += "%" + '<img id="icon" src="/Progetto/img/rating/good.png">';
    }
    else if (value > 75) {
        return value += "%" + '<img id="icon" src="/Progetto/img/rating/really_good.png">';
    }
    else
        return "Not voted yet";
};
/*Permette l'aggiunta del proprio voto personale*/
function addYourVote() {
    var r = $('#ratg :selected').text();
    var id = $("#number").text();

    $.ajax({
        url: "/Progetto/bookinfo/book_searched.php", //script alla quale invio i dati
        type: "POST",
        data: { "r": r, "id_my_rating": id },
        beforeSend: function () {
            $("#voted").empty();
        },
        success: function (data) {
            var j_rated = JSON.parse(data);
            if (j_rated.rate) {
                $("#voted").html(j_rated.rate);
                var seconds = 2;
                setInterval(function () {
                    seconds--;
                    if (seconds == 0) {
                        $("#voted").empty();
                    }
                }, 1000);
            }

            else {
                $("#voted").html(j_rated.error);
            }
        }

    });
};
/*Verifica che il libro sia stato aggiunto dall'utente, in caso affermantivo mostra il menù dropdown*/
function bookInList() {
    var id = $("#number").text();

    $.ajax({
        url: "/Progetto/bookinfo/book_searched.php", //script alla quale invio i dati
        type: "POST",
        data: { "id_for_showing": id },
        success: function (data) {
            var j_rated = JSON.parse(data);
            if (j_rated.rating) {
                $("#ratg").show();
                $("#ratg").val(j_rated.rating);
            }
        }

    });
}