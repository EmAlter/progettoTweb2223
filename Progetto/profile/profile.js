import { special_characters, emptyData, onlyDigits } from "../functions/functions.js";

/*
Questo documento si occupa della gestione della pagina profile.php
*/

$(document).ready(function () {

    /*
    Richiamo la funzione per ottenere la tabella dei libri aggiunti.
    */
    allBookAdded();

    /*
    Richiamo la funzione per ottenere le informazioni dell'account.
    */
    obtainAccountInfo();

    /*
    Richiamo la funzione per creare la tabella degli ID degli autori.
    */
    uploadAuthorTable();

    /*
    Richiamo la funzione che serve per aggiungere nuovi libri al database.
    */
    $("#admin_book").on('click', addNewBook);

    /*
    Richiamo la funzione che serve per aggiungere nuovi autori nel database.
    */
    $("#admin_author").on('click', addNewAuthor);

    /*
    Richiamo la funzione che serve a eliminare un libro letto dal database.
    I bottoni sono aggiunti dinamicamente
   */
    $(document).on('click', "#delete_from_list", deleteFromList);

    /*
    Permette l'eliminazione di un elemento dalla tabella dei libri rilasciandolo nell'apposito box.
    Richiama la funzione deleteFromList che si occupa di eliminare il libro dal database.
    */
    $(".remove_row").droppable({
        drop: function (event, ui) {
            var id = $(ui.draggable).attr('id');
            var seconds = 2;
            deleteFromList(id);
            $(ui.draggable).remove();
            $("#removed").html("Removed");
            setInterval(function () {
                seconds--;
                if (seconds == 0) {
                    $("#removed").empty();
                }
            }, 1000);
        }


    });

});
/*
Ajax richiamato per creare la tabella dei libri aggiunti
*/
function allBookAdded() {
    $.ajax({
        url: "/Progetto/profile/profileinfo.php", //script alla quale invio i dati
        type: "POST",
        data: { "data_books": 1 },
        success: function (result) {
            var data = JSON.parse(result);
            if (!jsonEmpty(data)) {
                var title = $('<tr> <th>N°</th>  <th>Title</th>  <th>Added in date</th> </tr>');
                $('.saved_books').append(title);
                for (let i = 0; i < data.length; i++) {
                    var row = $('<tr id="' + data[i].id_book + '"><td>' + data[i].id_book + '</td>'
                        + '<td>' + data[i].title + '</td>'
                        + '<td>' + data[i].date + '</td></tr>');
                    /*Rende ogni oggetto (riga) della tabella grabbabile*/
                    row.draggable(
                        { cursor: 'grab' }, //Modifica il tipo di cursore quando l'oggetto è grabbato
                        { revert: true }
                    );
                    $('.saved_books').append(row);
                }
            }

            else {
                var empty = $('<tr><td>You did not added books yet</td></tr>');
                $(".saved_books").append(empty);
            }

        }

    });
};
/*
Ajax richiamato per ottenere le informazioni dell'account loggato
*/
function obtainAccountInfo() {
    $.ajax({
        url: "/Progetto/profile/profileinfo.php", //script alla quale invio i dati
        type: "POST",
        data: { "info": 1 },
        success: function (data) {
            var Jsondata = JSON.parse(data);
            $("#name").html(Jsondata.firstname);
            $("#lastname").html(Jsondata.lastname);
            $("#birth").html(Jsondata.birth);
            $("#dateofcreation").html(Jsondata.date_of_creation);
        }

    });
};

/*
Ajax richiamato per creare la tabella degli ID degli autori
*/
function uploadAuthorTable() {
    $.ajax({
        url: "/Progetto/profile/add-book.php",
        type: "POST",
        data: { "author_table": 1 }, //script alla quale invio i dati
        success: function (result) {
            var data = JSON.parse(result);

            var title = $('<tr> <th>ID</th>  <th>Name</th> </tr>');
            $(".saved_id_authors").append(title);
            for (let i = 0; i < data.length; i++) {
                var row = $('<tr><td>' + data[i].id + '</td>'
                    + '<td>' + data[i].fullname + '</td></tr>');
                $(".saved_id_authors").append(row);
            }
        }

    });
};

/*
Ajax richiamato per aggiungere un nuovo autore nel database
*/
function addNewAuthor() {

    var fullname = $("#fullname").val();
    var birth_author = $("#birth_author").val();



    if (!special_characters(fullname) && onlyDigits(birth_author)
        && !emptyData(fullname) && !emptyData(birth_author)) {

        if ($("#before_Christ_author").is(":checked")) {
            birth_author = birth_author + " B.C.";
        }

        $.ajax({
            url: "/Progetto/profile/add-book.php",
            type: "POST",
            data: { "fullname": fullname, "birth_author": birth_author },
            beforeSend: function () {
                $(".result_author").empty();
            },
            success: function (data) {
                var json_author = JSON.parse(data);
                if (json_author.error) {
                    $(".result_author").html(json_author.error);
                }
                else {
                    $(".result_author").html(json_author.success);
                    uploadAuthorTable();
                }

            }

        });

    }
    else {
        $(".result_author").html("You inserted characters not valid or an empty value!");
    }
};

/*
Ajax richiamato per aggiungere un nuovo libro nel database
*/
function addNewBook() {

    //A causa dell'utilizzo di FormData, questo codice non funziona con IE < 10
    var fd = new FormData();

    var book_name = $("#book_name").val();
    var author_id = $("#author_id").val();
    var main_character = $("#main_character").val();
    var year = $("#year").val();
    var synopsis = $("#synopsis").val();

    var poster = $('#poster').prop('files')[0];

    //Verifica che i label non siano vuoti
    if (!emptyData(book_name) && !emptyData(author_id)
        && !emptyData(year) && !emptyData(synopsis)
        && !emptyData(poster)) {

        //Verifica che i label di author_id e year siano composti solo da numeri
        if (onlyDigits(year) && onlyDigits(author_id)) {

            if ($("#before_Christ_book").is(":checked")) {
                year = year + " B.C.";
            }

            fd.append('book_name', book_name);
            fd.append('author_id', author_id);
            fd.append('main_character', main_character);
            fd.append('year', year);
            fd.append('poster', poster);
            fd.append('synopsis', synopsis);

            $.ajax({
                url: "/Progetto/profile/add-book.php", //script alla quale invio i dati
                type: "POST",
                processData: false,
                contentType: false,
                data: fd,
                beforeSend: function () {
                    $(".result_book").empty();
                },
                success: function (data) {
                    var jsonData = JSON.parse(data);
                    if (jsonData.error) {
                        $(".result_book").html(jsonData.error);
                    }
                    else {
                        $(".result_book").html(jsonData.success);
                    }

                }

            });
        } else {
            $(".result_book").html("Author ID and Year can only be digit value");
        }

    }
    else {
        $(".result_book").html("Some fields cannot be empty!");
    }

};
/*
Permette la cancellazione del libro letto selezionato tramite richiesta ajax
*/
function deleteFromList(id) {
    $.ajax({
        url: "/Progetto/profile/add-book.php", //script alla quale invio i dati
        type: "POST",
        data: { "n_book": id },
        beforeSend: function () {
            $("#removed").empty();
        }
    });
};

/*
La funzione verifica se i dati ottenuti dallo script sono vuoti, in caso affermativo ritorna true
*/
function jsonEmpty(json) {
    return json === "[]";
};

