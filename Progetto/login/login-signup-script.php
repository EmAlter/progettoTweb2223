<?php
    session_start();
    include("../database/db.php");

try {

    if(isset($_POST["firstname"]) && isset($_POST["lastname"]) && isset($_POST["birth"]) &&
    isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["radio"])) {

        if(isset($_SESSION["username"])) {
            unset($_SESSION["username"]);
        }

        $firstname = $_POST["firstname"];
        $lastname = $_POST["lastname"];
        $username = $_POST["username"];
        $password = $_POST["password"];
        $birth = $_POST["birth"];
        $radio = $_POST["radio"];
        $username = $db->quote($username);

        $alreadyexist = $db->query("SELECT nickname FROM users WHERE nickname = $username");
        $alreadyexist = $alreadyexist->fetch(PDO::FETCH_ASSOC);

        if(!$alreadyexist) {
            $firstname = $db->quote($firstname);
            $lastname = $db->quote($lastname);
            $password = $db->quote($password);
            $birth = $db->quote($birth);


            $todaydate = date("Y-m-d");
            $todaydate = $db->quote($todaydate);
                
            $db->query("INSERT INTO users(nickname, password, date_of_creation, administrator) 
                    VALUES($username, $password, $todaydate, $radio);");
                
            $db->query("INSERT INTO user_info(info_nickname, firstname, lastname, birth) 
                    VALUES($username, $firstname, $lastname, $birth);");


            $_SESSION["username"] = str_replace("'", "", $username);
            if(isAdmin($radio)) {
                $_SESSION["admin"] = "yes";
            }
            
            print json_encode(array(
                'success'));
        }
        else {
            throw new Exception("Username already exists!");
        }

    }


    if(isset($_POST["user"]) && isset($_POST["pssw"])) {
        $username = $_POST["user"];
        $password = $_POST["pssw"];


        $username = $db->quote($username);
        $password = $db->quote($password);

        $checkuser = $db->query("SELECT nickname FROM users WHERE nickname = $username;");
        $checkuser = $checkuser->fetch(PDO::FETCH_ASSOC);

        $psw = $db->query("SELECT password FROM users WHERE nickname = $username AND password = $password;");
        $psw = $psw->fetch(PDO::FETCH_ASSOC);

        if(!$checkuser) {
            throw new Exception("Username does not exists!");
        }

        else if($checkuser && !$psw) {
            throw new Exception("Wrong password!");
        }

        else {
    
            $_SESSION["username"] = str_replace("'", "", $username);
            
            $ad = $db->query("SELECT administrator FROM users WHERE nickname = $username;");
            $ad = $ad->fetch(PDO::FETCH_ASSOC);

            if(isAdmin($ad["administrator"])) {
                $_SESSION["admin"] = "yes";
            }

            print json_encode(array(
                'success'));
        }
    }
}
    catch(Exception $error) {
    print json_encode(array(
        'error' => $error->getMessage()
    ));
}

/*
Funzione che verifica se un account è anche amministratore
*/
function isAdmin($bool) {
    return strcmp($bool, "1") == 0;
}
    
?>
