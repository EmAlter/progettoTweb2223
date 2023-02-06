<?php
/*Questo documento rappresenta la Home del sito*/


session_start();
include("../Progetto/html/top.html");
include("../Progetto/functions/resolve_samesite_error.php");
?>

<link href="../Progetto/css/index-search.css" type="text/css" rel="stylesheet">

</header>

<body>
    <?php include("../Progetto/html/banner.html"); ?>

    <h1>Welcome to Hon</h1>

    <!-- Nel caso l'utente sia già loggato -->
    <?php if (isset($_SESSION["username"])) {    ?>
        <h2>You are logged as <?= $_SESSION["username"] ?></h2>

    <?php } ?>

    <img class="middleimg" src="../Progetto/img/book.png">
    <p>This site will help you tracking books</p><br>
    <p>If you want to start searching books you must be logged.</p><br>
    <p>Create a new account or sign in to an existing.</p>


    <?php
    if (isset($_SESSION["message"])) {
    ?>
        <div class="err"> <?= $_SESSION["message"] ?> </div>

    <?php
        unset($_SESSION["message"]);
    }
    ?>

    <?php include("../Progetto/html/bottom.html"); ?>