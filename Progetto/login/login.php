<?php 
session_start();
if(isset($_SESSION["username"])) { 
        unset($_SESSION["username"]); //unset previous login or sign up session
}
include("../html/top.html"); ?>

<script src="loginUser.js" type="module"></script>
<link href="../css/index-search.css" type="text/css" rel="stylesheet">

</header>

<body>
    <?php include("../html/banner.html"); ?>
    <img class="middleimg" src="../img/book.png">
    <p>Login to your account</p>
    <fieldset class="login">
            <label><input type="text" id="username" maxlength="12" placeholder="Username" size="15"><br></label>
            <label><input type="password" id="password" placeholder="Password" size="15"><br></label>
            <label><button id="submit_usandpassw">Log In</button></label>
    </fieldset>

    <p class="err"></p>

    <?php include("../html/bottom.html"); ?>