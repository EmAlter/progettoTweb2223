<?php include "top.html"; ?>

<!-- 
    Pagina che riceve il nome dell'utente loggato e
    cerca tutti i possibili matches
-->

<?php
if($_SERVER["REQUEST_METHOD"] == "GET") { //verifica che il nome sia inviato con metodo GET
$name = $_GET["name"]; //salva il nome dell'utende loggato in $name
}
$matches = array(); //crea un array vuoto in cui saranno salvati tutti i matches
$allUsers = array();
$loggedUser = array();

$allUsers = file("singles.txt", FILE_IGNORE_NEW_LINES); //salva ogni linea del file singles.txt a ogni indice dell'array $allUsers

foreach ($allUsers as $key => $line) { //associa a ogni indice dell'array $allUsers un sottoarray che contiene tutti gli attributi di ogni utente
    $allUsers[$key] = explode(",", $line); //explode serve a dividere ogni attributo
}

for ($i = 0; $i < count(file("singles.txt")); $i++) { //serve a cercare l'utente che si è loggato trovando il nome uguale a $name
    if ($allUsers[$i][0] == $name) {                  //(si parte dal presupposto che non possano esistere due utenti con lo stesso nome)
        $loggedUser = $allUsers[$i];                  //trovato l'utente, questo viene salvato con tutti i suoi attributi nell'array $loggedUser
    }
}

for ($i = 0; $i < count(file("singles.txt")); $i++) { //serve a trovare tutti i matches dell'utente loggato controllando gli utenti uno per uno
    if ($allUsers[$i][1] != $loggedUser[1]) {         //verifica che il sesso sia opposto (questo if di può eliminare se si vuole rendere il "politicamente corretto")
        if ($allUsers[$i][4] == $loggedUser[4]) {     //verifica che l'OS preferito sia lo stesso
            if ($loggedUser[6] >= $allUsers[$i][2] && $loggedUser[5] <= $allUsers[$i][2]) { //verifica che l'età sia compresa tra l'età minima e massima desiderata
                if (comparePersonality($loggedUser[3], $allUsers[$i][3])) { //invoca la funzione comparePersonality($p1, $p2) per verificare le lettere in comune tra le personalità
                    array_push($matches, $allUsers[$i]); //soddisfatti tutti gli if, l'utente trovato viene aggiunto all'array $matches
                }
            }
        }
    }
}

function comparePersonality($p1, $p2) //verifica che ci sia almeno una lettera in comune e nella stessa posizione tra le stringhe $p1 e $p2
{                                     //si parte dal presupposto che le stringhe non sono più lunghe di 4 caratteri
   $array1 = array();
   $array2 = array();

   $array1 = str_split($p1);
   $array2 = str_split($p2);

   for ($i=0; $i<count($array1) ; $i++) { 
    if($array1[0] == $array2[0]) {
        return true;
    }
    else if($array1[1] == $array2[1]) {
        return true;
    }
    else if($array1[2] == $array2[2]) {
        return true;
    }
    else if($array1[3] == $array2[3]) {
        return true;
    }
    else {
        return false;
    }
   }
}
?>

<h1>Matches for <?= $loggedUser[0] ?> </h1> <!-- $loggedUser[0] stampa il nome dell'utente loggato -->

<?php
foreach ($matches as $match) { //ciclo foreach per mostrare ogni match all'interno di $matches
?>

    <div class="match">

        <img src="https://courses.cs.washington.edu/courses/cse190m/12sp/homework/4/user.jpg">

        <div>
            <p><?= $match[0] ?></p> <!-- $match[0] contiene il nome del match -->
        </div>
        
        <ul>
            <li><strong>gender:</strong> <?= $match[1] ?> </li> <!-- $match[1] contiene il genere del match -->
            <li><strong>age:</strong> <?= $match[2] ?> </li> <!-- $match[2] contiene l'età del match -->
            <li><strong>type:</strong> <?= $match[3] ?> </li> <!-- $match[3] contiene il tipo di personalità del match -->
            <li><strong>OS:</strong> <?= $match[4] ?></li> <!-- $match[4] contiene l'OS preferito del match -->
        </ul>

    </div>

<?php
}
?>




<?php include "bottom.html"; ?>