<?php require_once "../content/connect_database.php"; ?>
<?php
class PaymentAPI
{
    private $db;
    private $data;

    public function __construct($db, $data)
    {
        $this->db = $db;
        $this->data = $data;
    }

    public function isTokenExists()
    {
        $sql = "SELECT * FROM users WHERE id = ? AND user_level = 1";
        $stmt = $this->db->getDB()->prepare($sql);
        $stmt->execute([$this->data['token']]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function isUserExists() {
        $sql = "SELECT * FROM users WHERE email = ?";#AND password = ?";
        $stmt = $this->db->getDB()->prepare($sql);
        $stmt->execute([$this->data['email']]);#, $this->data['password']]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function pay() {
        $token = $this->isTokenExists();
        $user = $this->isUserExists();
        $currency = $this->data['currency'];
        $amount = $this->data['amount'];
        $payment_id = time();

        if($token && $user) {
            $userBalance = $this->db->getUserBalance($user['id']);
            $merchantBalance = $this->db->getUserBalance($token['id']);
            $isPaymentExist = $this->db->getPayment($payment_id);
            $balance = $userBalance[$currency] - $amount;
            $receiver_balance = $merchantBalance[$currency] + $amount;
            $description = 'pay money to ' . $token['username'] . ' for '. $this->data['item_name'];
            $receiverID = $token['id'];

            $result = $this->db->insertPayment($user['id'], $receiverID, $payment_id, $description, $amount, $currency, 'Captured');
            $result = $this->db->updateBalance($user['id'], $currency, $balance);
            $result = $this->db->updateBalance($token['id'], $currency, $receiver_balance);
            return "Succeed";
        }
        return "error token or error user";
    }
}

if($_GET['token'] && $_GET['email'] && $_GET['item_name'] && $_GET['currency'] && $_GET['amount']) {
    $data = [
        'token' => $_GET['token'],
        'email' => $_GET['email'],
        'item_name' => $_GET['item_name'],
        'currency' => $_GET['currency'],
        'amount' => $_GET['amount'],
    ];
    $pay = new PaymentAPI($db, $data);
    echo $pay->pay();
}
#http://localhost/SePay/data/payment_API.php?token=1&email=test@test.com&item_name=testItem&currency=AUD&amount=10