<?php
require_once "vendor/autoload.php";

use Omnipay\Omnipay;

$gateway = Omnipay::create('Stripe');
$gateway->setApiKey('sk_test_9GpQR1IV2CTZfjdovWhKbijy003FXhsyj3');
?>