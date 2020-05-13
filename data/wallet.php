<?php require_once "page_not_found.php"; ?>
<?php include_once "../content/head.php"; ?>
<?php include_once "../content/header.php"; ?>
<?php require_once "../content/connect_database.php"; ?>
<?php
$user = getUserInfoById($_SESSION['id']);
$balance = getUserBalance($_SESSION['id']);

$sql = "SELECT * FROM payments WHERE user_id = :user_id OR transfer_id = :user_id ORDER BY captured_at DESC";
$stmt = $db->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['id']);
$stmt->execute();
?>

<body>

    <!-- Page Container -->
    <div class="whole">
        <!-- The Grid -->
        <div class="container">
            <!-- Left Column -->
            <div class="top_col">
                <tr>
                    <!-- Profile -->
                    <th>
                        <div class="upper_cards card top">
                            <div class="upper_cards full">
                                <h4 class="center">My Profile</h4>
                                <hr>
                                <span class="float:left; display:inline">
                                    <p class="left"><img src="<?= $_SESSION['avatar'] ?>" class="circle" style="height:106px;width:106px" alt="Avatar"></p>
                                    <div class="right">
                                        <p><i class=""></i> Name <?php echo $user['username'] ?></p>
                                        <p><i class=""></i> Email <?php echo $user['email'] ?></p>
                                        <p><i class=""></i> Date <?php echo $user['reg_date'] ?></p>
                                    </div>
                                </span>

                                <div>
                                    <a role="button" href="pay_form.php" class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button test_balance_btn-transferMoney">Send</a>
                                    <a role="button" href="bpay.php" class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button test_balance_btn-transferMoney">BPay</a>
                                </div>
                            </div>
                        </div>
                    </th>

                    <!-- Balance -->
                    <th>
                        <div class="card_left upper_cards card center">
                            <div class=""><br>
                                <div>
                                    <h1>Balance</h1>
                                </div>
                                <div>
                                    <span>EUR: <?php echo $balance['EUR'] ?></span>
                                    <span>AUD: <?php echo $balance['AUD'] ?></span>
                                    <span>USD: <?php echo $balance['USD'] ?></span>
                                </div>
                                <button class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button test_balance_btn-transferMoney" id="transform" onclick="open_transfer_window()">Transfer Money
                                </button>
                                <button class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button test_balance_btn-transferMoney" id="transform" onclick="open_exchange_window()">Exchange Currencies
                                </button>
                            </div>
                        </div>
                    </th>
                </tr>
            </div>

            <!-- Accordion -->
            <div class="card cw_tile-container">
                <h3 class='cw_tile-header'>Trasaction History</h3>
                <br>
                <ul class='cw_tile-itemList'>
                    <?php for ($i = 0; $i < 3; $i++) { ?>
                    <li class="cw_tile-itemListContainer cw_tile-itemListContainer_hover  ">
                        <a class='cw_tile-itemListLink'>
                            <div aria-hidden="true" class='ppvx_container-fluid'>
                                <span class='ppvx_row cw_tile-itemListRow cw_tile-activityListRow'>
                                    <?php if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                    <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['captured_at']; ?></p>
                                    <?php if ($_SESSION['id'] == $row['user_id']) { ?>
                                    <p class='ppvx_col-2 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['description']; ?></p>
                                    <?php } else {
                                            $sql = "SELECT * FROM users WHERE id = '" . $row['user_id'] . "'";
                                            $stmt1 = $db->prepare($sql);
                                            $stmt1->execute();
                                            $transfer = $stmt1->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                    <p class='ppvx_col-2 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo 'receive money from ' . $transfer["username"]; ?></p>
                                    <?php } ?>
                                    <p class='ppvx_col-3 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['currency'].' ' . $row['amount'];
                                            } ?></p>
                                </span>
                            </div>
                        </a>
                    </li>
                    <?php } ?>
                </ul>
                <a role="button" href="transaction_history.php" class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile__activity-moreButton">See
                    More History</a>
            </div>
        </div>

        <!-- popup -->
        <div id='myModal' class='popup'>
            <div class="popup-content">
                <div class="popup-header">
                    <span class="close">X</span>
                    <h2>Credit or debit card</h2>
                </div>

                <div class="popup-body">
                    <form action="charge.php" method="post" id="payment-form">

                        <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>

                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                        <input class="amount-enter" type="text" name="amount" placeholder="Enter Amount" />
                        <div>
                            <label>currency</label>

                            <select name="currency">
                                <option value="EUR">EUR</option>
                                <option value="USD">USD</option>
                                <option value="AUD">AUD</option>
                            </select>
                        </div>
                        <div>
                            <button style="align-content: center" class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile__activity-moreButton">
                                Submit Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- popup 2-->
        <div id='myModal1' class='popup1'>
            <div class="popup-content1">
                <div class="popup-header1">
                    <span class="close">X</span>
                    <h2>Currencies exchange</h2>
                </div>

                <div class="popup-body1">
                    <h3 style="color: red">exchange currency require 1% surcharge</h3>
                    <div>
                        <span>Current balance: </span>
                        <span>EUR: <?php echo $balance['EUR'] ?></span>
                        <span>AUD: <?php echo $balance['AUD'] ?></span>
                        <span>USD: <?php echo $balance['USD'] ?></span>
                    </div>
                    <form action="currencies_converter.php" method="post" id="payment-form">
                        <input class="amount-enter1" type="text" name="amount" placeholder="Enter Amount" />
                        <div>
                            <label>from:</label>
                            <select name="from">
                                <option value="EUR">EUR</option>
                                <option value="USD">USD</option>
                                <option value="AUD">AUD</option>
                            </select>

                            <label>to:</label>
                            <select name="to">
                                <option value="EUR">EUR</option>
                                <option value="USD">USD</option>
                                <option value="AUD">AUD</option>
                            </select>
                        </div>

                        <!-- Used to display form errors. -->
                        <div id="card-errors" role="alert"></div>
                        <div>
                            <button style="align-content: center" class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile__activity-moreButton">
                                Confirm
                            </button>
                        </div>
                    </form>
                </div>
                <!-- End Grid -->
            </div>
        </div>

        <script src="../assets/js/card.js"></script>
    </div>


    <!-- End Page Container -->
    <br>

    <!-- Footer -->
    <?php include_once "../content/foot.php"; ?>
</body>

</html>
