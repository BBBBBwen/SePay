<?php require_once "page_not_found.php"; ?>
<?php include_once "../content/head.php"; ?>
<?php include 'rsa.php'; ?>
<?php include 'des.php'; ?>
<?php include_once "../content/header.php"; ?>
<?php require_once "../content/connect_database.php"; ?>
<?php
if (isset($_SESSION['id']) && isset($_POST['email'])) {
    try {
        $email = $_POST['email'];
        $payment_id = time();
        $userID = $_SESSION['id'];
        $currency = $_POST['to'];
        $userBalance = $db->getUserBalance($userID);

        $sender = $db->getUserInfoById($userID);
        $receiver = $db->getUserInfoByEmail($email);

        $privateKey = get_rsa_privatekey(__DIR__ . '/../assets/private.key');
        $recovered_des = rsa_decryption($sender['payment_password'], $privateKey);
        $privateKey_client = get_rsa_privatekey(__DIR__ . '/../assets/private.key');
        $recovered_client = rsa_decryption($_POST['payment_password'], $privateKey_client);
        $amount = doubleval(php_des_decryption($recovered_des, $_POST['amount']));

        if ($recovered_des == $recovered_client) {
            if (!$receiver) {
                $error = 'there is no such user';
            } else if ($amount > $userBalance[$currency] || $amount < 0) {
                $error = 'there is no enough balance';
            } else {
                $receiverBalance = $db->getUserBalance($receiver['id']);
                $isPaymentExist = $db->getPayment($payment_id);
                $balance = $userBalance[$currency] - $amount;
                $receiver_balance = $receiverBalance[$currency] + $amount;
                $description = 'transfer money to ' . $receiver['username'];
                $receiverID = $receiver['id'];

                $result = $db->insertPayment($userID, $receiverID, $payment_id, $description, $amount, $currency, 'Captured');
                $result = $db->updateBalance($userID, $currency, $balance);
                $result = $db->updateBalance($receiver['id'], $currency, $receiver_balance);
                echo "<script> alert('Payment is successful. Your payment id is: " . $payment_id . "');parent.location.href='wallet.php'; </script>";
            }
        } else {
            $error = "Please enter correct payment password";
        }
    } catch (Exception $e) {
        $error = "encryption error";
    }
}
?>
<body>
<div class="whole">
    <form action="" method="post" class="container">
        <div>
            <div class="card" style="margin: 10%">
                <h2>Send money</h2>
                <?php if(!empty($error)) { ?>
                    <div style="color: red"><?php echo $error; ?></div>
                <?php }?>
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
                                        <label>Currency:</label>

                                        <select name="to">
                                            <option value="EUR">EUR</option>
                                            <option value="USD">USD</option>
                                            <option value="AUD">AUD</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label>Payment Password:</label>
                                    <input type="password" placeholder="Payment Password" id="payment_password"
                                           name="payment_password" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <button class="ppvx_btn ppvx_btn--secondary ppvx_btn--size_sm cw_tile-button test_balance_btn-transferMoney" type="submit" onclick="DES_encryption();">Confirm Payment</button>
            </div>
        </div>
    </form>
</div>
<script src="../assets/js/rsa.js"></script>
<script src="../assets/js/des.js"></script>
<script type="text/javascript">

    //Encrypt amount number by DES
    function DES_encryption() {
        var DES_key = document.getElementById("payment_password").value;
        var encrypted_des_key = RSA_encryption(DES_key);
        document.getElementById("payment_password").value = encrypted_des_key;
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
