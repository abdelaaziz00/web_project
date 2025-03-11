<?php
session_start();

// Include the database configuration file from the parent directory
include('../config.php');  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["email"]) && !empty($_POST["password"])) {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Create a connection to the database
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // Check the connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if the user is a student
        $query_student = "SELECT ID FROM etudiant WHERE EMAIL = ? AND mdp = ?";
        $stmt_student = $conn->prepare($query_student);
        $stmt_student->bind_param("ss", $email, $password);
        $stmt_student->execute();
        $result_student = $stmt_student->get_result();

        // Check if the user is a professor
        $query_prof = "SELECT ID2 FROM professeur WHERE EMAIL = ? AND mdp = ?";
        $stmt_prof = $conn->prepare($query_prof);
        $stmt_prof->bind_param("ss", $email, $password);
        $stmt_prof->execute();
        $result_prof = $stmt_prof->get_result();

        // Check if a student or professor exists with the provided email and password
        if ($result_student->num_rows > 0) {
            // User is a student
            $user = $result_student->fetch_assoc();
            $_SESSION["id"] = $user["ID"];
            $_SESSION["role"] = "student";
            header("Location: ../student/home_student.php");
            exit();
        } elseif ($result_prof->num_rows > 0) {
            // User is a professor
            $user = $result_prof->fetch_assoc();
            $_SESSION["id"] = $user["ID2"];
            $_SESSION["role"] = "professor";
            header("Location: ../teacher/home_teacher.php");
            exit();
        } else {
            // User does not exist
            echo "Aucun compte trouvé pour cet email.";
        }

        // Close the connection
        $stmt_student->close();
        $stmt_prof->close();
        $conn->close();
    }
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CvFit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="left-section">
            <img src="cvimg.png" alt="login" class="login-image">
        </div>
        <div class="right-section">
            <div class="header">
                <h2 class="title">Bienvenue sur CvFit</h2>
                <p class="subtitle">Connectez-vous à votre compte</p>
            </div>

            <div class="form">
                <form class="login-form" action="" method="POST">
                    <div class="input-group">
                        <img src="gmailimg.png" alt="email">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>

                    <div class="input-group">
                        <img src="lockimg.png" alt="password">
                        <input type="password" name="password" placeholder="Mot de passe" required>
                    </div>

                    <button type="submit" class="login-button">Connexion</button>
                </form>
            </div>

            <div class="separator">
                <hr>
                <span>Ou connectez-vous avec</span>
                <hr>
            </div>

            <button class="google-button">
                <img src="googleimg.png" alt="google">
                Connexion avec Google
            </button>
        </div>
    </div>
</body>
</html>
