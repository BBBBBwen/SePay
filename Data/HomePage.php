<?php include_once __DIR__."/../Content/head.php";
include_once __DIR__."/../Content/header.php"; ?>
<link rel="stylesheet" href="/assets/css/form.css">
<?php
if (isset($_SESSION['username'])) {
    echo "<div style='text-align:center'><h1>welcome! " . $_SESSION['username'];
    echo '</h1><br>';
    ?>
    <span class="user"><img src="gs://sesame-pay.appspot.com/images/1.jpeg ?>"/></span></div>
<?php } ?>
