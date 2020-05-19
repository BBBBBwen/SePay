<?php require_once "page_not_found.php"; ?>
<?php require_once "../content/config.php"; ?>
<?php require_once "../content/connect_database.php"; ?>
<?php
if (isset($_POST['stripeToken']) && !empty($_POST['stripeToken']) && isset($_SESSION['id'])) {
    try {
        $response = $gateway->purchase([
            'amount' => $_POST['amount'],
            'currency' => $_POST['currency'],
            'token' => $_POST['stripeToken'],
        ])->send();

        if ($response->isSuccessful()) {
            // payment was successful: update database
            $arr_payment_data = $response->getData();

            // Insert transaction data into the database
            $isPaymentExist = getPayment($arr_payment_data['id']);
            if (!$isPaymentExist) {
                $user = getUserBalance($_SESSION['id']);
                $balance = $user[$_POST['currency']] + $_POST['amount']; //calculate new balance based on selected balance

                $result = insertPayment($_SESSION['id'], null, $arr_payment_data['id'], 'transaction from bank', $_POST['amount'], $_POST['currency'], 'Captured');
                $result = updateBalance($_SESSION['id'], $_POST['currency'], $balance);

                echo "<script> alert('Payment is successful. Your payment id is: " . $arr_payment_data['id'] . "');parent.location.href='wallet.php'; </script>";
            }
            echo "<script> alert('Payment is failed. you can try it again later');parent.location.href='wallet.php'; </script>";
        } else {
            // payment failed: display message to customer
            echo $response->getMessage();
        }
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>
