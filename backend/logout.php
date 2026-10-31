<?php
session_start();
session_unset(); // Supprime les variables de session
session_destroy(); // Détruit la session

// Redirige vers la page d'accueil ou de login
header("Location: ../HTML/index.php");
exit();
?>
