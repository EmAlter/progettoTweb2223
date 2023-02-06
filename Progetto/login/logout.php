<?php
session_start();
include("../html/top.html"); 
include("../functions/resolve_samesite_error.php");
?>

<link href="../css/login-signup.css" type="text/css" rel="stylesheet">
<script src="logout.js" type="text/javascript"></script>


</header>

<body>
    <?php include("../html/banner.html"); ?>

    <?php
    session_regenerate_id(TRUE);
    session_unset();
    session_destroy();
    //header("refresh:3; url=../index.php");
    ?>

    <div class="logout">
        <p>You logged out.</p><br>
        <p>You will be redirected to the home page after <span id="seconds"></span> seconds</p>
    </div>

    <?php include("../html/bottom.html"); ?>