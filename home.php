<?php
session_start();

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Include the database connection file
require_once 'db_config.php';

// Retrieve user information from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT name, profile_image FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
$conn->close();

// Ensure user data is retrieved
$username = isset($user['name']) ? $user['name'] : 'Guest';
$profile_image = isset($user['profile_image']) ? $user['profile_image'] : 'uploads/default.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header class="header">
    <section class="flex">
        <a href="home.php" class="logo">Adera Academy</a>

        <form action="search.html" method="post" class="search-form">
            <input type="text" name="search_box" required placeholder="Search courses..." maxlength="100">
            <button type="submit" class="fas fa-search"></button>
        </form>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="search-btn" class="fas fa-search"></div>
            <div id="user-btn" class="fas fa-user"></div>
            <div id="toggle-btn" class="fas fa-sun"></div>
        </div>

        <div class="profile">
            <img src="<?php echo htmlspecialchars($profile_image); ?>" class="image" alt="Profile Picture">
            <h3 class="name"><?php echo htmlspecialchars($username); ?></h3>
            <p class="role">Student</p>
            <a href="profile.php" class="btn">View Profile</a>
            <div class="flex-btn">
                <a href="logout.php" class="option-btn">Logout</a>
            </div>
        </div>
    </section>
</header>

<!-- Sidebar -->
<div class="side-bar">
    <div id="close-btn">
        <i class="fas fa-times"></i>
    </div>

    <div class="profile">
        <img src="<?php echo htmlspecialchars($profile_image); ?>" class="image" alt="Profile Picture">
        <h3 class="name"><?php echo htmlspecialchars($username); ?></h3>
        <p class="role">Student</p>
        <a href="profile.php" class="btn">View Profile</a>
    </div>

    <nav class="navbar">
        <a href="home.php"><i class="fas fa-home"></i><span>Home</span></a>
        <a href="about.php"><i class="fas fa-question"></i><span>About</span></a>
        <a href="courses.php"><i class="fas fa-graduation-cap"></i><span>Courses</span></a>
        <a href="teachers.php"><i class="fas fa-chalkboard-user"></i><span>Teachers</span></a>
        <a href="contact.php"><i class="fas fa-headset"></i><span>Contact Us</span></a>
    </nav>
</div>

<!-- Main Content -->
<section class="home-grid">
    <h1 class="heading">Quick Options</h1>
    <div class="box-container">
        <!-- Your content here -->
    </div>
</section>

<footer class="footer">
    &copy; Copyright @ 2022 by <span>Mr. Web Designer</span> | All rights reserved!
</footer>

<script src="js/script.js"></script>
</body>
</html>