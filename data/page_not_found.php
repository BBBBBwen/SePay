<?php
session_start();
if(!isset($_SESSION['id']) || $_SESSION['level'] == 0) {
    http_response_code(404);
    exit('Not Found');
}
?>