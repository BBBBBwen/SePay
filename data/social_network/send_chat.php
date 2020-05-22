<?php
require "../../content/connect_database.php";
$result = insertChat($_POST['send'], $_POST['receive'], $_POST['content']);