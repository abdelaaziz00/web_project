<?php
session_start();

// Inclusion de la configuration de la base de données
include('../config.php');

// Vérifier si l'utilisateur est connecté en tant qu'étudiant
if (isset($_SESSION["id"]) && $_SESSION["role"] == "student") {
    $id_etudiant = $_SESSION["id"];
    
    // Initialiser un tableau d'erreurs
    $errors = [];

    // Préparer la requête pour récupérer les informations de l'étudiant
    $sql = "SELECT * FROM etudiant WHERE ID = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if ($stmt === false) {
        $errors[] = "Erreur dans la préparation de la requête.";
        exit();
    }

    mysqli_stmt_bind_param($stmt, 'i', $id_etudiant);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $student = mysqli_fetch_assoc($result);

    if (!$student) {
        $errors[] = "Aucun étudiant trouvé.";
    }

    // Vérifier si l'étudiant a une image, sinon afficher une image par défaut
    $profile_image = !empty($student['PHOTO_PROFIL']) ? $student['PHOTO_PROFIL'] : 'default.jpg';

    // Traitement du téléchargement d'image
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_image'])) {
        // Vérifier si le fichier est valide
        $file_name = $_FILES['profile_image']['name'];
        $file_tmp = $_FILES['profile_image']['tmp_name'];
        $file_size = $_FILES['profile_image']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        // Types de fichiers autorisés
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_ext, $allowed_extensions)) {
            $errors[] = "Type de fichier non autorisé. Veuillez télécharger une image (jpg, jpeg, png, gif).";
        }

        if ($file_size > 2097152) { // 2 Mo max
            $errors[] = "Le fichier est trop volumineux. Veuillez télécharger une image de moins de 2 Mo.";
        }

        if (empty($errors)) {
            // Déplacer le fichier dans le répertoire uploads
            $new_file_name = $id_etudiant . '.' . $file_ext;
            $upload_dir = '../uploads/';
            $upload_file = $upload_dir . $new_file_name;

            if (move_uploaded_file($file_tmp, $upload_file)) {
                // Mettre à jour le nom de l'image dans la base de données
                $sql_update = "UPDATE etudiant SET PHOTO_PROFIL = ? WHERE ID = ?";
                $stmt_update = mysqli_prepare($conn, $sql_update);
                mysqli_stmt_bind_param($stmt_update, 'si', $new_file_name, $id_etudiant);
                mysqli_stmt_execute($stmt_update);

                // Mettre à jour l'image de profil
                $profile_image = $new_file_name;
            } else {
                $errors[] = "Une erreur est survenue lors du téléchargement de l'image.";
            }
        }
    }

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Étudiant</title>
    <style>
        /* Styles généraux */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f7fc; /* Fond blanc légèrement gris */
            color: #333;
        }

        nav {
            background-color: #87CEEB; /* Bleu ciel */
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

        .container {
            width: 80%;
            max-width: 900px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-header img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
        }

        .profile-header h2 {
            color: #87CEEB; /* Bleu ciel */
            margin-top: 10px;
        }

        .profile-details {
            margin-top: 30px;
        }

        .profile-details p {
            font-size: 16px;
            color: #555;
        }

        .profile-details p strong {
            color: #87CEEB; /* Bleu ciel */
        }

        .upload-form {
            margin-top: 30px;
            text-align: center;
        }

        .upload-form input[type="file"] {
            margin: 10px 0;
        }

        .upload-form input[type="submit"] {
            padding: 10px 20px;
            background-color: #87CEEB; /* Bleu ciel */
            color: white;
            border: none;
            cursor: pointer;
            font-size: 16px;
        }

        .upload-form input[type="submit"]:hover {
            background-color: #6495ED; /* Bleu plus foncé */
        }

        .errors {
            color: red;
            font-weight: bold;
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
        <div class="profile-header">
            <!-- Afficher l'image de l'étudiant, ou une image par défaut -->
            <img src="../uploads/<?php echo htmlspecialchars($profile_image); ?>" alt="Image de profil">
            <h2><?php echo htmlspecialchars($student['NOM']) . ' ' . htmlspecialchars($student['PRENOM']);  ?></h2>
        </div>

        <div class="profile-details">
            <p><strong>Email:</strong> <?php echo htmlspecialchars($student['EMAIL']); ?></p>
            <p><strong>Nom Complet:</strong> <?php echo htmlspecialchars($student['NOM']) . ' ' . htmlspecialchars($student['PRENOM']); ?></p>
            <p><strong>Numéro d'étudiant:</strong> <?php echo htmlspecialchars($student['ID']); ?></p>
        </div>

        <div class="upload-form">
            <h3>Changer l'image de profil</h3>
            <form action="profile.php" method="POST" enctype="multipart/form-data">
                <input type="file" name="profile_image" accept="image/*">
                <input type="submit" value="Télécharger l'image">
            </form>

            <?php
            if (!empty($errors)) {
                echo '<div class="errors">';
                foreach ($errors as $error) {
                    echo "<p>$error</p>";
                }
                echo '</div>';
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
