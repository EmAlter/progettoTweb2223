<?php
/*Questo documento imposta lo scheletro della pagina che mostra tutte le informazioni di un singolo libro */

session_start();
include("../html/top.html");
include("../functions/resolve_samesite_error.php");
?>

<script src="../bookinfo/book.js" type="text/javascript"></script>
<link href="../css/bookinfo.css" type="text/css" rel="stylesheet">

</header>

<body>
    <?php include("../html/logged.html"); ?>

    <div class="binfo">
        <div class="all_info">
            <div id="poster"></div>
            <div id="n">Book n. <span id="number"></span></div>
            <div id="title"></div>
            <div id="year"></div>
            <div id="author"></div>
            <div id="main_c"></div>
            <div id="rating"></div>

            <div id="b">
                <button class="add" type="button">Add</button>
            </div>

            <div id="your_vote">
                <select id="ratg" name="rating">
                    <option value="nd">to vote</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                </select>
            </div>
            <div id="voted"></div>
        </div>

        <div class="synopsis">
            <h2>Synopsis:</h2>
            <p></p>
        </div>
    </div>

    <?php include("../html/bottom.html"); ?>