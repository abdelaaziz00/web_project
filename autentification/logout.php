<?php
session_start();
session_destroy(); // Détruit toutes les sessions
header("Location: login.php"); // Redirection vers la page de connexion
exit();
?>
