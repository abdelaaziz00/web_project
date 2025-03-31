<?php
session_start();
require_once 'config.php'; // Fichier contenant les informations de connexion à la base de données

// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['course_id']) && isset($_POST['code'])) {
    $course_id = $_POST['course_id'];
    $code = $_POST['code'];
    $student_id = $_SESSION['student_id'];

    // Vérifier le code d'accès
    $query = "SELECT MDP_COURE FROM cour WHERE ID_COUR = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $course = $result->fetch_assoc();

    if ($course && password_verify($code, $course['MDP_COURE'])) {
        // Ajouter le cours à la liste de l'étudiant
        $query = "INSERT INTO inscription (ID_COUR, ID) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ii', $course_id, $student_id);
        $stmt->execute();

        $message = "Course added to your list successfully!";
        $message_type = "success";
    } else {
        $message = "Invalid code. Please try again.";
        $message_type = "error";
    }
} else {
    $message = "Error: Invalid request.";
    $message_type = "error";
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Course</title>
    <style>
        /* Style général */
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
            color: #333;
        }

        /* Barre de navigation */
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
            max-width: 600px;
            margin: 30px auto;
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #007bff;
        }

        /* Formulaire */
        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Boutons */
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            display: inline-block;
            text-align: center;
            width: 100%;
        }

        .btn:hover {
            background-color: #0056b3;
        }

        .btn-danger {
            background-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
        }

        /* Messages */
        .success {
            color: green;
            text-align: center;
        }

        .error {
            color: red;
            text-align: center;
        }

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
            <li><a href="profile.php">Mon Profil</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="../autentification/logout.php">Déconnexion</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Add Course</h2>

        <!-- Message de statut -->
        <?php if (isset($message)): ?>
            <p class="<?php echo $message_type; ?>"><?php echo $message; ?></p>
        <?php endif; ?>

        <!-- Formulaire de saisie du code -->
        <form method="POST" action="">
            <div class="form-group">
                <label for="course_id">Course ID:</label>
                <input type="text" name="course_id" id="course_id" required>
            </div>
            <div class="form-group">
                <label for="code">Cour Code:</label>
                <input type="password" name="code" id="code" required>
            </div>
            <button type="submit" class="btn">Ajouter dans mes cours</button>
        </form>
    </div>

    <footer>
        <p>&copy; 2025 Tous droits réservés</p>
    </footer>

</body>
</html>
