<?php include_once("../Content/head.php"); ?>
<!DOCTYPE html>
<html>
<?php include_once("../Content/header.php");
    $db = new mysqli('localhost', 'root', 'root', 'SePay');
    $user = $db->query("SELECT * FROM users WHERE id = '".$_SESSION['id']."'")->fetch_assoc();
    $transaction = $db->query("SELECT * FROM payments WHERE user_id = '".$_SESSION['id']."'");
?>
<body class="">

<!-- Page Container -->
<div class="" style="whole">
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
                                <p class="left"><img src="../assets/images/1.jpeg" class="circle"
                                                     style="height:106px;width:106px"
                                                     alt="Avatar"></p>
                                <div class="right">
                                    <p><i class=""></i> Name <?php echo $user['username'] ?></p>
                                    <p><i class=""></i> Email <?php echo $user['email'] ?></p>
                                    <p><i class=""></i> Date</p>
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
                                <span><?php echo $user['balance']?></span>
                            </div>
                            <a role="button" href="card_form.html"
                               class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button test_balance_btn-transferMoney">Transfer
                                Money</a>
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
                                        <?php if($row = $transaction->fetch_assoc()) { ?>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['captured_at'];?></p>
                                        <p class='ppvx_col-2 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['description'];?></p>
                                        <p class='ppvx_col-3 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo '$'.$row['amount'];}?></p>
                                    </span>
                        </div>
                    </a>
                </li>

                <li class="cw_tile-itemListContainer cw_tile-itemListContainer_hover  ">
                    <a class='cw_tile-itemListLink'>
                        <div aria-hidden="true" class='ppvx_container-fluid'>
                                    <span class='ppvx_row cw_tile-itemListRow cw_tile-activityListRow'>
                                        <?php if($row = $transaction->fetch_assoc()) {?>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['captured_at'];?></p>
                                        <p class='ppvx_col-2 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['description'];?></p>
                                        <p class='ppvx_col-3 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo '$'.$row['amount'];}?></p>
                                    </span>
                        </div>
                    </a>
                </li>

                <li class="cw_tile-itemListContainer cw_tile-itemListContainer_hover  ">
                    <a class='cw_tile-itemListLink'>
                        <div aria-hidden="true" class='ppvx_container-fluid'>
                                    <span class='ppvx_row cw_tile-itemListRow cw_tile-activityListRow'>
                                        <?php if($row = $transaction->fetch_assoc()) {?>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['captured_at'];?></p>
                                        <p class='ppvx_col-2 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['description'];?></p>
                                        <p class='ppvx_col-3 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo '$'.$row['amount'];}?></p>
                                    </span>
                        </div>
                    </a>
                </li>
            </ul>
            <a role="button" class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile__activity-moreButton">See
                More History</a>
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
