<?php
require_once "vendor/autoload.php";
require 'connect_database.php';

use Omnipay\Omnipay;

$gateway = Omnipay::create('Stripe');
$gateway->setApiKey('sk_test_9GpQR1IV2CTZfjdovWhKbijy003FXhsyj3');
?>