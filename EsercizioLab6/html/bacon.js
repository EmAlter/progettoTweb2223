$(document).ready(function () {
    $("#submitallmovies").on('click', allMovies); //submit tutti i film
    $("#submitactormovies").on('click', actedWith); //submit film con Kevin Bacon
});

function allMovies() {
    var firstname = $("#searchall").find('[name = "firstname"]').val(); //nome inserito
    var lastname = $("#searchall").find('[name = "lastname"]').val(); //cognome inserito
    var allmovies = true; //flag per getMovies.php che deve far partire il codice del fieldset "All movies"

    //se gli input sono vuoti o tutti e due da errore
    if (notEmpty(firstname, lastname)) {

        $.ajax({
            url: "getMovieList.php",
            type: "GET",
            contentType: "application/json",
            data: { "firstname": firstname, "lastname": lastname, "allmovies": allmovies },
            beforeSend: function () {
                $("#list").empty(); //ogni volta svuota la tabella
                $("#errMsg").empty(); //ogni volta svuota il messaggio di errore
            },
            success: function (result) {
                var jsonData = JSON.parse(result);
                $("#list").html('<tr><th>#</th><th>Name</th><th>Year</th></tr>'); //titolo tabella
                $("#firstN").html(firstname);
                $("#lastN").html(lastname);
                for (var i = 0; i < jsonData.length; i++) {
                    //mostra tutti i film e l'anno aggiungendo righe alla tabella
                    var row = $('<tr><td>' + i + '</td><td>' + jsonData[i].name + '</td><td>' + jsonData[i].year + '</td></tr>');
                    $('#list').append(row);
                }
            },
            error: function (error) {
                $("#errMsg").html("<p>Values not valid or Actor not found in the database.</p>");
            }
        });
    }
    else {
        $("#errMsg").html("<p>Firstname field or lastname field cannot be empty!</p>");
    }
};

function actedWith() {
    var firstname = $("#searchkevin").find('[name = "firstname"]').val();
    var lastname = $("#searchkevin").find('[name = "lastname"]').val();
    var movieswith = true; //flag per getMovies.php che deve far partire il codice del fieldset "Movies with Kevin Bacon"

    if (notEmpty(firstname, lastname)) {
        if (sameActor(firstname, lastname)) { //non si può cercare i film di Kevin Bacon con se stesso

            $.ajax({
                url: "getMovieList.php",
                type: "GET",
                contentType: "application/json",
                data: { "firstname": firstname, "lastname": lastname, "movieswith": movieswith },
                beforeSend: function () {
                    $("#list").empty(); //ogni volta svuota la tabella
                    $("#errMsg").empty(); //ogni volta svuota il messaggio di errore
                },
                success: function (result) {
                    var jsonData = JSON.parse(result);
                    $("#list").html('<tr><th>#</th><th>Name</th><th>Year</th></tr>'); //titolo tabella
                    $("#firstN").html(firstname);
                    $("#lastN").html(lastname);
                    for (var i = 0; i < jsonData.length; i++) {
                        //mostra tutti i film e l'anno aggiungendo righe alla tabella
                        var row = $('<tr><td>' + i + '</td><td>' + jsonData[i].name + '</td><td>' + jsonData[i].year + '</td></tr>');
                        $('#list').append(row);
                    }
                },
                error: function (error) {
                    $("#errMsg").html("<p>Values not valid or Actor not found in the database.</p>");
                }
            });
        }
        else {
            $("#errMsg").html("<p>You can't search Kevin Bacon movies with Kevin Bacon!");
        }
    }
    else {
        $("#errMsg").html("<p>Firstname field or lastname field cannot be empty!</p>");
    }
};

//funzione per verificare che gli input non siano vuoti
function notEmpty(firstname, lastname) {
    if (firstname == "" || lastname == "") {
        return false
    }
    else
        return true;

};

//funzione per verificare che non sia stato inserito Kevin Bacon nella ricerca di "Movies with Kevin Bacon"
function sameActor(firstname, lastname) {
    if (firstname == "Kevin" && lastname == "Bacon") {
        return false
    }
    else
        return true;
};

