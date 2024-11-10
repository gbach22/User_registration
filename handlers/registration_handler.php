<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once '../db/UserDbManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $username = trim($_POST['username'] ?? '');
    $firstName = trim($_POST['first_name'] ?? '');
    $lastName = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $photoUrl = trim($_POST['photoUrl'] ?? '');
    $dateOfBirth = $_POST['dateOfBirth'] ?? '';
    $gender = $_POST['gender'] ?? '';
    $phone = trim($_POST['phone'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($username) || empty($firstName) || empty($lastName) || empty($email) || empty($dateOfBirth) || empty($gender) || empty($phone) || empty($password)) {
        echo 'All fields are required.';
        exit;
    }


    $userDbManager = new UserDbManager();

    $result = $userDbManager->registerUser($firstName, $lastName, $email, $photoUrl, $dateOfBirth, $gender, $phone, $password, $username, false);

    if ($result) {
        echo 'success';
    } else {
        echo 'Registration failed. Please try again.';
    }

} else {
    echo 'Invalid request';
}

