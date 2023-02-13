<?php
/*Questo documento è lo scheletro della pagina che mostra tutte le info del singolo utente*/


session_start();
include("../html/top.html");
include("../functions/resolve_samesite_error.php");
?>

<script src="profile.js" type="module"></script>
<link href="../css/profile.css" type="text/css" rel="stylesheet">

</header>

<body>
    <?php include("../html/logged.html"); ?>

    <?php
    if (!isset($_SESSION["username"])) {
        $_SESSION["message"] = "Error on trying to reach pages without being logged!";
        header("Location: ../index.php");
    }
    ?>
    <div class="all_info_container">
        <div class="profile_container">
            <div class="profile_info">
                <h2 id="username"> <span><?= $_SESSION["username"] ?></span>'s profile</h2>
                <div id="name"></div>
                <div id="lastname"></div>
                <div class="for_css">Date of birth: <span id="birth"></span></div>
                <div class="for_css">Account created: <br><span id="dateofcreation"></span></div>
            </div>

            <div class="table_saved">
                <p>Your saved books will show here</p>
                <table class="saved_books">
                </table>
                <div class="remove_row"><img id="remove" src="../img/remove_48.png"><br>
                <span id="removed"></span>
                </div>
            </div>
        </div>

        <?php
        /* Se l'utente è un amministratore, vengono resi visibili altri elementi */
        if (isset($_SESSION["admin"])) {
        ?>
            <p>You are an administrator, you can add new books and authors to the database.</p>
            <div class="admin_container">

                <div class="id_all_authors">
                    <table class="saved_id_authors"></table>
                </div>

                <div class="add_new_author">

                    <fieldset>
                    <legend>NEW AUTHOR</legend>
                        <label><input type="text" id="fullname" size="15" placeholder="Fullname"><br></label>
                        <label><input type="text" id="birth_author" maxlength="4" size="15" placeholder="Date of birth">
                            <input type="checkbox" id="before_Christ_author" name="before_Christ_author" value="before_Christ_author">(Before Christ?)<br></label>
                        <label><button id="admin_author">Add</button><br></label>
                        <label>
                            <p class="result_author"></p>
                        </label>
                    </fieldset>

                </div>

                <div class="add_new_book">
                    <fieldset>
                        <legend>NEW BOOK</legend>
                        <label><input type="text" id="book_name" name="book_name" size="15" placeholder="Book name"><br></label>
                        <label><input type="text" id="author_id" name="author_id" size="15" placeholder="Author ID"><br></label>
                        <label><input type="text" id="year" name="year" maxlength="4" size="15" placeholder="Year of publication">
                            <input type="checkbox" id="before_Christ_book" name="before_Christ_book" value="before_Christ_book">(Before Christ?)<br></label>
                        <label><input type="text" id="main_character" name="main_character" size="15" placeholder="Main character"><br></label>
                        <label><textarea id="synopsis" name="synopsis" rows="5" cols="30" placeholder="Synopsis"></textarea><br></label>
                        <label><input type="file" accept=".jpg" id="poster" name="poster" size="15"><br></label>
                        <label><button id="admin_book">Add</button></label>
                        <label>
                            <p class="result_book"></p>
                        </label>
                    </fieldset>

                </div>
            </div>


        <?php } ?>
    </div>


    <?php include("../html/bottom.html"); ?>