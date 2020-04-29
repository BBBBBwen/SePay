<?php include_once __DIR__ . "/../content/head.php"; ?>
<!DOCTYPE html>
<html>
<?php include_once __DIR__ . "/../content/header.php";
require_once __DIR__ . "/connect_database.php";

$sql = "SELECT * FROM payments WHERE user_id = :user_id OR transfer_id = :transfer_id ORDER BY captured_at DESC";
$stmt = $db->prepare($sql);
$stmt->bindValue(':user_id', $_SESSION['id']);
$stmt->bindValue(':transfer_id', $_SESSION['id']);
$stmt->execute();
?>
<body class="">

<div class="whole">
    <div class="container">
        <div class="card cw_tile-container">
            <div style="border: 1px solid #9da3a6">
                <a role="button" href="Wallet.php"
                   class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile__activity-moreButton"
                   style="width: 15%">Go Back</a>
            </div>
            <h3 class='cw_tile-header'>Trasaction History</h3>
            <br>
            <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                <ul class='cw_tile-itemList'>
                    <li class="cw_tile-itemListContainer cw_tile-itemListContainer_hover  ">
                        <a class='cw_tile-itemListLink'>
                            <div aria-hidden="true" class='ppvx_container-fluid'>
                                    <span class='ppvx_row cw_tile-itemListRow cw_tile-activityListRow'>
                                        <p class='ppvx_col-1 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['captured_at']; ?></p>
                                        <?php if ($row['user_id'] == $_SESSION['id']) { ?>
                                            <p class='ppvx_col-2 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo $row['description']; ?></p>
                                        <?php } else {
                                            $sql = "SELECT * FROM users WHERE id = '" . $row['user_id'] . "'";
                                            $stmt = $db->prepare($sql);
                                            $stmt->execute();
                                            $transfer = $stmt->fetch(PDO::FETCH_ASSOC);
                                            ?>
                                            <p class='ppvx_col-2 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'><?php echo 'receive money from ' . $transfer["username"]; ?></p>
                                        <?php } ?>
                                        <div class='ppvx_col-3 cw_tile-itemListCol cw_tile__activity-txnDateContainer test_activity-txnDateContainer'>
                                            <p><?php echo '$' . $row['amount']; ?></p>
                                            <p><?php echo $row['payment_status']; ?></p>
                                        </div>
                                    </span>
                            </div>
                        </a>
                    </li>
                </ul>
            <?php } ?>
        </div>
    </div>
    <!-- End Grid -->
</div>

<!-- End Page Container -->
</div>
<br>

<!-- Footer -->
<?php include_once __DIR__ . "/../content/foot.php"; ?>

</body>
</html>
