<?php include_once("../Content/head.php"); ?>
<!DOCTYPE html>
<html>
<?php include_once("../Content/header.php");
$db = new mysqli('localhost', 'root', 'root', 'SePay');
$user = $db->query("SELECT * FROM users WHERE id = '" . $_SESSION['id'] . "'")->fetch_assoc();
$transaction = $db->query("SELECT * FROM payments WHERE user_id = '" . $_SESSION['id'] . "' ORDER BY captured_at DESC");
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
                                <p class="left"><img src="<?= $_SESSION['avatar'] ?>" class="circle"
                                                     style="height:106px;width:106px"
                                                     alt="Avatar"></p>
                                <div class="right">
                                    <p><i class=""></i> Name <?php echo $user['username'] ?></p>
                                    <p><i class=""></i> Email <?php echo $user['email'] ?></p>
                                    <p><i class=""></i> Date  <?php echo $user['reg_date'] ?></p>
                                </div>
                            </span>

                            <div>
                                <a role="button" href="pay_form.php"
                                   class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button test_balance_btn-transferMoney">Send</a>
                                <a role="button" href="pay_form.php"
                                   class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button test_balance_btn-transferMoney">Request</a>
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
                                <span><?php echo $user['balance'] ?></span>
                            </div>
                            <button class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button test_balance_btn-transferMoney"
                                    id="transform" onclick="openwindow()">Transfer Money
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
                <li class="cw_tile-itemListContainer cw_tile-itemListContainer_hover  ">
                    <a class='cw_tile-itemListLink'>
                        <div aria-hidden="true" class='ppvx_container-fluid'>
                                    <span class='ppvx_row cw_tile-itemListRow cw_tile-activityListRow'>
                                        <?php if ($row = $transaction->fetch_assoc()) { ?>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['captured_at']; ?></p>
                                        <p class='ppvx_col-2 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['description']; ?></p>
                                        <p class='ppvx_col-3 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo '$' . $row['amount'];
                                            } ?></p>
                                    </span>
                        </div>
                    </a>
                </li>

                <li class="cw_tile-itemListContainer cw_tile-itemListContainer_hover  ">
                    <a class='cw_tile-itemListLink'>
                        <div aria-hidden="true" class='ppvx_container-fluid'>
                                    <span class='ppvx_row cw_tile-itemListRow cw_tile-activityListRow'>
                                        <?php if ($row = $transaction->fetch_assoc()) { ?>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['captured_at']; ?></p>
                                        <p class='ppvx_col-2 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['description']; ?></p>
                                        <p class='ppvx_col-3 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo '$' . $row['amount'];
                                            } ?></p>
                                    </span>
                        </div>
                    </a>
                </li>

                <li class="cw_tile-itemListContainer cw_tile-itemListContainer_hover  ">
                    <a class='cw_tile-itemListLink'>
                        <div aria-hidden="true" class='ppvx_container-fluid'>
                                    <span class='ppvx_row cw_tile-itemListRow cw_tile-activityListRow'>
                                        <?php if ($row = $transaction->fetch_assoc()) { ?>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['captured_at']; ?></p>
                                        <p class='ppvx_col-2 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['description']; ?></p>
                                        <p class='ppvx_col-3 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo '$' . $row['amount'];
                                            } ?></p>
                                    </span>
                        </div>
                    </a>
                </li>
            </ul>
            <a role="button" href="TransactionHistory.php"
               class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile__activity-moreButton">See
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
                        <input class="amount-enter" type="text" name="amount" placeholder="Enter Amount"/>
                        <div>
                            <button style="align-content: center"
                                    class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile__activity-moreButton">
                                Submit Payment
                            </button>
                        </div>
                </form>
            </div>

            <script src="../assets/js/card.js"></script>
        </div>
    </div>

    <!-- End Grid -->
</div>

<!-- End Page Container -->
</div>
<br>

<!-- Footer -->
<?php include_once("../Content/foot.php"); ?>
</body>
</html>