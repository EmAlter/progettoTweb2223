/* 
Questo documento si occupa della gestione della pagina book.php
*/

$(document).ready(function () {
    
    /*Richiama la funzione che legge l'ID salvato nel file ../bookid.txt*/
    var path = "../bookinfo/bookid.txt"
    readFile(path);
    
    /*Richiama la funzione che aggiunge un libro al database dell'utente*/
    $(".add").on('click', addtoLibrary);
});

/*Invia una richiesta ajax che otterrà un ID che verrà passato alla funzione showInfoBook(id)*/
function readFile(path) {
    $.ajax({
        url: "/Progetto/readwrite/read.php", //script alla quale invio i dati
        type: "GET",
        contentType: "application/json",
        data: {"path": path},
        success: function(result) {
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
        success: function(data) {
            var jsonData = JSON.parse(data);

            if (!jsonData.main_character) {
                jsonData.main_character = "";
            }

                $("#poster").html('<img width="164" height="300" src="data:image/jpg;charset=utf8;base64,' +jsonData.poster + '"></img>');
                $("#number").html(jsonData.book_id);
                $("#title").html(jsonData.name);
                $("#year").html(jsonData.year);
                $("#author").html(jsonData.fullname);
                $("#main_c").html(jsonData.main_character);
                $(".synopsis p").html(jsonData.synopsis);
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
        success: function(data) {
            var json = JSON.parse(data);
            if(json.added) {
                $(".add").html(json.added);
            }
        }
    });


}