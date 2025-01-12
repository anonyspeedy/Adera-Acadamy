<?php
// Include the database connection file
include('db_config.php');

// Debugging: Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email']) && !isset($_POST['new_pass'])) {
        // Step 1: Handle email submission to check if it exists in the database
        $email = htmlspecialchars($_POST['email']);

        // Check if the email exists in the database
        $sql = "SELECT * FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Email found, show the password reset form
            $show_reset_form = true;
            $email_to_reset = $email; // Store the email for later use in password reset
        } else {
            // Email not found
            $error_message = "No user found with that email!";
        }
    } elseif (isset($_POST['new_pass']) && isset($_POST['confirm_pass'])) {
        // Step 2: Handle new password submission
        $email = htmlspecialchars($_POST['email']);
        $new_pass = htmlspecialchars($_POST['new_pass']);
        $confirm_pass = htmlspecialchars($_POST['confirm_pass']);

        // Check if the new password and confirm password match
        if ($new_pass !== $confirm_pass) {
            // Passwords do not match
            $error_message = "Passwords do not match!";
        } else {
            // Hash the new password before updating it
            $new_pass_hash = password_hash($new_pass, PASSWORD_DEFAULT);

            // Update the password in the database
            $update_sql = "UPDATE users SET password = ? WHERE email = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ss", $new_pass_hash, $email);

            if ($update_stmt->execute()) {
                // Successfully updated the password, redirect to login page
                header("Location: login.php"); // Redirect to the login page
                exit(); // Ensure no further code runs after redirection
            } else {
                // Error in updating the password
                $error_message = "An error occurred while updating your password!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset</title>
    <!-- Bootstrap 5.3.0-alpha1 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <h3 class="text-center mb-4">Reset Your Password</h3>

            <?php if (!isset($show_reset_form)): ?>
                <!-- Step 1: Email form -->
                <form action="password_reset.php" method="post">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required maxlength="50">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary w-100">Check Email</button>
                </form>
            <?php else: ?>
                <!-- Step 2: New Password form -->
                <form action="password_reset.php" method="post">
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" name="new_pass" id="new_password" class="form-control" placeholder="Enter your new password" required maxlength="20">
                    </div>
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm New Password</label>
                        <input type="password" name="confirm_pass" id="confirm_password" class="form-control" placeholder="Confirm your new password" required maxlength="20">
                    </div>
                    <button type="submit" name="submit" class="btn btn-primary w-100">Reset Password</button>
                </form>
            <?php endif; ?>

            <?php
                // Display error message if any
                if (isset($error_message)) {
                    echo "<p class='text-danger mt-3'>$error_message</p>";
                }
            ?>
        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>