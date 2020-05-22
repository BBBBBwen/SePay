<?php
$host = 'sepay.coqnkhi2ftwp.us-east-1.rds.amazonaws.com';
$dbName = 'sepay';
$db_user = 'root';
$db_pass = 'rootroot';
$dsn = "mysql:host=$host;port=3306;dbname=$dbName";

try {
    $db = new PDO($dsn, $db_user, $db_pass);
} catch (PDOException $e) {
    die("connect database failed" . $e->getMessage());
}

function getUserInfoById($user_id)
{
    global $db;
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserInfoByEmail($email)
{
    global $db;
    $sql = "SELECT * FROM users WHERE email= ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$email]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

//get all user but id
function getAllUsers($id)
{
    global $db;
    $sql = "SELECT id, username, avatar FROM users WHERE id != ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function getUserBalance($user_id)
{
    global $db;
    $sql = "SELECT * FROM currency WHERE user_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$user_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getPayment($payment_id)
{
    global $db;
    $sql = "SELECT * FROM payments WHERE payment_id = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$payment_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getChat($send_id, $receive_id)
{
    global $db;
    $sql = "SELECT * FROM chat WHERE (send_id = :send_id and receive_id = :receive_id) or (receive_id = :send_id and send_id = :receive_id)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':send_id', $send_id);
    $stmt->bindValue(':receive_id', $receive_id);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);;
}

function insertUser($username, $password, $email, $payment_password, $avatar, $level)
{
    global $db;
    $sql = "INSERT INTO users (username, password,email,payment_password,avatar, user_level) VALUES(?, ?, ?, ?, ?, ?)";
    $stmt = $db->prepare($sql);
    $stmt->execute([$username, $password, $email, $payment_password, $avatar, $level]);
    $lastId = $db->lastInsertId();

    //insert users balance into currency table
    $sql = "INSERT INTO currency (user_id) VALUES(?)";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$lastId]);
}

function insertPayment($user_id, $receiver_id, $payment_id, $description, $amount, $currency, $payment_status)
{
    global $db;
    if ($receiver_id)
        $sql = "INSERT INTO payments(user_id, transfer_id, payment_id, description, amount, currency, payment_status) VALUES(:user_id, :transfer_id, :payment_id, :description, :amount, :currency, :payment_status)";
    else
        $sql = "INSERT INTO payments(user_id, payment_id, description, amount, currency, payment_status) VALUES(:user_id, :payment_id, :description, :amount, :currency, :payment_status)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    if ($receiver_id)
        $stmt->bindValue(':transfer_id', $receiver_id);
    $stmt->bindValue(':payment_id', $payment_id);
    $stmt->bindValue(':description', $description);
    $stmt->bindValue(':amount', $amount);
    $stmt->bindValue(':currency', $currency);
    $stmt->bindValue(':payment_status', $payment_status);
    return $stmt->execute();
}

function insertChat($send_id, $receive_id, $content)
{
    global $db;
    $sql = "INSERT INTO chat(send_id, receive_id, content) VALUES (?, ?, ?)";
    $stmt = $db->prepare($sql);
    return $stmt->execute([$send_id, $receive_id, $content]);
}

function updateUser($id, $username, $password, $email, $payment_password, $avatar, $level)
{
    global $db;
    $user = getUserInfoById($id);
    if (empty($password)) {
        $password = $user['password'];
    }
    if (empty($$payment_password)) {
        $payment_password = $user['payment_password'];
    }
    $sql = "UPDATE users SET username = :username, password = :password, email = :email, payment_password = :payment_password, avatar = :avatar, user_level = :user_level WHERE id = :user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':user_id', $id);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $password);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':payment_password', $payment_password);
    $stmt->bindValue(':avatar', $avatar);
    $stmt->bindValue(':user_level', $level);
    return $stmt->execute();
}

function updateBalance($user_id, $currency, $balance)
{
    global $db;
    $sql = "UPDATE currency SET " . $currency . " = :balance WHERE user_id = :user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':balance', $balance);
    $stmt->bindValue(':user_id', $user_id);
    return $stmt->execute();
}

function updateCurrency($user_id, $currency_from, $currency_to, $balance_from, $balance_to)
{
    global $db;
    $sql = "UPDATE currency SET " . $currency_from . "= :balance_from , " . $currency_to . "= :balance_to WHERE user_id= :user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':balance_from', $balance_from);
    $stmt->bindValue(':balance_to', $balance_to);
    $stmt->bindValue(':user_id', $user_id);
    return $stmt->execute();
}

?>