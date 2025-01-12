<?php
// Include the database connection file
include('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['pass']);

    // Prepare SQL query to fetch the user from the database
    $sql = "SELECT * FROM users WHERE email = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        // Check if the email exists in the database
        if ($result->num_rows > 0) {
            // Fetch the user data from the result
            $user = $result->fetch_assoc();
            
            // Verify the password
            if (password_verify($password, $user['password'])) {
                // Password is correct, login successful
                session_start();  // Start a session
                $_SESSION['user_id'] = $user['id'];  // Store user ID in session
                $_SESSION['user_name'] = $user['name'];  // Store user name in session
                $_SESSION['email'] = $user['email'];  // Store email in session

                // Redirect to home.html page after successful login
                header("Location: home.html");
                exit();
            } else {
                echo "<div class='alert alert-danger'>Invalid password!</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>No user found with that email!</div>";
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "<div class='alert alert-danger'>Database query failed!</div>";
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Bootstrap 5.3.0-alpha1 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <h3 class="text-center mb-4">Login Now</h3>

            <form action="index.php" method="post">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required maxlength="50">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="pass" id="password" class="form-control" placeholder="Enter your password" required maxlength="20">
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-100">Login Now</button>
            </form>

            <div class="text-center mt-3">
                <p>Don't have an account? <a href="register.php" class="text-primary">Register here</a></p>
                <p>Forgot your password? <a href="password_reset.php" class="text-primary">Reset password</a></p>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
