<?php include_once("Content/head.php"); ?>
<?php include_once("Content/header.php"); ?>
<link rel="stylesheet" href="form.css">
<?php
if(isset($_SESSION['username'])) {
    echo "welcome! ".$_SESSION['username'];
    echo '<br>';
    echo $_SESSION['avatar'];
    echo '<br>';
?>
<span class="user"><img src='<?= $_SESSION['avatar'] ?>'/></span>
<?php } ?>

