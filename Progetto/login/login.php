<?php
session_start();
if (isset($_SESSION["username"])) {
        unset($_SESSION["username"]); //unset la sessione precedente di login o signup
}
include("../html/top.html"); ?>

<script src="login.js" type="module"></script>
<link href="../css/login-signup.css" type="text/css" rel="stylesheet">

</header>

<body>
        <?php include("../html/banner.html"); ?>
        <img class="middleimg" src="../img/book.png">
        <p>Login to your account</p>
        <div class="login">
                <fieldset>
                        <label><input type="text" id="username" maxlength="12" placeholder="Username" size="15"><br></label>
                        <label><input type="password" id="password" placeholder="Password" size="15"><br></label>
                        <label><button id="submit_usandpassw">Log In</button></label>
                </fieldset>
        </div>

        <p class="err"></p>

        <?php include("../html/bottom.html"); ?>