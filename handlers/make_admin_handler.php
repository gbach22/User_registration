<?php

require_once '../db/UserDbManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id'])) {
        $user_id = $_POST['user_id'];
        $userDbManager = new UserDbManager();

        $result = $userDbManager->makeUserAdmin($user_id);

        if ($result) {
            echo "User has been granted admin status.";
        } else {
            echo "Failed to update admin status for '$user_id'. User may not exist.";
        }
    } else {
        echo 'Username is missing.';
    }
} else {
    echo 'Invalid request';
}

