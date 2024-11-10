<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Redirect non-admin users immediately
if (empty($_SESSION['username']) || empty($_SESSION['is_admin']) || $_SESSION['is_admin'] !== 1) {
    header("Location: user_home.php");
    exit();
}

require_once '../db/UserDbManager.php';

$userDbManager = new UserDbManager();

try {
    $nonAdminUsers = $userDbManager->getUsers();
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage();
    exit();
}

$username = htmlspecialchars($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Home</title>
    <link rel="stylesheet" href="../styles/admin_home_style.css">
</head>
<body>
<div class="container">
    <p>You are an admin, congratulations <?php echo $username; ?>!</p>

    <h2>Non-Admin Users</h2>
    <table>
        <thead>
        <tr>
            <th>Photo</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Date of Birth</th>
            <th>Gender</th>
            <th>Phone</th>
            <th>Username</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($nonAdminUsers)) : ?>
            <?php foreach ($nonAdminUsers as $user) : ?>
                <tr data-user-id="<?php echo htmlspecialchars($user['id']); ?>">
                    <td>
                        <img src="<?php echo htmlspecialchars($user['photoUrl']); ?>" alt="User Photo" class="user-photo">
                    </td>
                    <td><?php echo htmlspecialchars($user['first_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['dob']); ?></td>
                    <td><?php echo htmlspecialchars($user['gender']); ?></td>
                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td>
                        <button class="btn btn-make-admin" data-action="make_admin">Make Admin</button>
                        <button class="btn btn-remove-user" data-action="remove_user">Remove User</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="9">No non-admin users found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.btn').forEach(function (button) {
            button.addEventListener('click', function () {
                const userId = this.closest('tr').getAttribute('data-user-id');
                const action = this.getAttribute('data-action');
                const url = action === 'make_admin' ? '../handlers/make_admin_handler.php' : '../handlers/remove_user_handler.php';

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({ user_id: userId })
                })
                    .then(response => response.text())
                    .then(data => {
                        alert(data);
                        this.closest('tr').remove();
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            });
        });
    });

</script>
</body>
</html>