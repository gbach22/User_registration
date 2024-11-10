<?php
session_start();

// Check if the user is logged in
if (empty($_SESSION['username'])) {
    // Redirect to login page if not logged in
    header("Location: ../index.php");
    exit();
}

require_once '../db/UserDbManager.php';

$userDbManager = new UserDbManager();
$user = $userDbManager->getUserByUsername($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Page</title>
    <link rel="stylesheet" href="../styles/user_home_style.css">
</head>
<body>
<div class="container">
    <h2>Welcome, <?php echo htmlspecialchars($user['first_name']) . " " . htmlspecialchars($user['last_name']); ?>!</h2>
    <p>You are a regular user, congratulations!</p>

    <h3>Your Information</h3>
    <table>
        <tr>
            <th>First Name</th>
            <td><?php echo htmlspecialchars($user['first_name']); ?></td>
        </tr>
        <tr>
            <th>Last Name</th>
            <td><?php echo htmlspecialchars($user['last_name']); ?></td>
        </tr>
        <tr>
            <th>Email</th>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
        </tr>
        <tr>
            <th>Date of Birth</th>
            <td><?php echo htmlspecialchars($user['dob']); ?></td>
        </tr>
        <tr>
            <th>Gender</th>
            <td><?php echo htmlspecialchars($user['gender']); ?></td>
        </tr>
        <tr>
            <th>Phone</th>
            <td><?php echo htmlspecialchars($user['phone']); ?></td>
        </tr>
        <tr>
            <th>Username</th>
            <td><?php echo htmlspecialchars($user['username']); ?></td>
        </tr>
        <tr>
            <th>Password (hashed)</th>
            <td><?php echo htmlspecialchars($user['password']); ?></td>
        </tr>
    </table>
</div>
</body>
</html>
