<?php include "top.html"; ?>

<!-- 
    Pagina che riceve i dati dell'utente che si è appena iscritto e li salva nel file singles.txt
-->

<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){ //verifica che il metodo d'invio utilizzato sia POST
$name = $_POST["name"]; //salva il nome dell'utente iscritto nella variabile $name

if ($_POST["gender"] == "male") { //riceve il genere dell'utente iscritto e se è maschio o femmina
    $gender = "M";                //salva M o F rispettivamente nella variabile $gender
} else {
    $gender = "F";
}

$age = $_POST["age"]; //salva l'età dell'utente iscritto nella variabile $age
$ptype = $_POST["ptype"]; //salva il tipo di personalità dell'utente iscritto nella variabile $ptype
$favOS = $_POST["favOS"]; //salva l'OS prefeito dell'utente iscritto nella variabile $favOS
$ageMin = $_POST["ageMin"]; //salva l'età minima desiderata dall'utente iscritto nella variabile $ageMin
$ageMax = $_POST["ageMax"]; //salva l'età massima desiderata dall'utente iscritto nella variabile $ageMax
}

file_put_contents("singles.txt", "$name,$gender,$age,$ptype,$favOS,$ageMin,$ageMax\n", FILE_APPEND) //carica tutti i dati ottenuti nel file singles.txt
?>

<p>Thank you!</p>
<p>Welcome to Nerdluv,
    <?= $name ?>
</p>
<p>Now <a href="matches.php">log in to see your matches!</a></p>

<?php include "bottom.html"; ?>