<?php
session_start();
require_once 'config.php'; // définit DB_HOST, DB_USER, DB_PASS, DB_NAME

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $motdepasse = trim($_POST['motdepasse'] ?? '');

    if (empty($email) || empty($motdepasse)) {
        $_SESSION['error'] = "Veuillez remplir tous les champs.";
        header("Location: ../HTML/login.html");
        exit;
    }

    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);

        $stmt = $pdo->prepare("SELECT idemployeur, motdepasse FROM employeur WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($motdepasse, $user['motdepasse'])) {
            $_SESSION['idemployeur'] = $user['idemployeur'];
            // ✅ Redirection ici
            header("Location: ../HTML/portailemployeur.html");
            exit;
        } else {
            $_SESSION['error'] = "Identifiants incorrects.";
            header("Location: ../HTML/login.html");
            exit;
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur de connexion à la base de données.";
        header("Location: ../HTML/login.html");
        exit;
    }
}
?>
