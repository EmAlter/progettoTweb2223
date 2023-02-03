<?php include("../html/top.html"); ?>

<script src="addNewUser.js" type="module"></script>
<link href="../css/index-search.css" type="text/css" rel="stylesheet">

</header>

<body>
    <?php include("../html/banner.html"); ?>
    <img class="middleimg" src="../img/book.png">
    <p>Create a new account</p>
    <div class="signup">
        <fieldset>
            <label><input type="text" id="firstname" size="15" placeholder="First Name"><br></label>
            <label><input type="text" id="lastname" size="15" placeholder="Last Name"><br></label>
            <label><input type="date" id="birth" size="15"><br></label>
            <label><input type="text" id="username" maxlength="12" size="15" placeholder="Username"><br></label>
            <label><input type="password" id="password" size="15" placeholder="Password"><br></label>
            <label><input type="password" id="confirmpassword" size="15" placeholder="Confirm Password"><br></label>
            <label>Admin profile?</label><br>
            <label><input type="radio" name="admin" id="administrator_account" value="1">Yes
                <input type="radio" name="admin" id="user_account" value="0" checked="checked">No</label><br>
            <label><button id="submit_usandpassw">Sign Up</button></label>
        </fieldset>
        <p class="err"></p>
    </div>

    <?php include("../html/bottom.html"); ?>