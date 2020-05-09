<?php include_once "../content/head.php"; ?>
<?php include 'rsa.php'; ?>
<?php include 'des.php'; ?>
<?php include_once "../content/header.php"; ?>
<?php require_once "connect_database.php"; ?>
<?php
if (isset($_SESSION['id']) && isset($_POST['email'])) {
    try {
        $email = $_POST['email'];
        $payment_id = 0;
        $userID = $_SESSION['id'];
        $currency = $_POST['$currency'];
        $sql = "SELECT * FROM currency WHERE user_id = '" . $userID . "'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        $sql = "SELECT * FROM users WHERE email = '" . $email . "'";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $receiver = $stmt->fetch(PDO::FETCH_ASSOC);

        $privateKey = get_rsa_privatekey(__DIR__ . '/../assets/private.key');
        $recovered_des = rsa_decryption($user['paymentpassword'], $privateKey);
        $privateKey_client = get_rsa_privatekey(__DIR__ . '/../assets/private.key');
        $recovered_client = rsa_decryption($_POST['paymentpassword'], $privateKey_client);
        $amount = doubleval(php_des_decryption($recovered_des, $_POST['amount']));

        if ($recovered_des == $recovered_client) {
            if ($receiver && $amount <= $user[$currency] && $amount > 0) {
                $sql = "SELECT * FROM payments WHERE payment_id = '" . $payment_id . "'";
                $stmt = $db->prepare($sql);
                $stmt->execute();
                $isPaymentExist = $stmt->fetch(PDO::FETCH_ASSOC);
                $balance = $user[$currency] - $amount;
                $receiver_balance = $receiver['balance'] + $amount;
                $description = 'transfer money to ' . $receiver['username'];
                $receiverID = $receiver['id'];

                $sql = "INSERT INTO payments(user_id, transfer_id, payment_id, description, amount, currency, payment_status) VALUES('".$userID."','".$receiverID."','".$payment_id."', '".$description."', '".$amount."', '".$currency."', 'Captured')";
                $stmt = $db->prepare($sql)->execute();

                $sql = "UPDATE currency SET AUD = " . $balance . " WHERE id='" . $userID . "'";
                $stmt = $db->prepare($sql)->execute();

                $sql = "UPDATE currency SET AUD = " . $receiver_balance . " WHERE id='" . $receiver['id'] . "'";
                $stmt = $db->prepare($sql)->execute();
                echo "<script> alert('Payment is successful. Your payment id is: " . $payment_id . "');parent.location.href='wallet.php'; </script>";
            } else {
                echo 'there is no such user or no enough balance';
            }
        } else {
            echo "Please enter correct payment password";
        }
    } catch (Exception $e) {
        echo 'Wrong';
    }
}
?>
<body>
<div class="whole">
    <form action="" method="post" class="container">
        <div>
            <div class="card" style="margin: 10%">
                <h2>Send money</h2>
                <div>
                    <div>
                        <div>
                            <div>
                                <div>
                                    <label>Email:</label>
                                    <input type="email" placeholder="Email" name="email" required/>
                                </div>
                                <div>
                                    <label>Amount:</label>
                                    <input type="text" placeholder="amount" id="amount" name="amount" required/>
                                    <div>
                                        <label for="currency">to:</label>

                                        <select id="currency">
                                            <option value="eur">EUR</option>
                                            <option value="usd">USD</option>
                                            <option value="aud">AUD</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label>Payment Password:</label>
                                    <input type="text" placeholder="Payment Password" id="paymentpassword"
                                           name="paymentpassword" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" onclick="DES_encryption();">Confirm Payment</button>
            </div>
        </div>
    </form>
</div>
<script src="../assets/js/rsa.js"></script>
<script src="../assets/js/des.js"></script>
<script type="text/javascript">

    //Encrypt amount number by DES
    function DES_encryption() {
        var DES_key = document.getElementById("paymentpassword").value;
        var encrypted_des_key = RSA_encryption(DES_key);
        document.getElementById("paymentpassword").value = encrypted_des_key;
        var amount = document.getElementById("amount").value;
        var encrypted_amount = javascript_des_encryption(DES_key, amount);
        document.getElementById("amount").value = encrypted_amount;
    }

    //Encrypt DES key by RSA public key
    function RSA_encryption(deskey) {
        var pubilc_key = "-----BEGIN PUBLIC KEY-----MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAzdxaei6bt/xIAhYsdFdW62CGTpRX+GXoZkzqvbf5oOxw4wKENjFX7LsqZXxdFfoRxEwH90zZHLHgsNFzXe3JqiRabIDcNZmKS2F0A7+Mwrx6K2fZ5b7E2fSLFbC7FsvL22mN0KNAp35tdADpl4lKqNFuF7NT22ZBp/X3ncod8cDvMb9tl0hiQ1hJv0H8My/31w+F+Cdat/9Ja5d1ztOOYIx1mZ2FD2m2M33/BgGY/BusUKqSk9W91Eh99+tHS5oTvE8CI8g7pvhQteqmVgBbJOa73eQhZfOQJ0aWQ5m2i0NUPcmwvGDzURXTKW+72UKDz671bE7YAch2H+U7UQeawwIDAQAB-----END PUBLIC KEY-----";
        var encrypt = new JSEncrypt();
        encrypt.setPublicKey(pubilc_key);
        var encrypted = encrypt.encrypt(deskey);
        return encrypted;
    }

</script>
<!-- Footer -->
<?php include_once '../content/foot.php'; ?>

</body>
</html>
