<?php
session_start();

// Inclusion de la configuration de la base de données
include('../config.php');

// Vérifier si l'utilisateur est connecté en tant qu'étudiant
if (isset($_SESSION["id"]) && $_SESSION["role"] == "student") {
    $id_etudiant = $_SESSION["id"];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil Étudiant</title>
    <style>
        /* Styles généraux */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: white; /* Fond blanc pour la page */
            color: #333;
        }

        /* Barre de navigation */
        nav {
            background-color: #A1E3F9; /* Bleu clair pour la barre de navigation */
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
            width: 90%;
            max-width: 1000px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        /* Titre */
        h2 {
            text-align: center;
            color: #A1E3F9; /* Bleu clair pour le titre */
            margin-bottom: 20px;
        }

        /* Section des cours */
        .courses {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        /* Carte d'un cours */
        .course {
            background: #fff;
            padding: 20px;
            width: 300px;
            border-radius: 8px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
            text-align: center;
        }

        .course:hover {
            transform: translateY(-5px);
        }

        .course h3 {
            color: #A1E3F9; /* Bleu clair pour les titres des cours */
        }

        .course p {
            color: #555;
        }

        /* Bouton "Voir plus" */
        .btn-primary {
            display: inline-block;
            background-color: #A1E3F9; /* Bleu clair pour les boutons */
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background-color: #7CC1D6; /* Un peu plus foncé au survol */
        }

        /* Messages */
        .success {
            color: #28a745;
            font-weight: bold;
            text-align: center;
        }

        .error {
            color: #dc3545;
            font-weight: bold;
            text-align: center;
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
            <li><a href="../autentification/login.php">Déconnexion</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Les Cours Disponibles</h2>

        <div class="courses">
            <?php
            // Récupérer tous les cours postés par les professeurs
            $sql = "SELECT c.ID_COUR, c.SUJET, c.DESCRIPTION, p.NOM AS prof_nom
                    FROM cour c
                    JOIN professeur p ON c.ID2 = p.ID2";

            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="course">
                        <h3><?php echo htmlspecialchars($row['SUJET']); ?></h3>
                        <p><?php echo htmlspecialchars($row['DESCRIPTION']); ?></p>
                        <p><strong>Professeur:</strong> <?php echo htmlspecialchars($row['prof_nom']); ?></p>
                        <a href="course_detail.php?id_cour=<?php echo $row['ID_COUR']; ?>" class="btn-primary">Voir plus</a>
                    </div>
            <?php
                }
            } else {
                echo "<p>Aucun cours disponible.</p>";
            }
            ?>
        </div>
    </div>

</body>
</html>
<?php
} else {
    echo "Vous devez être connecté en tant qu'étudiant pour accéder à cette page.";
}
?>
