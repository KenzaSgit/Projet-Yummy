<?php
session_start();
require_once 'config.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Initialiser un tableau pour les erreurs
    $errors = [];

    // Récupérer et valider les données en échappant les chaînes (remplacement de FILTER_SANITIZE_STRING)
    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name']), ENT_QUOTES, 'UTF-8') : '';
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
    $phone = isset($_POST['phone']) ? preg_replace('/[^0-9]/', '', $_POST['phone']) : '';
    $date = isset($_POST['date']) ? $_POST['date'] : '';
    $time = isset($_POST['time']) ? $_POST['time'] : '';
    $guests = isset($_POST['guests']) ? intval($_POST['guests']) : 0;
    $occasion = isset($_POST['occasion']) ? htmlspecialchars(trim($_POST['occasion']), ENT_QUOTES, 'UTF-8') : null;
    $details = isset($_POST['special-requests']) ? htmlspecialchars(trim($_POST['special-requests']), ENT_QUOTES, 'UTF-8') : null;

    // Validation des données
    if (empty($name)) {
        $errors['name'] = "Le nom complet est requis";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'adresse email n'est pas valide";
    }

    if (strlen($phone) < 10) {
        $errors['phone'] = "Le numéro de téléphone doit contenir au moins 10 chiffres";
    }

    if (empty($date) || empty($time)) {
        $errors['datetime'] = "La date et l'heure sont requises";
    } else {
        $datetime = date('Y-m-d H:i:s', strtotime("$date $time"));
        if ($datetime === false) {
            $errors['datetime'] = "La date ou l'heure n'est pas valide";
        }
    }

    if ($guests < 1 || $guests > 20) {
        $errors['guests'] = "Le nombre de personnes doit être entre 1 et 20";
    }

    if (empty($errors)) {
        try {
            // Connexion à la base de données
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);

            // Vérifier la limite de réservations par email (max 3 dernières 24h)
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM reservation WHERE email = ? AND datereservation >= NOW() - INTERVAL 1 DAY");
            $stmt->execute([$email]);
            $count = $stmt->fetchColumn();

            if ($count > 3) {
                $errors['limit'] = "Vous avez atteint la limite de réservations pour aujourd'hui.";
            }

            // Vérifier la disponibilité si pas d'erreur de limite
            if (!isset($errors['limit'])) {
                $stmt = $pdo->prepare("SELECT SUM(nbpersonne) FROM reservation 
                                     WHERE DATE(datereservation) = DATE(?) 
                                     AND TIME(datereservation) BETWEEN TIME(?) - INTERVAL 2 HOUR AND TIME(?) + INTERVAL 2 HOUR");
                $stmt->execute([$datetime, $datetime, $datetime]);
                $total_guests = $stmt->fetchColumn();

                $max_capacity = 50; // Capacité maximale du restaurant

                if (($total_guests + $guests) > $max_capacity) {
                    $errors['capacity'] = "Désolé, nous n'avons plus de disponibilité pour cette date/heure. Veuillez choisir un autre créneau.";
                }
            }

            // Si toutes les vérifications sont OK, enregistrer la réservation
            if (empty($errors)) {
                // Requête d'insertion
                $stmt = $pdo->prepare("INSERT INTO reservation 
                                      (nomclient, email, numtel, datereservation, nbpersonne, occasion, detailsreservation) 
                                      VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $email, $phone, $datetime, $guests, $occasion, $details]);

                // Envoyer un email de confirmation
                sendConfirmationEmail($name, $email, $datetime, $guests);

                // Rediriger vers la page de remerciement
                header('Location: ../HTML/merci_reservation.html');
                exit;
            }

        } catch (PDOException $e) {
            $errors['database'] = "Une erreur est survenue lors de l'enregistrement. Veuillez réessayer.";
            error_log("Database error: " . $e->getMessage());
        }
    }

    // Si erreurs, les stocker en session et rediriger
    $_SESSION['reservation_errors'] = $errors;
    $_SESSION['reservation_data'] = $_POST;
    header('Location: ../index.html#reservation');
    exit;
}

// Fonction pour envoyer un email de confirmation
function sendConfirmationEmail($name, $email, $datetime, $guests) {
    $to = $email;
    $subject = "Confirmation de votre réservation chez " . SITE_NAME;

    $date_formatted = date('d/m/Y à H:i', strtotime($datetime));

    $message = "
    <html>
    <head>
        <title>Confirmation de réservation</title>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #f8f8f8; padding: 10px; text-align: center; }
            .content { padding: 20px; }
            .footer { margin-top: 20px; font-size: 0.9em; color: #777; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Merci pour votre réservation, $name!</h2>
            </div>
            <div class='content'>
                <p>Nous avons bien reçu votre demande de réservation pour le $date_formatted pour $guests personne(s).</p>
                <p>Notre équipe va traiter votre demande et vous confirmer la réservation sous peu.</p>
                <p>En cas de modification ou d'annulation, veuillez nous contacter au +213 789 01 23 70.</p>
            </div>
            <div class='footer'>
                <p>Cordialement,<br>L'équipe de " . SITE_NAME . "</p>
                <p>" . SITE_NAME . "<br>À côté de l'université Targa Ouzemmour, Béjaïa</p>
            </div>
        </div>
    </body>
    </html>
    ";

    // Pour envoyer un email HTML, il faut définir les bons headers
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: no-reply@" . $_SERVER['SERVER_NAME'] . "\r\n";

    mail($to, $subject, $message, $headers);
}
?>
