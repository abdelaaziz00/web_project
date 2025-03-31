<?php
session_start();
include('../config.php');

// Vérifier si l'utilisateur est connecté en tant qu'étudiant
if (!isset($_SESSION["id"]) || $_SESSION["role"] != "student") {
    header("Location: ../autentification/login.php");
    exit();
}

$id_etudiant = $_SESSION["id"];

// Vérifier si un ID de cours est passé dans l'URL
if (!isset($_GET['id_cour'])) {
    echo "Cours introuvable.";
    exit();
}

$id_cour = mysqli_real_escape_string($conn, $_GET['id_cour']);

// Récupérer les détails du cours
$sql = "SELECT c.SUJET, c.DESCRIPTION, c.SYLLABUS, c.MDP_COURE, p.NOM AS prof_nom
        FROM cour c
        JOIN professeur p ON c.ID2 = p.ID2
        WHERE c.ID_COUR = '$id_cour'";

$result = mysqli_query($conn, $sql);
$course = mysqli_fetch_assoc($result);

if (!$course) {
    echo "Cours non trouvé.";
    exit();
}

// Vérifier si l'étudiant est déjà inscrit à ce cours
$check_query = "SELECT * FROM inscription WHERE ID_COUR = '$id_cour' AND ID = '$id_etudiant'";
$check_result = mysqli_query($conn, $check_query);
$is_enrolled = mysqli_num_rows($check_result) > 0;

// Gérer l'ajout d'un cours
$success_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_course']) && !$is_enrolled) {
    $course_code = mysqli_real_escape_string($conn, $_POST['course_code']);

    if ($course_code == $course['MDP_COURE']) {
        // Ajouter le cours
        $insert_query = "INSERT INTO inscription (ID_COUR, ID) VALUES ('$id_cour', '$id_etudiant')";
        if (mysqli_query($conn, $insert_query)) {
            $success_message = "Cours ajouté avec succès !";
            $is_enrolled = true; // Mettre à jour la variable pour éviter l'affichage du formulaire
        } else {
            $error_message = "Erreur lors de l'ajout du cours. Veuillez réessayer.";
        }
    } else {
        $error_message = "Code du cours incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['SUJET']); ?></title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        /* Style général */
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, rgb(86, 176, 201), #ffffff); /* Même couleur de fond que home_student.php */
            color: #333;
            display: flex;
            flex-direction: column;
            height: 100vh; /* Utiliser la hauteur complète de la fenêtre */
        }

        /* Barre de navigation */
        nav {
            background-color: linear-gradient(to right, rgb(86, 176, 201), #ffffff); /* Même dégradé */
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
        .container {
            width: 80%;
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            flex: 1; /* Permet au contenu de prendre l'espace restant */
        }

        /* Titre et contenu du cours */
        h2 {
            color: #007bff; /* Bleu pour le titre */
            font-size: 32px;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
        }

        .syllabus {
            background-color: #f8f8f8;
            padding: 20px;
            border-radius: 8px;
            margin-top: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Messages */
        .success {
            color: #28a745;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }

        .error {
            color: #dc3545;
            font-weight: bold;
            text-align: center;
            margin: 20px 0;
        }

        /* Formulaire d'inscription */
        .add-course-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 30px;
        }

        .add-course-form input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 5px;
            transition: border-color 0.3s;
        }

        .add-course-form input:focus {
            border-color: #007bff; /* Bleu pour le focus */
        }

        .add-course-form button {
            padding: 12px;
            background-color: #007bff; /* Bleu pour le bouton */
            color: white;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .add-course-form button:hover {
            background-color: #0056b3; /* Bleu foncé pour le survol */
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 20px;
            background-color: linear-gradient(to right, rgb(86, 176, 201), #ffffff); /* Footer bleu */
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

    <div class="container">
        <h2><?php echo htmlspecialchars($course['SUJET']); ?></h2>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($course['DESCRIPTION']); ?></p>

        <div class="syllabus">
            <h3>Syllabus:</h3>
            <p><?php echo nl2br(htmlspecialchars($course['SYLLABUS'])); ?></p>
        </div>

        <p><strong>Professeur:</strong> <?php echo htmlspecialchars($course['prof_nom']); ?></p>

        <?php if ($success_message): ?>
            <p class="success"><?php echo $success_message; ?></p>
        <?php elseif ($error_message): ?>
            <p class="error"><?php echo $error_message; ?></p>
        <?php endif; ?>

        <!-- Afficher le formulaire SEULEMENT si l'étudiant n'est pas déjà inscrit -->
        <?php if (!$is_enrolled): ?>
            <form method="POST" action="" class="add-course-form">
                <label for="course_code">Entrer le code :</label>
                <input type="text" id="course_code" name="course_code" required>
                <button type="submit" name="add_course">Ajouter dans mes cours</button>
            </form>
        <?php else: ?>
            <p class="success">Vous êtes déjà inscrit à ce cours.</p>
        <?php endif; ?>
    </div>

    <footer>
        <p>&copy; 2025 Tous droits réservés</p>
    </footer>

</body>
</html>
