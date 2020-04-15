<?php session_start(); ?>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="<?php echo $path ?>"><img src="../assets/images/home.png" style="height:20px;width:20px"
                                                                alt="Avatar"> SePay</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
                aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <?php if (isset($_SESSION['username'])) {
                        echo '<a class="btn btn-outline-info" href="Wallet.php">Wallet</a>';
                    } else {
                        echo '<a class="btn btn-outline-primary" href="../register.php">Register</a>';
                    } ?>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['username'])) {
                        echo '<a href="Wallet.php class="btn btn-outline-primary" title="My Account"><img src="../assets/images/account.png" style="height:23px;width:23px" alt="Avatar"></a>';
                    } else {
                        echo $_SESSION['username'];
                        echo '<a class="btn btn-outline-primary" href="../login.php">Login</a>';
                    } ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
