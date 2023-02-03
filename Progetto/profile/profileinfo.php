<?php
/*
Questo script viene utilizzato per mostrare tutti i libri salvati dal singolo utente, 
per aggiungere un libro "letto" dall'utente e per mostrare tutte le info dell'utente
*/


session_start();
include("../database/db.php");

try {
if(isset($_POST["data_books"])) {
    /*Parte di aggiunta del libro ai libri "letti"*/
    if(isset($_POST["title"]) && isset($_POST["today"]) && isset($_POST["id"])) {
        
        $title = $_POST["title"];
        $today = $_POST["today"];
        $id = $_POST["id"];
        $username = $_SESSION["username"];

        $title = $db->quote($title);
        $today = $db->quote($today);
        $id = $db->quote($id);
        
        $username = $db->quote($username);

        $exist = $db->query("SELECT id_book FROM books_saved WHERE id_book = $id");
        $exist = $exist->fetch(PDO::FETCH_ASSOC);

        /*Se il libro non si trova nel database allora lo aggiunge*/
        if(!$exist) {
        $db->query("INSERT INTO books_saved(user, id_book, title, date)
                    VALUES($username, $id, $title, $today);");
                    throw new Exception("Added");
        }
        else {
            throw new Exception("Already added");
        }


    }

    else {
        /*Parte che mostra tutti i libri "letti"*/
        $username = $_SESSION["username"];
        $username = $db->quote($username);
        $savedbooks = $db->query("SELECT title, id_book, date FROM books_saved WHERE user = $username;");
        $savedbooks = $savedbooks->fetchAll(PDO::FETCH_ASSOC);
        print json_encode($savedbooks);
    }

    
}

/*Parte che mostra tutte le informazioni dell'utente*/
if(isset($_POST["info"])) {
    $username = $_SESSION["username"];
    $username = $db->quote($username);
    
    $accountinfo = $db->query("SELECT info_nickname, firstname, lastname, birth, date_of_creation 
    FROM user_info
    INNER JOIN users ON users.nickname = user_info.info_nickname
    WHERE users.nickname = $username;");
    
    $accountinfo = $accountinfo->fetch(PDO::FETCH_ASSOC);
    print json_encode($accountinfo);
}
}

catch(Exception $error) {
    print json_encode(array (
        'added' => $error->getMessage()
    ));
}

?>