<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="../styles/registration_page_style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>

<div class="registration">
    <h1>Sign up</h1>
    <form id="registration-form" method="POST">

        <label>
            <input type="text" id="first_name" name="first_name" placeholder="First name" required
                   pattern="[A-Za-z\s]{1,255}" title="Only alphabetical characters allowed. Max 255 characters." />
        </label>

        <label>
            <input type="text" id="last_name" name="last_name" placeholder="Last name" required
                   pattern="[A-Za-z\s]{1,255}" title="Only alphabetical characters allowed. Max 255 characters." />
        </label>

        <label>
            <input type="text" id="username" name="username" placeholder="Username" required />
        </label>

        <label>
            <input type="email" id="email" name="email" placeholder="Email" required
                   pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" title="Please enter a valid email address." />
        </label>

        <label>
            <input type="text" id="photoUrl" name="photoUrl" placeholder="Photo Url" >
        </label>

        <label for="dateOfBirth">Date of birth</label>
        <input type="date" id="dateOfBirth" name="dateOfBirth" required />

        <label for="gender">Gender</label>
        <select id="gender" name="gender" required>
            <option value="">Select Gender</option>
            <option value="female">Female</option>
            <option value="male">Male</option>
        </select>

        <label>
            <input type="text" id="phone" name="phone" placeholder="Phone Number" required
                   pattern="\d+" title="Please enter a valid numeric phone number." />
        </label>

        <label>
            <input type="password" id="password" name="password" placeholder="Password" required />
        </label>

        <button type="submit">Register</button>
    </form>
</div>
</body>

<script>
    $(document).ready(function() {
        $('#registration-form').on('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            let data = {
                username: $('#username').val(),
                first_name: $('#first_name').val(),
                last_name: $('#last_name').val(),
                email: $('#email').val(),
                photoUrl: $('#photoUrl').val(),
                dateOfBirth: $('#dateOfBirth').val(),
                gender: $('#gender').val(),
                phone: $('#phone').val(),
                password: $('#password').val()
            };

            $.ajax({
                url: 'handlers/registration_handler.php',
                method: 'POST',
                data: data,
                success: function(response) {
                    if (response === 'success') {
                        alert('Registration successful! Redirecting to login page.');
                        window.location.href = '../pages/authorisation_page.php';
                    } else {
                        alert(response);
                    }
                },
                error: function() {
                    alert('An error occurred. Please try bla.');
                }
            });
        });
    });
</script>

</html>
