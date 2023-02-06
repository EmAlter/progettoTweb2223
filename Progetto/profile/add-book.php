<?php
session_start();
include("../database/db.php");

/*
Funzione che compara due stringhe se sono uguali
*/
function compareAuthors($x, $y)
{
    return strcasecmp($x, $y) == 0;
}

function isEmpty($string) {
    return $string == "";
}

try {
    /*
    Script per creare la <table> degli ID degli autori
    */
    if(isset($_POST["author_table"])) {
        
        $authorinfo = $db->query("SELECT id, fullname
        FROM author;");
        
        $authorinfo = $authorinfo->fetchAll(PDO::FETCH_ASSOC);
        print json_encode($authorinfo);
    }
        
    $exist = false;
    $find_author = "";
    $last_autor = "";

    $all_database_authors = $db->query("SELECT * FROM author;");
    $all_database_authors = $all_database_authors->fetchAll(PDO::FETCH_ASSOC);
    
    /*
    Script per aggiungere un nuovo autore nel database
    */
    if (isset($_POST["fullname"]) && isset($_POST["birth_author"])) {
        $fullname = $_POST["fullname"];
        $birth = $_POST["birth_author"];

        
        foreach ($all_database_authors as $key => $author) {
            if (compareAuthors($all_database_authors[$key]["fullname"], $fullname) 
            && compareAuthors($all_database_authors[$key]["birth"], $birth)) {
                $exist = true;
                $find_author = $all_database_authors[$key]["id"];
                break; //Se trova l'autore nel database interrompe il ciclo
            }
            else {
                $last_autor = $all_database_authors[$key]["id"];
            }
        }

        if($exist) {
            throw new Exception("Author already exists in the database with id: " . $find_author);
        } else {
            $fullname = $db->quote($fullname);
            $birth = $db->quote($birth);

            $db->query("INSERT INTO author(fullname, birth)
                    VALUES($fullname, $birth);");

            $id = $db->query("SELECT id FROM author WHERE fullname = $fullname AND birth = $birth;");
            $id = $id->fetch(PDO::FETCH_ASSOC);


            print json_encode(array(
                    'success' => "Author added to the database with id: " . ((int)$last_autor + 1),
                    'id' => $id["id"]
            ));
            
        }
    }

    /*
    Script per aggiungere un nuovo libro nel database
    */
    if (isset($_POST["book_name"]) && isset($_POST["year"]) && isset($_POST["author_id"])
        && isset($_POST["main_character"]) && isset($_POST["synopsis"]) && isset($_FILES["poster"])) {
        
        $title = $_POST["book_name"];
        $author_id = $_POST["author_id"];
        $year = $_POST["year"];
        $main_character = $_POST["main_character"];
        $synopsis = $_POST["synopsis"];
        $poster = $_FILES["poster"];

        $img_url = file_get_contents($poster["tmp_name"]);
        //Serve per ottenere le dimensioni dell'immagine caricata
        $image_info = getimagesize($poster["tmp_name"]);

        foreach ($all_database_authors as $key => $atr) {
            if (compareAuthors($all_database_authors[$key]["id"], $author_id) ) {
                $exist = true;
                $find_author = $all_database_authors[$key]["id"];
                break; //Se trova l'ID dell'autore nel database interrompe il ciclo
            }
            else {
                $last_autor = $all_database_authors[$key]["id"];
            }
        }


        if($exist) {
        //if($image_info[0] > 300 && $image_info[1] > 400) {

            $title = $db->quote($title);
            $author_id = $db->quote($author_id);
            $year = $db->quote($year);

            if($main_character == "") {
                $main_character = NULL;
            }
            $main_character = $db->quote($main_character);
            
            $synopsis = $db->quote($synopsis);
            $img_url = $db->quote($img_url);



            $db->query("INSERT INTO books(poster, author_id, name, year, synopsis, main_character) 
                        VALUES($img_url, $author_id, $title, $year, $synopsis, $main_character);");


            print json_encode(array(
                'success' => "Book added to the database"
            ));
        /*}
        else {
            throw new Exception("Image is not of the right size.");
        }*/
        }
            else {
                throw new Exception("The author ID does not exists!");
            }
    
    }

/*
Script per rimuovere un libro letto dal database dell'utente
*/
if(isset($_POST["n_book"])) {
    $book_to_delete = $_POST["n_book"];
    $book_to_delete = $db->quote($book_to_delete);

    $username = $_SESSION["username"];
    $username = $db->quote($username);

    $db->query("DELETE FROM books_saved WHERE user = $username AND id_book = $book_to_delete;");
}
    
    
} catch (Exception | PDOException $error) {
    print json_encode(array(
        'error' => $error->getMessage()
    ));
}
?>
