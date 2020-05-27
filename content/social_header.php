<header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="../index.php"><img src="../../assets/images/home.png" style="height:20px;width:20px"
                                                         alt="Avatar"> SePay</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggler"
                aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarToggler">
            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <?php if (isset($_SESSION['id'])) {
                        echo '<a class="btn btn-outline-info" href="../wallet.php"><img src="../../assets/images/wallet.png" style="height:23px;width:23px" alt="Wallet"></a>';
                    } else {
                        echo '<a class="btn btn-outline-primary" href="../register.php">Register</a>';
                    } ?>
                </li>
                <?php if (isset($_SESSION['id'])) {
                    echo '<li class="nav-item">';
                    echo '<a href="profile.php" class="btn btn-outline-primary" title="My Profile"><img src="../../assets/images/account.png" style="height:23px;width:23px" alt="Avatar"></a>';
                    echo '</li>';
                } ?>
                <li class="nav-item">
                    <?php if (isset($_SESSION['id'])) {
                        echo '<a class="btn btn-outline-danger" href="../logout.php"><img src="../../assets/images/logout.png" style="height:23px;width:23px" alt="Logout"></a>';
                    } else {
                        echo '<a class="btn btn-outline-primary" href="../login.php">Login</a>';
                    } ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
