<?php include_once("../Content/head.php"); ?>
<!DOCTYPE html>
<html>
<?php include_once("../Content/header.php"); ?>
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
                                <p class="left"><img src="../images/1.jpeg" class="circle"
                                                     style="height:106px;width:106px"
                                                     alt="Avatar"></p>
                                <div class="right">
                                    <p><i class=""></i> Name</p>
                                    <p><i class=""></i> Email</p>
                                    <p><i class=""></i> Date</p>
                                </div>
                            </span>

                            <div>
                                <a role="button" href=""
                                   class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button test_balance_btn-transferMoney">Send</a>
                                <a role="button" href=""
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
                                <span>$0.0</span>
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
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>Date</p>
                                        <p class='ppvx_col-2 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>Describtion</p>
                                        <p class='ppvx_col-3 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>$0</p>
                                    </span>
                        </div>
                    </a>
                </li>

                <li class="cw_tile-itemListContainer cw_tile-itemListContainer_hover  ">
                    <a class='cw_tile-itemListLink'>
                        <div aria-hidden="true" class='ppvx_container-fluid'>
                                    <span class='ppvx_row cw_tile-itemListRow cw_tile-activityListRow'>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>Date</p>
                                        <p class='ppvx_col-2 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>Describtion</p>
                                        <p class='ppvx_col-3 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>$0</p>
                                    </span>
                        </div>
                    </a>
                </li>

                <li class="cw_tile-itemListContainer cw_tile-itemListContainer_hover  ">
                    <a class='cw_tile-itemListLink'>
                        <div aria-hidden="true" class='ppvx_container-fluid'>
                                    <span class='ppvx_row cw_tile-itemListRow cw_tile-activityListRow'>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>Date</p>
                                        <p class='ppvx_col-2 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>Describtion</p>
                                        <p class='ppvx_col-3 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>$0</p>
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
