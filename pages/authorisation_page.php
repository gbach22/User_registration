<?php

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="../styles/authentication_page_style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>


<div class="authentication">
    <h1>Sign in</h1>
    <form id="authentication_form" method="POST">
        <label>
            <input type="text" name="emailOrUsername" placeholder="Email or Username" required />
        </label>

        <label>
            <input type="password" name="password" placeholder="Password" required />
        </label>

        <div class="admin-option">
            <h1>Authenticate as admin</h1>
            <label>
                <input type="checkbox" id="admin" name="isAdmin" />
            </label>
        </div>

        <button type="submit">Sign in</button>
    </form>

    <p>New to our web page? <a href="/pages/registration_page.php">Join now</a></p>
</div>

</body>

<script>
    $(document).ready(function() {
        $('#authentication_form').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            let emailOrUsername = $('input[name="emailOrUsername"]').val();
            let password = $('input[name="password"]').val();
            let isAdmin = $('#admin').is(':checked') ? 1 : 0;

            let data = {
                emailOrUsername: emailOrUsername,
                password: password,
                isAdmin: isAdmin
            };

            $.ajax({
                url: 'handlers/authentication_handler.php',
                method: 'POST',
                data: data,
                success: function(response) {
                    if (response === 'user_home') {
                        window.location.href = 'pages/user_home.php';
                    } else if (response === 'admin_home'){
                        window.location.href = 'pages/admin_home.php';
                    } else {
                        alert(response);
                    }
                },
                error: function() {
                    alert('An error occurred. Please try again.');
                }
            });
        });
    });
</script>


</html>
