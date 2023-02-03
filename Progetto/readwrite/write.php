<?php
/*Viene usato per scrivere il valore del libro selezionato in ../bookinfo/bookid.txt*/


if(isset($_GET["id"]) && isset($_GET["path"])) {
    $id = $_GET["id"];
    $path = $_GET["path"];
}

if(filesize($path) != 0) {
    file_put_contents($path, "");
}

$file = fopen($path, "w");
fwrite($file, $id);
$fclose($file);
?>