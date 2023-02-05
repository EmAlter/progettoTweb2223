<?php
/*Questo script permette la ricerca di un libro nel database*/


session_start();
include("../database/db.php");

/* Il libro viene cercato in base al titolo */
if (isset($_GET["book"])) {
    $book = $_GET["book"]."%";
    $book = $db->quote($book);

    $result = $db->query("SELECT *
    FROM books
    INNER JOIN author ON author.id = books.author_id
    WHERE name LIKE $book");

    $result = $result->fetchAll(PDO::FETCH_ASSOC);
    foreach($result as $key => $value) {
        $result[$key]["poster"] = base64_encode($value["poster"]);
        /*Siccome nel database la colonna che contiene il poster di ogni libro è di tipo BLOB, 
        per decodificarla uso la funzione base64_encode() */

    }
    print json_encode($result);

}
?>