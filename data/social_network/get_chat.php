<?php
require "../../content/connect_database.php";
$result = getChat($_GET['send'], $_GET['receive']);
if ($result) {
    foreach ($result as $row) {
        $userName = getUserInfoById($row->send_id)['username'];
        echo "from：:" . $userName . "\n";
        echo $row->content . "\n";
    }
} else {
    echo "empty";
}