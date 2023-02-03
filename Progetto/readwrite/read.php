<?php
/*Viene usato per leggere il valore contenuto in ../bookinfo/bookid.txt*/


if(isset($_GET["path"])) {
    $path = $_GET["path"];
}

$file = fopen($path, "r");

$data = file_get_contents("$path");
print json_encode($data);

fclose($file);
?>