<?php require_once "page_not_found.php"; ?>
<?php include_once "../content/head.php"; ?>
<?php include 'rsa.php'; ?>
<?php include 'des.php'; ?>
<?php include_once "../content/header.php"; ?>
<?php require_once "../content/connect_database.php"; ?>
<?php
if (isset($_SESSION['id']) && isset($_GET['id'])) {
    $info = $db->getPaymentById($_GET['id']);
} else {
    echo "something went wrong";
}

?>
<body>
<div class="whole">
    <div>
        <div class="card" style="margin: 10%">
            <div style="border: 1px solid #9da3a6">
                <a role="button" href="wallet.php"
                   class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile__activity-moreButton"
                   style="width: 15%">Go Back</a>
            </div>
            <label>Payment ID</label>
            <p><?php echo $info['payment_id']; ?></p><br>
            <label>Amount</label>
            <p><?php echo $info['currency'] . " " . $info['amount']; ?></p><br>
            <label>Description</label>
            <p><?php echo $info['description']; ?></p><br>
            <label>Time</label>
            <p><?php echo $info['captured_at']; ?></p><br>
        </div>
    </div>
    <!-- Footer -->
    <?php include_once '../content/foot.php'; ?>

</body>
</html>
