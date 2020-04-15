<?php
require_once "vendor/autoload.php";

use Omnipay\Omnipay;

// Connect with the database
$db = new mysqli('localhost', 'root', 'root', 'SePay');

if ($db->connect_errno) {
    die("Connect failed: " . $db->connect_error);
}

$gateway = Omnipay::create('Stripe');
$gateway->setApiKey('sk_test_9GpQR1IV2CTZfjdovWhKbijy003FXhsyj3');