<?php
require '../vendor/autoload.php'; // PHPMailer via Composer
require_once '../config/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Récupérer tous les utilisateurs
$stmt = $pdo->query("SELECT id, nom, email FROM users");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $utilisateur_id = $_POST['utilisateur_id'];
    $message = $_POST['message'];
    $type = $_POST['type'];
    $date_envoi = date('Y-m-d H:i:s');

    // Récupérer l'e-mail et le nom de l'utilisateur destinataire
    $stmtUser = $pdo->prepare("SELECT nom, email FROM users WHERE id = :id");
    $stmtUser->execute(['id' => $utilisateur_id]);
    $user = $stmtUser->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("Utilisateur non trouvé.");
    }

    $email = $user['email'];
    $nom = $user['nom'];

    // Enregistrer la notification
    $stmtNotif = $pdo->prepare("INSERT INTO notifications (utilisateur_id, message, type, date_envoi)
                                VALUES (:utilisateur_id, :message, :type, :date_envoi)");
    $stmtNotif->execute([
        'utilisateur_id' => $utilisateur_id,
        'message' => $message,
        'type' => $type,
        'date_envoi' => $date_envoi
    ]);

    // Envoi du mail avec PHPMailer
    $mail = new PHPMailer(true);
    try {
        // Configuration SMTP (à adapter à ton cas, ici Gmail par exemple)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'kd1807319@gmail.com'; // à remplacer
        $mail->Password = 'fper ohpx owvd vayk';    // à remplacer
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('ton.email@gmail.com', 'Event Manager');
        $mail->addAddress($email, $nom);

        $mail->isHTML(true);
        $mail->Subject = "Nouvelle notification : $type";
        $mail->Body = "
            <p>Bonjour <strong>$nom</strong>,</p>
            <p>Vous avez reçu une nouvelle notification :</p>
            <p><strong>Type :</strong> $type</p>
            <p><strong>Message :</strong> $message</p>
            <br>
            <p>Cordialement,<br>L'équipe SeneInnov</p>
        ";

        $mail->send();
        echo "✅ Notification envoyée et e-mail transmis à <strong>$email</strong>. <br><a href='notification.php'>Voir les notifications</a>";
    } catch (Exception $e) {
        echo "⚠️ Notification enregistrée, mais erreur lors de l'envoi de l'e-mail : {$mail->ErrorInfo}";
    }
}
?>

<!-- Formulaire HTML -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Envoyer une Notification</title>
</head>
<body>
    <h2>Envoyer une Notification</h2>
    <form action="send_notification.php" method="POST">
        <label for="utilisateur_id">Destinataire :</label>
        <select name="utilisateur_id" required>
            <option value="">-- Sélectionnez un utilisateur --</option>
            <?php foreach ($users as $user): ?>
                <option value="<?= $user['id']; ?>">
                    <?= htmlspecialchars($user['nom']) . " (" . htmlspecialchars($user['email']) . ")" ?>
                </option>
            <?php endforeach; ?>
        </select><br><br>

        <label for="type">Type :</label>
        <input type="text" name="type" required><br><br>

        <label for="message">Message :</label><br>
        <textarea name="message" rows="4" cols="40" required></textarea><br><br>

        <button type="submit">Envoyer la notification</button>
    </form>
</body>
</html>
<!-- Fin du code HTML -->
<!-- Fin du code PHP -->