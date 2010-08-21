<?php
chdir("..");
require_once 'init.php';

$authorized = false;

if (isset($argc) && $argc > 1) { // check for CLI credentials
    $session = new Session();
    $username = $argv[1];
    $pw = $argv[2];

    $od = DAOFactory::getDAO('OwnerDAO');
    $passcheck = $od->getPass($username);
    if ($session->pwdCheck($pw, $passcheck)) {
        $authorized = true;
        $_SESSION['user'] = $username;
    } else {
        echo "ERROR: Incorrect username and password.";
    }
} else { // check user is logged in on the web
    session_start();
    $session = new Session();
    if ($session->isLoggedIn()) {
        $authorized = true;
    } else {
        echo "ERROR: Invalid or missing username and password.";
    }
}

if ($authorized) {
    $crawler->crawl();
}
