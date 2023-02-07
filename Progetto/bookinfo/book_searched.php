<?php
/*Questo script cerca nel database il libro che corrisponde all'ID selezionato e ne ottiene tutte le informazioni*/

session_start();
include("../database/db.php");
include("../functions/resolve_samesite_error.php");

try {if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $id = $db->quote($id);


$info = $db->query("SELECT *
FROM books
INNER JOIN author 
ON author.id = books.author_id
WHERE books.book_id = $id;");


$info = $info->fetch(PDO::FETCH_ASSOC);

$info["poster"] = base64_encode($info["poster"]);
//Siccome la colonna del poster è di tipo BLOB, quando ne ricevo il valore lo decodifico con la funzione base64_encode()

print json_encode($info);
}

if(isset($_POST["id_rating"])) {
    $id = $_POST["id_rating"];
    $id = $db->quote($id);

    $sum = $db->query("SELECT SUM(rating) FROM books_saved WHERE id_book = $id;");
    $sum = $sum->fetch(PDO::FETCH_ASSOC);

    $count = $db->query("SELECT COUNT(rating) FROM books_saved WHERE id_book = $id;");
    $count = $count->fetch(PDO::FETCH_ASSOC);

    print json_encode(array(
        'sum' => $sum["SUM(rating)"],
        'count' => $count["COUNT(rating)"]
    ));
}

if(isset($_POST["id_for_showing"])) {
    $id_fs = $_POST["id_for_showing"];
    $id_fs = $db->quote($id_fs);

    $username = $_SESSION["username"];
    $username = $db->quote($username);


    $exist = $db->query("SELECT rating FROM books_saved WHERE user = $username AND id_book = $id_fs;");

    $exist = $exist->fetch(PDO::FETCH_ASSOC);


    if($exist) {
            if($exist["rating"] == NULL) {
                $exist["rating"] = "nd";
            print json_encode($exist);
        }
        else {
            print json_encode($exist);
        }
    }
    else {
        print json_encode("false");
    }
}

/*
Script per aggiungere il rating del libro
*/
if(isset($_POST["r"]) && isset($_POST["id_my_rating"])) {
    $rating = $_POST["r"];
    $id = $_POST["id_my_rating"];
    $usr = $_SESSION["username"];

    if($rating === "to vote") {
        throw new Exception("Cannot use 'to vote' as value");
    }

    $rating = $db->quote($rating);
    $id = $db->quote($id);
    $usr = $db->quote($usr);

    $db->query("UPDATE books_saved
    SET rating = $rating
    WHERE user = $usr AND id_book = $id;");

    print json_encode(array(
        'rate' => "Rate added"
    ));

}
}
catch (Exception | PDOException $error) {
    print json_encode(array(
        'error' => $error->getMessage()
    ));
}
?>