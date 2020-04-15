<?php session_start(); ?>
<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="../index.php"><img src="../assets/images/home.png" style="height:20px;width:20px"
                                                                alt="Avatar"> SePay</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
                aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <?php if (isset($_SESSION['id'])) {
                        echo '<a class="btn btn-outline-info" href="Wallet.php">Wallet</a>';
                    } else {
                        echo '<a class="btn btn-outline-primary" href="../register.php">Register</a>';
                    } ?>
                </li>
                <li class="nav-item">
                    <?php if (isset($_SESSION['id'])) {
                        echo '<a href="Wallet.php class="btn btn-outline-primary" title="My Account"><img src="../assets/images/account.png" style="height:23px;width:23px" alt="Avatar"></a>';
                        echo '<a class="btn btn-outline-danger" href="logout.php">Logout</a>';
                    } else {
                        echo '<a class="btn btn-outline-primary" href="../login.php">Login</a>';
                    } ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
