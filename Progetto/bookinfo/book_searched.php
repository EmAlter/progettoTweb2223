<?php
/*Questo script cerca nel database il libro che corrisponde all'ID selezionato e ne ottiene tutte le informazioni*/


include("../database/db.php");

if (isset($_GET["id"])) {
    $id = $_GET["id"];
    $id = $db->quote($id);
}

$info = $db->query("SELECT *
FROM books
INNER JOIN author 
ON author.id = books.author_id
WHERE books.book_id = $id;");

$info = $info->fetch(PDO::FETCH_ASSOC);

$info["poster"] = base64_encode($info["poster"]);
//Siccome la colonna del poster è di tipo BLOB, quando ne ricevo il valore lo decodifico con la funzione base64_encode()

print json_encode($info);

?>