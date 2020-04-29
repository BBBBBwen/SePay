<?php
session_start();
/**
 * This is an example of a front controller for a flat file PHP site. Using a
 * Static list provides security against URL injection by default. See README.md
 * for more examples.
 */
# [START gae_simple_front_controller]
switch (@parse_url($_SERVER['REQUEST_URI'])['path']) {
    case '/':
        require 'Data/HomePage.php';
        break;
    case '/login.php':
        require 'Content/login.php';
        break;
    case '/register.php':
        require 'Content/register.php';
        break;
    case '/logout.php':
        require 'Data/logout.php';
        break;
    case '/Wallet.php':
        require 'Data/Wallet.php';
        break;
    case '/TransactionHistory.php':
        require 'Data/TransactionHistory.php';
        break;
    case '/pay_form.php':
        require 'Data/pay_form.php';
        break;
    case '/charge.php':
        require 'Data/charge.php';
        break;
    default:
        http_response_code(404);
        exit('Not Found');
}
# [END gae_simple_front_controller]
?>

