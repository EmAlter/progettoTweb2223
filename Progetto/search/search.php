<?php
/*Rappresenta lo scheletro della pagina che permette la ricerca dei libri contenuti nel database*/


session_start();
include("../html/top.html");
include("../functions/resolve_samesite_error.php");
?>

<script src="search.js" type="text/javascript"></script>
<link href="../css/index-search.css" type="text/css" rel="stylesheet">

</header>


<body>
    <?php include ("../html/logged.html");?>

    <?php
    /*Nel caso l'utente non abbia fatto ancora login o signup riporta alla Home*/
    if(!isset($_SESSION["username"])) {
        $_SESSION["message"] = "You must log in or sign up to search books";
        header("Location: ../index.php");
    }
    ?>
    
    <h1>Welcome to Hon, <span id="n"><?= $_SESSION["username"] ?></span></h1>

    <img class="middleimg" src="../img/book.png">

    <p>This site will help you tracking books</p>
    <fieldset id="searchbar">
        <label><input name="book" type="text" placeholder="Search your book"><br></label>
        <label><input name="send" type="submit" value="Search" class="search"></label>
    </fieldset>

    <div class="results"></div>

<?php include("../html/bottom.html");?>