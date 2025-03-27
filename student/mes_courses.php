<?php
session_start();
include('../config.php');

// Vérifier si l'utilisateur est connecté en tant qu'étudiant
if (isset($_SESSION["id"]) && $_SESSION["role"] == "student") {
    $id_etudiant = $_SESSION["id"];
    
    // Récupérer les cours auxquels l'étudiant est inscrit
    $sql = "SELECT c.ID_COUR, c.SUJET, c.DESCRIPTION, p.NOM AS prof_nom
            FROM cour c
            JOIN professeur p ON c.ID2 = p.ID2
            JOIN inscription i ON c.ID_COUR = i.ID_COUR
            WHERE i.ID = '$id_etudiant'";
    
    $result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Cours</title>
    <style>
        /* Style général */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(to right, #dfe9f3, #ffffff);
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

        /* Titre de la section */
        h2 {
            text-align: center;
            color: #007bff;
            margin-bottom: 20px;
        }

        /* Cours */
        .courses {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

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
            color: #007bff;
        }

        .course p {
            color: #555;
        }

        /* Boutons */
        .btn {
            text-decoration: none;
            padding: 8px 15px;
            color: white;
            border-radius: 5px;
            display: inline-block;
            font-size: 14px;
        }

        .btn-primary {
            background-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
            border: none;
            cursor: pointer;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        /* Conteneur pour les boutons */
        .button-group {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-top: 10px;
        }

        /* Message d'erreur */
        .error {
            color: red;
            font-size: 16px;
            text-align: center;
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
            <li><a href="home_student.php">Accueil</a></li>
            <li><a href="mes_courses.php">Mes Cours</a></li>
            <li><a href="profile.php">Mon Profil</a></li>
            <li><a href="../autentification/login.php">Déconnexion</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Mes Cours</h2>

        <div class="courses">
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
            ?>
                    <div class="course">
                        <h3><?php echo htmlspecialchars($row['SUJET']); ?></h3>
                        <p><?php echo htmlspecialchars($row['DESCRIPTION']); ?></p>
                        <p><strong>Professeur:</strong> <?php echo htmlspecialchars($row['prof_nom']); ?></p>
                        <div class="button-group">
                            <a href="course_detail.php?id_cour=<?php echo $row['ID_COUR']; ?>" class="btn btn-primary">Voir plus</a>
                            <form method="POST" action="">
                                <input type="hidden" name="id_cour" value="<?php echo $row['ID_COUR']; ?>">
                                <button type="submit" name="remove_course" class="btn btn-danger">Se désinscrire</button>
                            </form>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "<p class='error'>Vous n'êtes inscrit à aucun cours.</p>";
            }
            ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Tous droits réservés</p>
    </footer>

</body>
</html>

<?php
    // Gérer la désinscription d’un cours
    if (isset($_POST['remove_course'])) {
        $id_cour = mysqli_real_escape_string($conn, $_POST['id_cour']);

        // Supprimer l'inscription
        $delete_query = "DELETE FROM inscription WHERE ID_COUR = '$id_cour' AND ID = '$id_etudiant'";
        if (mysqli_query($conn, $delete_query)) {
            echo "<script>alert('Vous avez été désinscrit du cours.'); window.location.href='mes_courses.php';</script>";
        } else {
            echo "<p class='error'>Erreur lors de la désinscription.</p>";
        }
    }

} else {
    echo "Vous devez être connecté en tant qu'étudiant pour accéder à cette page.";
}
?>
