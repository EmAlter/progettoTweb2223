<?php
/* questa funzione risolve un errore di cookie SameSite*/
header("Set-Cookie: cross-site-cookie=whatever; SameSite=None; Secure");
?>