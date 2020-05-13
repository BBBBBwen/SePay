<?php session_start(); ?>
<head>
    <meta charset="UTF8">
    <title>SePay</title>
    <link id='styleCss' type="text/css" rel="styleSheet" href="assets/css/indexStyle.css">
    <link type="text/css" rel="stylesheet" href="assets/css/style.css">
    <link type="text/css" rel="stylesheet" href="assets/css/wallet.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
        html, body, h1, h2, h3, h4, h5 {font-family: "Open Sans", sans-serif}
    </style>
</head>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="index.php"><img src="assets/images/home.png" style="height:20px;width:20px"
                                                      alt="Avatar"> SePay</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
                aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <?php if (isset($_SESSION['id'])) {
                        echo '<a class="btn btn-outline-info" href="data/wallet.php"><img src="assets/images/wallet.png" style="height:23px;width:23px" alt="Wallet"></a>';
                    } else {
                        echo '<a class="btn btn-outline-primary" href="data/register.php">Register</a>';
                    } ?>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['id'])) {
                        echo '<a href="data/wallet.php" class="btn btn-outline-primary" title="My Account"><img src="assets/images/account.png" style="height:23px;width:23px" alt="Avatar"></a>';
                        echo '<a class="btn btn-outline-danger" href="data/logout.php"><img src="assets/images/logout.png" style="height:23px;width:23px" alt="Logout"></a>';
                    } else {
                        echo '<a class="btn btn-outline-primary" href="data/login.php">Login</a>';
                    } ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
<link rel="stylesheet" href="assets/css/form.css">
<?php
if(isset($_SESSION['username'])) {
    echo "<div style='text-align:center'><h1>welcome! ".$_SESSION['username'];
    echo '</h1><br>';
    ?>
    <span class="user"><img src='<?= $_SESSION['avatar'] ?>'></span></div>
<?php } ?>

