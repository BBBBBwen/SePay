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
        <div class="col">
            <!-- Profile -->
            <div class="upper_cards card">
                <div class="">
                    <h4 class="">My Profile</h4>
                    <p class=""><img src="../images/1.jpeg" class="circle" style="height:106px;width:106px"
                                     alt="Avatar"></p>
                    <hr>
                    <p><i class=""></i> Designer, UI</p>
                    <p><i class=""></i> London, UK</p>
                    <p><i class=""></i> April 1, 1988</p>
                </div>
            </div>
            <br>

            <!-- Balance -->
            <div class="upper_cards card center">
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
            <br>

        </div>

        <!-- Accordion -->
        <div class="card cw_tile-container">
            <h3 class='cw_tile-header'>Trasaction History</h3>
            <br>
            <ul class='center cw_tile-itemList'>
                <li class="cw_tile-itemListContainer cw_tile-itemListContainer_hover  ">
                    <a class='cw_tile-itemListLink'>
                        <div aria-hidden="true" class='ppvx_container-fluid'>
                                    <span class='ppvx_row cw_tile-itemListRow cw_tile-activityListRow'>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>Date</p>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>Describtion</p>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>$0</p>
                                    </span>
                        </div>
                    </a>
                </li>

                <li class="cw_tile-itemListContainer cw_tile-itemListContainer_hover  ">
                    <a class='cw_tile-itemListLink'>
                        <div aria-hidden="true" class='ppvx_container-fluid'>
                                    <span class='ppvx_row cw_tile-itemListRow cw_tile-activityListRow'>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>Date</p>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>Describtion</p>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>$0</p>
                                    </span>
                        </div>
                    </a>
                </li>

                <li class="cw_tile-itemListContainer cw_tile-itemListContainer_hover  ">
                    <a class='cw_tile-itemListLink'>
                        <div aria-hidden="true" class='ppvx_container-fluid'>
                                    <span class='ppvx_row cw_tile-itemListRow cw_tile-activityListRow'>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>Date</p>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>Describtion</p>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>$0</p>
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
