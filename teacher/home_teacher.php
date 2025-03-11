<?php
session_start();

// Include the database configuration file
include('../config.php');

// Check if the user is logged in as a professor
if (isset($_SESSION["id"]) && $_SESSION["role"] == "professor") {
    $id = $_SESSION["id"];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Professor</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- Navbar -->
<nav>
    <div class="navbar">
        <a href="#">Home</a>
        <?php if (isset($_SESSION["id"])): ?>
            <a href="../autentification/login.php" class="logout-btn">Logout</a>
        <?php endif; ?>
    </div>
</nav>

<!-- Display user ID -->
<h1>Welcome, Professor</h1>
<p>Your ID: <?php echo isset($id) ? $id : 'Not logged in'; ?></p>

</body>
</html>
