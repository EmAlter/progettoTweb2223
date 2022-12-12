<?php
try {
    /*
    Ho dovuto usare il database imdb_small perchè imdb mi dava errore di caricamento du phpMyAdmin
    */
    $db = new PDO("mysql:dbname=imdb_small;host=localhost:3306", "ema_dima", "kingartoria"); //connessione al database imdb_small

    if (isset($_GET["firstname"])  && isset($_GET["lastname"])) {
        $firstname = $_GET["firstname"]; //nome inserito
        $lastname = $_GET["lastname"]; //cognome inserito

        $firstname = $db->quote($firstname);
        $lastname = $db->quote($lastname);

        //submit del fieldset che mostra tutti i film di un attore/attrice
        if (isset($_GET["allmovies"])) {

            //id dell'attore/attrice in base al nome e al cognome
            $actorall = $db->query("SELECT id FROM actors WHERE first_name = $firstname AND last_name = $lastname;");

            $actorall = $actorall->fetchAll(PDO::FETCH_COLUMN);

            //se non è stato ritornato l'id significa che c'è stato un errore
            if (!$actorall) {
                throw new Exception("Exception found.");
            } else {

                //seleziona l'anno e il nome di tutti i film dove ha recitato l'attore/attrice scelto/a (id)
                $movieall = $db->query("SELECT name, year 
                        FROM movies 
                        INNER JOIN roles ON movies.id = roles.movie_id 
                        INNER JOIN actors ON actors.id = roles.actor_id 
                        WHERE actors.id = '$actorall[0]'
                        ORDER BY year ASC;");

                $movieall = $movieall->fetchAll(PDO::FETCH_ASSOC);

                //invia il risultato alla richiesta ajax in bacon.js (success)
                print json_encode($movieall);
            }
        }

        //submit del fieldset che mostra i film in cui ci sono sia l'attore/attrice scelto/a che Kevin Bacon
        if (isset($_GET["movieswith"])) {
            $kname = "Kevin";
            $klastname = "Bacon";

            $kname = $db->quote($kname);
            $klastname = $db->quote($klastname);

            //id sia di Kevin Bacon che dell'attore/attrice scelto/a
            $actorwith = $db->query(
                "SELECT id
                FROM actors 
                WHERE first_name = $firstname AND last_name = $lastname
                UNION
                SELECT id
                FROM actors 
                WHERE first_name = $kname AND last_name = $klastname;"
            );

            $actorwith = $actorwith->fetchAll(PDO::FETCH_COLUMN);

            //se l'attore/attrice inserito/a non è valido o non esiste l'array conterrà solo l'id di Kevin Bacon, perciò lancio l'eccezione
            if (!$actorwith[1]) {
                throw new Exception("Exception found.");
            }

            //seleziona il nome e l'anno dei film in cui ha recitato l'attore/attrice scelto/a insieme a Kevin Bacon
            $moviewith = $db->query(
                "SELECT name, year, COUNT(*)
                FROM movies
                INNER JOIN roles ON movies.id = roles.movie_id
                INNER JOIN actors ON actors.id = roles.actor_id
                WHERE actors.id = '$actorwith[0]' OR actors.id = '$actorwith[1]'
                GROUP BY name
                HAVING COUNT(*) > 1
                ORDER BY year ASC;"
            );

            $moviewith = $moviewith->fetchAll(PDO::FETCH_ASSOC);

            //invia il risultato alla richiesta ajax in bacon.js (success)
            print json_encode($moviewith);
        }
    }
} catch (Exception $err) {
    //gestisce le eccezioni lanciate e segnala l'errore ad ajax in bacon.js (error)
    die(header("HTTP/1.0 500"));
}
?>
