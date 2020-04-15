<?php include_once("../Content/head.php"); ?>
<!DOCTYPE html>
<html>
<?php include_once("../Content/header.php");
require_once "config.php";

if (isset($_SESSION['id']) && isset($_POST['email'])) {
    try {
        $email = $_POST['email'];
        $amount = $_POST['amount'];
        $payment_id = 0;
        $userID = $_SESSION['id'];
        $user = $db->query("SELECT * FROM users WHERE id = '".$userID."'");
        $isEmailExist = $db->query("SELECT * FROM users WHERE email = '".$email."'");

        if ($isEmailExist->num_rows != 0) {
            // Insert transaction data into the database
            $isPaymentExist = $db->query("SELECT * FROM payments WHERE payment_id = '".$payment_id."'");
            $user = $db->query("SELECT * FROM users WHERE id = '".$userID."'")->fetch_assoc();;
            $balance = $user['balance'] + $amount;
            $description = 'transfer money to '.$user['username'];

            if($isPaymentExist->num_rows == 0) {
                $insert = $db->query("INSERT INTO payments(user_id, payment_id, description, amount, currency, payment_status) VALUES('$userID','$payment_id', '$description', '$amount', 'AUD', 'Captured')");
                $update = $db->query("UPDATE users SET balance=".$balance." WHERE id='".$userID."'");
            }

            echo "Payment is successful. Your payment id is: ". $payment_id;
        } else {
            echo 'there is no such user';
        }
    } catch(Exception $e) {
        echo 'Wrong';
    }
}
?>
<body>
    <form action="" method="post">
        <div>
            <div>
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
                                    <input type="text" placeholder="amount" name="amount" required/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <button>Confirm Payment</button>
    </form>

<!-- Footer -->
<?php include_once("../Content/foot.php"); ?>

</body>
</html>
