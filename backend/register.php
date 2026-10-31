<?php
require_once 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO employeur (email, motdepasse) VALUES (?, ?)");
        $stmt->execute([$email, $hash]);

        header("Location: ../HTML/login.html?success=1");
        exit;
    } catch (PDOException $e) {
        header("Location: ../HTML/register.html?error=1");
        exit;
    }
}
?>