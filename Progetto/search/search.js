$(document).ready(function () {

    /*Richiama la funzione che permette di cercare i libri*/
    $(".search").on('click', searchBooks);
});

/*Invia tramite richiesta ajax la stringa di ricerca in base al risultato mostra tutti i libri trovati*/
function searchBooks() {
    var book = $("#searchbar").find('[name = "book"]').val();
    $.ajax({
        url: "/Progetto/search/searchpage.php", //script alla quale invio i dati
        type: "GET",
        data: { "book": book },
        beforeSend: function () {
            $(".results").empty();
        },
        success: function (result) {
            var jsonData = JSON.parse(result);

            for (var i = 0; i < jsonData.length; i++) {

                var author_icon = jsonData[i].fullname;
                var main_character = jsonData[i].main_character;

                //Il protagonista può anche non esserci
                if (!main_character) {
                    main_character = "";
                }

                //Richiama la funzione checkMain()
                author_icon = checkMain(author_icon, main_character);

                $(".results").append('<div id="items">'
                    + '<div class="img"><img id="poster" onclick="saveId(' + jsonData[i].book_id + ')" width="110" height="170"'
                    + 'alt="' + jsonData[i].name + '" src="data:image/jpg;charset=utf8;base64,' + jsonData[i].poster + '"></div>'
                    + '<div class="about"><h1 class="title">' + jsonData[i].name + '</h1>'
                    + '<h3 class="subtitle">' + jsonData[i].year + '</h3>'
                    + '<h3 class="subtitle">' + author_icon + '</h3></div>'
                    + '</div>');
            }

        }
    });

};

/*Aggiunge un'icona affianco ad alcuni protagonisti che appaiono in più libri
NB: non è stata implementata un'aggiunta per futuri possibili protagonisti*/ 
function checkMain(author_icon, main_character) {
    if (main_character.localeCompare("Hercule Poirot") == 0) {
        return author_icon += '<img id="icon" src="/Progetto/img/main-characters/moustache-poirot.png">';
    }
    else if (main_character.localeCompare("Miss Marple") == 0) {
        return author_icon += '<img id="icon" src="/Progetto/img/main-characters/tea-marple.png">';
    }
    else if (main_character.localeCompare("Tommy and Tuppence") == 0) {
        return author_icon += '<img id="icon" src="/Progetto/img/main-characters/tommy-tuppence.png">';
    }
    else if (main_character.localeCompare("Sherlock Holmes") == 0) {
        return author_icon += '<img id="icon" src="/Progetto/img/main-characters/pipe-holmes.png">';
    }
    else if (main_character.localeCompare("Inspector Montalbano") == 0) {
        return author_icon += '<img id="icon" src="/Progetto/img/main-characters/m-montalbano.png">';
    }
    else
        return author_icon;
};

/*In base al libro cliccato, salva il suo ID nel file ../bookinfo/bookid.txt e successivamente carica la sua pagina*/
function saveId(data) {
    var path = "../bookinfo/bookid.txt";
    $.ajax({
        url: "/Progetto/readwrite/write.php", //script alla quale invio i dati
        type: "GET",
        contentType: "application/json",
        data: { "id": data, "path": path },
        success: function (result) {
            window.location = "/Progetto/bookinfo/book.php";
        }
    });
}

