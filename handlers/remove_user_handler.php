<?php

require_once '../db/UserDbManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        $userDbManager = new UserDbManager();

        $result = $userDbManager->removeUser($user_id);

        if ($result) {
            echo "User has been removed.";
        } else {
            echo "Failed to remove user for '$user_id'. User may not exist.";
        }
    } else {
        echo 'Username is missing.';
    }
} else {
    echo 'Invalid request';
}

