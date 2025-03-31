<?php
session_start();
include('../config.php');

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION["id"])) {
    header("Location: ../autentification/login.php");
    exit();
}

// Récupérer l'ID de l'utilisateur
$user_id = $_SESSION["id"];

// Connexion à la base de données avec PDO
try {
    $pdo = new PDO("mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupérer le nom de l'étudiant
$student_query = "SELECT NOM FROM etudiant WHERE ID = :user_id";
$stmt_student = $pdo->prepare($student_query);
$stmt_student->execute([':user_id' => $user_id]);
$student = $stmt_student->fetch(PDO::FETCH_ASSOC);
$student_name = $student['NOM'];

// Récupérer la liste des professeurs
$prof_query = "SELECT ID2, NOM FROM professeur";
$prof_result = $pdo->query($prof_query);

// Traitement du formulaire d'envoi de message
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST["professor_id"]) && !empty($_POST["message"])) {
        $student_id = $user_id; 
        $professor_id = $_POST["professor_id"];
        $message = htmlspecialchars($_POST["message"]); 

        try {
            // Insertion du message dans la table contact
            $stmt = $pdo->prepare("INSERT INTO contact (ID, ID2, NOM, MESSAGE) VALUES (:student_id, :professor_id, :student_name, :message)");
            $stmt->execute([
                ':student_id' => $student_id,
                ':professor_id' => $professor_id,
                ':message' => $message,
                ':student_name' => $student_name 
            ]);
            echo "<script>alert('Message envoyé avec succès !');</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Erreur lors de l\'envoi du message : " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Veuillez remplir tous les champs.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - CvFit</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Style général */
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background: linear-gradient(to right, rgb(86, 176, 201), #ffffff);
    color: #333;
}

/* Barre de navigation */
nav {
    background-color: #87CEEB; /* Bleu ciel */
    padding: 15px 0;
    text-align: center;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

nav ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: center;
}

nav ul li {
    margin: 0 20px;
}

nav ul li a {
    text-decoration: none;
    color: white;
    font-weight: 500;
    padding: 10px 20px;
    transition: background 0.3s;
    border-radius: 4px;
}

nav ul li a:hover {
    background-color: rgba(255, 255, 255, 0.2);
}

/* Conteneur principal */
.contact-container {
    width: 50%;
    margin: 50px auto;
    padding: 30px;
    background: white;
    border-radius: 8px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

/* Titre de la page */
h2 {
    color: rgb(61, 125, 244); /* Bleu ciel */
    font-size: 32px;
    margin-bottom: 20px;
    text-align: center;
}

/* Section des champs de saisie */
.input-group {
    margin-bottom: 20px;
}

.input-group label {
    font-size: 14px;
    margin-bottom: 5px;
    color: #555;
}

.input-group select,
.input-group textarea {
    width: 100%;
    padding: 10px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 5px;
    background-color: #fafafa;
    color: #333;
}

.input-group select:focus,
.input-group textarea:focus {
    border-color: #87CEEB;
    outline: none;
}

/* Bouton de soumission */
.contact-button {
    width: 100%;
    padding: 12px;
    background-color: rgb(61, 125, 244); /* Bleu ciel */
    color: white;
    font-size: 16px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.contact-button:hover {
    background-color: #6495ED; /* Bleu plus foncé */
}

/* Pied de page */
.footer {
    text-align: center;
    padding: 20px;
    color: white;
    font-size: 14px;
    margin-top: 40px;
}

    </style>
</head>
<body>

    <!-- Barre de navigation -->
    <nav>
        <ul>
            <li><a href="home_student.php">Accueil</a></li>
            <li><a href="mes_courses.php">Mes Cours</a></li>
            <li><a href="profile.php">Mon Profil</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="../autentification/logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <!-- Conteneur principal -->
    <div class="contact-container">
        <h2>Envoyer un message à un professeur</h2>

        <!-- Afficher le nom de l'étudiant -->
        <p><strong>Nom de l'étudiant :</strong> <?= htmlspecialchars($student_name) ?></p>

        <!-- Formulaire de contact -->
        <form action="" method="POST">
            
            <!-- Sélection du professeur -->
            <div class="input-group">
                <label for="professor_id">Choisir un professeur :</label>
                <select name="professor_id" required>
                    <option value="">Sélectionner un professeur</option>
                    <?php while ($prof = $prof_result->fetch(PDO::FETCH_ASSOC)): ?>
                        <option value="<?= htmlspecialchars($prof['ID2']) ?>">
                            <?= htmlspecialchars($prof['NOM']) ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <!-- Champ du message -->
            <div class="input-group">
                <label for="message">Message :</label>
                <textarea name="message" rows="5" placeholder="Écrivez votre message..." required></textarea>
            </div>

            <!-- Bouton pour envoyer le message -->
            <button type="submit" class="contact-button">Envoyer</button>
        </form>
    </div>

    

</body>
</html>
