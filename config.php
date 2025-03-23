<?php
define('DB_SERVER', 'localhost'); // Adresse du serveur
define('DB_USERNAME', 'root'); // Nom d'utilisateur MySQL
define('DB_PASSWORD', ''); // Mot de passe MySQL
define('DB_NAME', 'prof_app'); // Nom de la base de données

$conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Vérifier la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
