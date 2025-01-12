<?php
// Include the database connection file
include('db_config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['pass']);
    $confirm_password = htmlspecialchars($_POST['c_pass']);

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<div class='alert alert-danger'>Passwords do not match!</div>";
        exit();
    }

    // Hash the password for security
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Handle file upload (Profile image)
    $profile_image = $_FILES['profile']['name'];
    $profile_image_tmp = $_FILES['profile']['tmp_name'];
    $target_directory = "uploads/";
    $target_file = $target_directory . basename($profile_image);

    // Check if file is a valid image
    if (getimagesize($profile_image_tmp) === false) {
        echo "<div class='alert alert-danger'>File is not an image.</div>";
        exit();
    }

    // Check if the image is too large (max size: 5MB)
    if ($_FILES['profile']['size'] > 5 * 1024 * 1024) {
        echo "<div class='alert alert-danger'>Sorry, your file is too large. Maximum file size is 5MB.</div>";
        exit();
    }

    // Allow only specific image formats (JPG, PNG, JPEG)
    $image_file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($image_file_type != "jpg" && $image_file_type != "jpeg" && $image_file_type != "png") {
        echo "<div class='alert alert-danger'>Sorry, only JPG, JPEG, and PNG files are allowed.</div>";
        exit();
    }

    // Move the uploaded file to the server directory
    if (!move_uploaded_file($profile_image_tmp, $target_file)) {
        echo "<div class='alert alert-danger'>Sorry, there was an error uploading your file.</div>";
        exit();
    }

    // Prepare SQL query to insert user data
    $sql = "INSERT INTO users (name, email, password, profile_image) VALUES (?, ?, ?, ?)";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $target_file);

    // Execute the query and check for success
    if ($stmt->execute()) {
        echo "<div class='alert alert-success'>Registration successful! <a href='index.php'>Login here</a></div>";
        // Redirect to login page
        header("Location: index.php");
        exit(); // Make sure no further code runs after redirect
    } else {
        echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
    }

    // Close the connection
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Register</title>

   <!-- Bootstrap 5.3.0-alpha1 CDN -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center min-vh-100">

    <div class="card shadow-lg" style="width: 100%; max-width: 400px;">
        <div class="card-body">
            <h3 class="text-center mb-4">Register Now</h3>

            <form action="register.php" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name" required maxlength="50">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email" required maxlength="50">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="pass" id="password" class="form-control" placeholder="Enter your password" required maxlength="20">
                </div>
                <div class="mb-3">
                    <label for="c_password" class="form-label">Confirm Password</label>
                    <input type="password" name="c_pass" id="c_password" class="form-control" placeholder="Confirm your password" required maxlength="20">
                </div>
                <div class="mb-3">
                    <label for="profile" class="form-label">Profile Image</label>
                    <input type="file" name="profile" id="profile" class="form-control" accept="image/*" required>
                </div>
                <button type="submit" name="submit" class="btn btn-primary w-100">Register</button>
            </form>

            <div class="text-center mt-3">
                <p>Already have an account? <a href="login.php" class="text-primary">Login here</a></p>
            </div>
        </div>
    </div>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
