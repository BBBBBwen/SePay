<?php session_start(); ?>
<style>
    body {
        font-family: Arial;
    }

    input[type=text],
    select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    input[type=submit] {
        width: 100%;
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #45a049;
    }

    div.container {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
    }

    #alert {
        padding: 20px;
        background-color: #f44336;
        color: white;
        text-align: center;
        font-size: 130%;
    }

    #success {}

</style>

<body>
<?php
include_once "../content/head.php";
include_once "../content/header.php";
require_once "../content/connect_database.php";
error_reporting(0);
if (isset($_SESSION['id'])){
if(!empty($_POST['biller_id'])){
    //request access_token from BPay
    $access_key = "WsKIRpaLx9fEo0LV26VXNh0Fp5Y1zP0N";
    $access_secret = "rEXmmMcq7my0Qrg8";
    $auth = 'Authorization: Basic '.base64_encode($access_key.':'.$access_secret);

    $token_url="https://sandbox.api.bpaygroup.com.au/oauth/token";

    $access_Request = array('client_id' => 'd8049436-6ffb-468e-97dc-cb3064177585' ,
        'grant_type'=> 'client_credentials');

    $access_Request = http_build_query($access_Request);
    $access_opts = array('http' => array('method' => 'POST', 'header' => $auth, 'content' => $access_Request));
    $access_stream = stream_context_create($access_opts);
    $access_response = file_get_contents($token_url, false, $access_stream);
    //get access_token
    $access_array=explode('"', $access_response);
    $access_token = 'Authorization: Bearer '.$access_array[3];
    //request biller id
    $biller_url = 'https://sandbox.api.bpaygroup.com.au/payments/v1/biller/'.$_POST['biller_id'];
    $biller_opts = array('http' => array('method' => 'GET', 'header' => $access_token ));
    $biller_stream = stream_context_create($biller_opts);
    $biller_response = file_get_contents($biller_url, false, $biller_stream);
    $biller_array=explode('"', $biller_response);

    $amount = $_POST['bill_amount'];
    $userID = $_SESSION['id'];
    $currency = 'AUD';

    $sql = "SELECT * FROM currency WHERE user_id = '" . $userID . "'";
    $stmt = $db->getDB()->prepare($sql);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql = "SELECT * FROM users WHERE id = '" . $userID . "'";
    $stmt = $db->getDB()->prepare($sql);
    $stmt->execute();
    $sender = $stmt->fetch(PDO::FETCH_ASSOC);

    if($biller_array[9] == "longName"){
        if($amount > $user[$currency] || $amount < 0) {
            echo '<div id="alert"><strong>Payment Failed<br/> There is no enough balance to </strong>';}
        else{

            $sql = "SELECT * FROM payments WHERE payment_id = '" . $payment_id . "'";
            $stmt = $db->getDB()->prepare($sql);
            $stmt->execute();
            $isPaymentExist = $stmt->fetch(PDO::FETCH_ASSOC);
            $balance = $user[$currency] - $amount;
            $description = 'Bpay to biller ' . $_POST['biller_id'];
            $receiverID = 0;
            $payment_id = 0;

            $sql = "INSERT INTO payments(user_id, transfer_id, payment_id, description, amount, currency, payment_status) VALUES('".$userID."','".$receiverID."','".$payment_id."', '".$description."', '".$amount."', '".$currency."', 'Captured')";
            $stmt = $db->getDB()->prepare($sql)->execute();
            $sql = "UPDATE currency SET ".$currency." = " . $balance . " WHERE user_id='" . $userID . "'";
            $stmt = $db->getDB()->prepare($sql)->execute();
        }

//        echo "<script> confirm('Please confirm your payment: Company Name:";
//        echo $biller_array[11];
//        echo "Amount: ";
//        echo $_POST['bill_amount'];
//        echo "')</script>";

        echo "<div id='alert'>Pay ".$_POST['bill_amount']." AUD to ".$biller_array[11]."<br/>Back To <a href='wallet.php'>My Wallet</a></div></div>";

    }else{
        echo "<div id='alert'> Biller Not Found<br/>Back To <a href='wallet.php'>My Wallet</a></div>";
    }
}else{
?>
<div class="container">
    <form action="" method="post">
        <div id="notice" style="text-align:center;">
            <img src="../assets/images/bpay.png" />
            <h5>Notice: Bpay could only use AUD</h5>
        </div>
        <label for="bill_reference">Reference number</label><input type="text" placeholder="Reference Number" name="bill_reference" /><br />
        <label for="biller_id">Biller ID</label><input type="text" placeholder="Available Biller IDs:
565572, 1313, 100008" name="biller_id" /><br />
        <label for="bill_amount">Amount</label><input type="text" placeholder="Amount" name="bill_amount" /><br />
        <input type="submit" />
    </form>
</div>
</body>
<?php
}
}

?>
