<?php require_once "../content/config.php"; ?>
<?php require_once "../content/connect_database.php"; ?>
<?php
if (isset($_POST['stripeToken']) && !empty($_POST['stripeToken']) && isset($_SESSION['id'])) {

    try {
        $token = $_POST['stripeToken'];

        $response = $gateway->purchase([
            'amount' => $_POST['amount'],
            'currency' => 'AUD',
            'token' => $token,
        ])->send();

        if ($response->isSuccessful()) {
            // payment was successful: update database
            $arr_payment_data = $response->getData();
            $payment_id = $arr_payment_data['id'];
            $userID = $_SESSION['id'];
            $amount = $_POST['amount'];

            // Insert transaction data into the database
            $sql = "SELECT * FROM payments WHERE payment_id = '" . $payment_id . "'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $isPaymentExist = $stmt->fetch(PDO::FETCH_ASSOC);

            $sql = "SELECT * FROM users WHERE id = '" . $userID . "'";
            $stmt = $db->prepare($sql);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $balance = $user['balance'] + $amount;

            if ($isPaymentExist['num'] == 0) {
                $sql = "INSERT INTO payments(user_id, payment_id, description, amount, currency, payment_status) VALUES('$userID','$payment_id', 'transaction from bank', '$amount', 'AUD', 'Captured')";
                $stmt = $db->prepare($sql);
                $stmt->execute();

                $sql = "UPDATE users SET balance=" . $balance . " WHERE id='" . $userID . "'";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                echo "<script> alert('Payment is successful. Your payment id is: " . $payment_id . "');parent.location.href='wallet.php'; </script>";
            }
            echo "<script> alert('Payment is failed. you can try it again later');parent.location.href='wallet.php'; </script>";
        } else {
            // payment failed: display message to customer
            echo $response->getMessage();
            echo 'check';
        }
    } catch (Exception $e) {
        echo $e->getMessage();
        echo 'check';
    }

}
?>
