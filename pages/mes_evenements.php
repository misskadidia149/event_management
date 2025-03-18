<?php
session_start();
require_once "../config/db.php";

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté pour voir vos événements.");
}

$user_id = $_SESSION['user_id'];

// Récupérer les événements auxquels l'utilisateur est inscrit
$sql = "SELECT e.titre, e.lieu, e.date_debut FROM events e 
        JOIN register r ON e.id = r.evenement_id 
        WHERE r.utilisateur_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$evenements = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Mes Événements</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">📅 Mes Événements</h2>
    <?php if (empty($evenements)) : ?>
        <p class="text-center">Vous n'êtes inscrit à aucun événement.</p>
    <?php else : ?>
        <div class="row">
            <?php foreach ($evenements as $event) : ?>
                <div class="col-md-4">
                    <div class="card event-card p-3">
                        <h5 class="card-title"><?= htmlspecialchars($event['titre']) ?></h5>
                        <p class="text-muted">📍 <?= htmlspecialchars($event['lieu']) ?> | 📅 <?= htmlspecialchars($event['date_debut']) ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
