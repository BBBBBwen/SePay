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
        require 'data/HomePage.php';
        break;
    case '/login.php':
        require 'content/login.php';
        break;
    case '/register.php':
        require 'content/register.php';
        break;
    case '/logout.php':
        require 'data/logout.php';
        break;
    case '/Wallet.php':
        require 'data/Wallet.php';
        break;
    case '/TransactionHistory.php':
        require 'data/TransactionHistory.php';
        break;
    case '/pay_form.php':
        require 'data/pay_form.php';
        break;
    case '/charge.php':
        require 'data/charge.php';
        break;
    default:
        http_response_code(404);
        exit('Not Found');
}
# [END gae_simple_front_controller]
?>

