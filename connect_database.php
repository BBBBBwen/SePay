<?php
$host = 'localhost';
$dbName = 'SePay';
$db_user = 'root';
$db_pass = 'root';
$dsn = "mysql:host=$host;port=8889;dbname=$dbName";
$db = new PDO($dsn, $db_user, $db_pass);
?>