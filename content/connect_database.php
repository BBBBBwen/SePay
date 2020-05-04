<?php
$host = 'sepay.coqnkhi2ftwp.us-east-1.rds.amazonaws.com';
$dbName = 'sepay';
$db_user = 'root';
$db_pass = 'rootroot';
$dsn = "mysql:host=$host;port=3306;dbname=$dbName";
$db = new PDO($dsn, $db_user, $db_pass);
?>