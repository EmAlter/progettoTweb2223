<?php
/*Questo documento imposta lo scheletro della pagina che mostra tutte le informazioni di un singolo libro */

session_start();
include("../html/top.html");
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

            <div id="b">
                <button class="add" type="button">Add</button>
            </div>
        </div>

        <div class="synopsis">
            <h2>Synopsis:</h2>
            <p></p>
        </div>
    </div>

    <?php include("../html/bottom.html"); ?>