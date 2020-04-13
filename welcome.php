<link rel="stylesheet" href="form.css">
<?php
session_start();
echo "welcome!".$_SESSION['username'];
echo $_SESSION['avatar'];



?>
<span class="user"><img src='<?= $_SESSION['avatar'] ?>'/></span>

