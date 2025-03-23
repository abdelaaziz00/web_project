<?php
session_start();
include('../config.php');

// Vérifier si l'utilisateur est connecté en tant qu'étudiant
if (!isset($_SESSION["id"]) || $_SESSION["role"] != "student") {
    header("Location: ../autentification/login.php");
    exit();
}

// Vérifier si un ID de cours est passé dans l'URL
if (!isset($_GET['id_cour'])) {
    echo "Cours introuvable.";
    exit();
}

$id_cour = mysqli_real_escape_string($conn, $_GET['id_cour']);

// Récupérer les détails du cours
$sql = "SELECT c.SUJET, c.DESCRIPTION,c.SYLLABUS, p.NOM AS prof_nom
        FROM cour c
        JOIN professeur p ON c.ID2 = p.ID2
        WHERE c.ID_COUR = '$id_cour'";
        
$result = mysqli_query($conn, $sql);
$course = mysqli_fetch_assoc($result);

if (!$course) {
    echo "Cours non trouvé.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($course['SUJET']); ?></title>
    <style>
        /* Style général */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }

        /* Navigation */
        nav {
            background-color: #007bff;
            padding: 15px 0;
            text-align: center;
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
            font-weight: bold;
            padding: 10px 15px;
            transition: background 0.3s;
        }

        nav ul li a:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }

        /* Conteneur principal */
        .container {
            width: 80%;
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Titre du cours */
        h2 {
            text-align: center;
            color: #007bff;
        }

        /* Description du cours */
        p {
            line-height: 1.6;
            color: #555;
        }

        /* Professor */
        strong {
            color: #007bff;
        }

        /* Style pour la section syllabus */
        .syllabus {
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 8px;
            margin-top: 20px;
        }

        /* Footer */
        footer {
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: white;
            margin-top: 40px;
        }
    </style>
</head>
<body>

    <!-- Barre de navigation -->
    <nav>
        <ul>
            <li><a href="home_student.php">Home</a></li>
            <li><a href="mes_courses.php">Mes Cours</a></li>
            <li><a href="../autentification/login.php">Déconnexion</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2><?php echo htmlspecialchars($course['SUJET']); ?></h2>
        <p><strong>Description:</strong> <?php echo htmlspecialchars($course['DESCRIPTION']); ?></p>

        <div class="syllabus">
            <h3>Syllabus:</h3>
            <p><?php echo nl2br(htmlspecialchars($course['SYLLABUS'])); ?></p>
        </div>

        <p><strong>Professor:</strong> <?php echo htmlspecialchars($course['prof_nom']); ?></p>
    </div>

    <footer>
        <p>&copy; 2025 Tous droits réservés</p>
    </footer>

</body>
</html>
