<?php

$request = $_SERVER['REQUEST_URI'];
$viewDir = '/pages/';

switch ($request) {
    case '':
    case '/authorisation':
    case '/':
        require __DIR__ . $viewDir . 'authorisation_page.php';
        break;

    case '/registration':
        require __DIR__ . $viewDir . 'registration_page.php';
        break;

    case '/admin_home':
        require __DIR__ . $viewDir . 'admin_home.php';
        break;

    case '/user_home':
        require __DIR__ . $viewDir . 'user_home.php';
        break;


    default:
        http_response_code(404);
        require __DIR__ . $viewDir . '404.php';
}