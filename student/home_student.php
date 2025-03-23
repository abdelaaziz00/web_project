<?php
session_start();

// Include the database configuration file
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
            color: #007bff;
        }

        /* Cours */
        .course {
            background: #fff;
            padding: 20px;
            margin: 15px 0;
            border-radius: 8px;
            box-shadow: 0px 3px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }

        .course:hover {
            transform: translateY(-3px);
        }

        .course h3 {
            color: #007bff;
        }

        .course p {
            color: #555;
        }

        /* Bouton Read More */
        .btn-primary {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 14px;
            transition: background 0.3s;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        /* Formulaire d'ajout */
        .add-course-form {
            margin-top: 10px;
        }

        .add-course-form input {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-right: 5px;
        }

        .add-course-form button {
            padding: 8px 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-course-form button:hover {
            background-color: #218838;
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
            <li><a href="home_student.php">Home</a></li>
            <li><a href="mes_courses.php">Mes Cours</a></li>
            <li><a href="../autentification/login.php">Déconnexion</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Les Cours</h2>

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
                    <p><strong>Professor:</strong> <?php echo htmlspecialchars($row['prof_nom']); ?></p>
                    <a href="course_detail.php?id_cour=<?php echo $row['ID_COUR']; ?>" class="btn btn-primary">Voir plus</a>
                    
                    <form method="POST" action="" class="add-course-form">
                        <label for="course_code">Entrer le code :</label>
                        <input type="text" id="course_code" name="course_code" required>
                        <input type="hidden" name="id_cour" value="<?php echo $row['ID_COUR']; ?>">
                        <button type="submit" name="add_course">Ajouter dans mes cours</button>
                    </form>
                </div>
                <?php
            }
        } else {
            echo "<p>No courses available.</p>";
        }
        ?>

    </div>

</body>
</html>
<?php

    // Gérer l'ajout d'un cours
    if (isset($_POST['add_course'])) {
        $course_code = mysqli_real_escape_string($conn, $_POST['course_code']);
        $id_cour = mysqli_real_escape_string($conn, $_POST['id_cour']);

        // Vérifier le code du cours
        $query = "SELECT MDP_COURE FROM cour WHERE ID_COUR = '$id_cour'";
        $course_result = mysqli_query($conn, $query);
        $course = mysqli_fetch_assoc($course_result);

        if ($course_code == $course['MDP_COURE']) {
            // Vérifier si l'étudiant est déjà inscrit
            $check_query = "SELECT * FROM inscription WHERE ID_COUR = '$id_cour' AND ID = '$id_etudiant'";
            $check_result = mysqli_query($conn, $check_query);

            if (mysqli_num_rows($check_result) == 0) {
                // Ajouter le cours
                $insert_query = "INSERT INTO inscription (ID_COUR, ID) VALUES ('$id_cour', '$id_etudiant')";
                if (mysqli_query($conn, $insert_query)) {
                    echo "<p class='success'>Course added to your list successfully!</p>";
                } else {
                    echo "<p class='error'>Error adding course. Please try again.</p>";
                }
            } else {
                echo "<p class='error'>You are already enrolled in this course.</p>";
            }
        } else {
            echo "<p class='error'>Incorrect course code.</p>";
        }
    }
} else {
    echo "You must be logged in as a student to access this page.";
}
?>
