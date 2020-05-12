<?php
$host = 'localhost';
$dbName = 'SePay';
$db_user = 'root';
$db_pass = 'root';
$dsn = "mysql:host=$host;port=3306;dbname=$dbName";
$db = new PDO($dsn, $db_user, $db_pass);

function getUserInfoById($user_id)
{
    global $db;
    $sql = "SELECT * FROM users WHERE id = :user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserInfoByEmail($email)
{
    global $db;
    $query = "SELECT * FROM users WHERE email= :email";
    $stmt = $db->prepare($query);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getUserBalance($user_id)
{
    global $db;
    $sql = "SELECT * FROM currency WHERE user_id = :user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getPayment($payment_id) {
    global $db;
    $sql = "SELECT * FROM payments WHERE payment_id = :payment_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':payment_id', $payment_id);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function insertUser($username, $password, $email, $payment_password, $avatar)
{
    global $db;
    $sql = "INSERT INTO users (username, password,email,payment_password,avatar)
  			      VALUES(:username, :password,:email,:payment_password,:avatar)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':username', $username);
    $stmt->bindValue(':password', $password);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':payment_password', $payment_password);
    $stmt->bindValue(':avatar', $avatar);
    $stmt->execute();
    $lastId = $db->lastInsertId();

    //insert users balance into currency table
    $sql = "INSERT INTO currency (user_id) VALUES(:user_id)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':user_id', $lastId);
    return $stmt->execute();
}

function insertPayment($user_id, $payment_id, $description, $amount, $currency, $payment_status) {
    global $db;
    $sql = "INSERT INTO payments(user_id, payment_id, description, amount, currency, payment_status) VALUES(:user_id, :payment_id, :description, :amount, :currency, :payment_status)";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->bindValue(':payment_id', $payment_id);
    $stmt->bindValue(':description', $description);
    $stmt->bindValue(':amount', $amount);
    $stmt->bindValue(':currency', $currency);
    $stmt->bindValue(':payment_status', $payment_status);
    return $stmt->execute();
}

function updateBalance($user_id, $currency, $balance) {
    global $db;
    $sql = "UPDATE currency SET ".$currency." = :balance WHERE user_id = :user_id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':balance', $balance);
    $stmt->bindValue(':user_id', $user_id);
    return $stmt->execute();
}
?>