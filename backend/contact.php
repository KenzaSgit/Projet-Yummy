<?php
session_start();
require_once 'config.php'; // Doit contenir DB_HOST, DB_NAME, DB_USER, DB_PASS

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage des données
    $name = trim(filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS));
    $email = trim(filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL));
    $message = trim(filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS));

    $errors = [];

    // Vérification des champs
    if (empty($name)) {
        $errors[] = "Le nom est obligatoire.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse e-mail n'est pas valide.";
    }

    if (empty($message)) {
        $errors[] = "Le message ne peut pas être vide.";
    }

    if (empty($errors)) {
        try {
            // Connexion PDO à MySQL
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $pdo = new PDO($dsn, DB_USER, DB_PASS, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            // Insertion dans la base de données
            $stmt = $pdo->prepare("INSERT INTO avis (nom, email, message) VALUES (?, ?, ?)");
            $stmt->execute([$name, $email, $message]);

            // Message de succès
            $_SESSION['success'] = "Merci pour votre message !";
            header("Location: ../HTML/index.php"); // Rediriger vers la page principale
            exit;

        } catch (PDOException $e) {
            $_SESSION['errors'] = ["Erreur serveur : impossible d'enregistrer le message."];
            error_log("Erreur PDO : " . $e->getMessage());
            header("Location: ../HTML/index.php");
            exit;
        }
    } else {
        // En cas d'erreurs
        $_SESSION['errors'] = $errors;
        header("Location: index.php");
        exit;
    }
} else {
    // Accès interdit si pas en POST
    header("Location: index.php");
    exit;
}
?>
