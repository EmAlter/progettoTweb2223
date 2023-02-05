<?php
/* Documento che viene importanto da chi lo richiede per connettersi al database */

$db = new PDO("mysql:dbname=ac_db;host=localhost:3306", "root");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>