<?php
require_once "config.php";
session_start();
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
            $isPaymentExist = $db->query("SELECT * FROM payments WHERE payment_id = '".$payment_id."'");
            $user = $db->query("SELECT * FROM users WHERE id = '".$userID."'");
            $balance = $user['balance'] + $amount;

            if($isPaymentExist->num_rows == 0) {
                $insert = $db->query("INSERT INTO payments(user_id, payment_id, description, amount, currency, payment_status) VALUES('$userID','$payment_id', 'transaction from bank', '$amount', 'USD', 'Captured')");
                $update = $db->query("UPDATE users SET balance=".$balance." WHERE id='".$userID."'");
            }

            echo "Payment is successful. Your payment id is: ". $payment_id;
        } else {
            // payment failed: display message to customer
            echo $response->getMessage();
            echo 'check';
        }
    } catch(Exception $e) {
        echo $e->getMessage();echo 'check';
    }
}
