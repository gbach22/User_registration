<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);


session_start();
require_once '../authentication_strategies/AuthenticationContext.php';
require_once '../authentication_strategies/AdminAuthStrategy.php';
require_once '../authentication_strategies/RegularUserAuthStrategy.php';
require_once '../db/UserDbManager.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailOrUsername = trim($_POST['emailOrUsername'] ?? '');
    $password = $_POST['password'] ?? '';
    $isAdmin = isset($_POST['isAdmin']) && (bool)$_POST['isAdmin'];

    if (empty($emailOrUsername) || empty($password)) {
        echo 'Please provide both email/username and password.';
        exit;
    }


    $userDbManager = new UserDbManager();
    $authContext = new AuthenticationContext();

    if ($isAdmin) {
        $authContext->setStrategy(new AdminAuthStrategy($userDbManager));
    } else {
        $authContext->setStrategy(new RegularUserAuthStrategy($userDbManager));
    }

    $result = $authContext->authenticate($emailOrUsername, $password);
    echo $result;

} else {
    echo 'Invalid request';
}

