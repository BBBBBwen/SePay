<?php
require_once __DIR__."/vendor/autoload.php";
require __DIR__.'/connect_database.php';
use Omnipay\Omnipay;

$gateway = Omnipay::create('Stripe');
$gateway->setApiKey('sk_test_9GpQR1IV2CTZfjdovWhKbijy003FXhsyj3');
?>