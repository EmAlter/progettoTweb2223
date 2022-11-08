<?php include "top.html"; ?>

<!--
    Pagina di login con un label dove si inserisce il nome per loggarsi e 
    lo si invia con il metodo GET al documento matches-submit.php
 -->

<form action="matches-submit.php" method="GET">
    <fieldset>
        <legend>Returning User:</legend>
        <strong>Name:</strong> <label><input type="text" size="16" name="name"></label><br>
        <label><input type="submit" name="submit" value="View My Matches"></label>
    </fieldset>
</form>

<?php include "bottom.html"; ?>