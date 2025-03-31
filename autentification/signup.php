<?php
session_start();
include('../config.php');  

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["email"]) && !empty($_POST["password"]) && !empty($_POST["name"]) && !empty($_POST["prenom"]) && !empty($_POST["role"])) {
        $name = $_POST["name"];
        $prenom = $_POST["prenom"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $role = $_POST["role"];

        // Connexion à la base de données
        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($role == "student") {
            $query = "INSERT INTO etudiant (NOM, PRENOM, EMAIL, mdp) VALUES (?, ?, ?, ?)";
        } else {
            $query = "INSERT INTO professeur (NOM, PRENOM, EMAIL, mdp) VALUES (?, ?, ?, ?)";
        }

        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssss", $name, $prenom, $email, $password);
        
        if ($stmt->execute()) {
            echo "Compte créé avec succès !";
            header("Location: login.php");
            exit();
        } else {
            echo "Erreur lors de l'inscription.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - CvFit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="login-container">
        <div class="left-section">
            <img src="cvimg.png" alt="signup" class="login-image">
        </div>
        <div class="right-section">
            <div class="header">
                <h2 class="title">Créer un compte</h2>
                <p class="subtitle">Rejoignez CvFit dès maintenant</p>
            </div>

            <div class="form">
                <form class="login-form" action="" method="POST">
                    <div class="input-group">
                        <img src="userimg.png" alt="name">
                        <input type="text" name="name" placeholder="Nom" required>
                    </div>

                    <div class="input-group">
                        <img src="userimg.png" alt="prenom">
                        <input type="text" name="prenom" placeholder="Prénom" required>
                    </div>

                    <div class="input-group">
                        <img src="gmailimg.png" alt="email">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>

                    <div class="input-group">
                        <img src="lockimg.png" alt="password">
                        <input type="password" name="password" placeholder="Mot de passe" required>
                    </div>

                    <div class="input-group">
                        <select name="role" required>
                            <option value="">Sélectionner un rôle</option>
                            <option value="student">Étudiant</option>
                            <option value="professor">Professeur</option>
                        </select>
                    </div>

                    <button type="submit" class="login-button">S'inscrire</button>
                </form>
            </div>

            <div class="separator">
                <hr>
                <span>Ou inscrivez-vous avec</span>
                <hr>
            </div>

            <button class="google-button">
                <img src="googleimg.png" alt="google">
                S'inscrire avec Google
            </button>

            <p class="switch-form">Déjà un compte ? <a href="login.php">Connectez-vous</a></p>
        </div>
    </div>
</body>
</html>
