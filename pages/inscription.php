<?php
session_start();
require_once "../config/db.php"; // Connexion à la base de données

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    die("Vous devez être connecté pour vous inscrire à un événement. <a href='../login.php'>Connexion</a>");
}

$user_id = $_SESSION['user_id'];

// Vérifier si l'ID de l'événement est présent dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID d'événement invalide.");
}

$event_id = intval($_GET['id']); // Sécurisation de l'ID

// Vérifier si l'événement existe
$sql = "SELECT * FROM events WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if (!$event) {
    die("L'événement n'existe pas.");
}

// Vérifier si l'utilisateur est déjà inscrit à cet événement
$sql = "SELECT * FROM register WHERE utilisateur_id = ? AND evenement_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id, $event_id]);
$existing = $stmt->fetch();

if ($existing) {
    die("Vous êtes déjà inscrit à cet événement. <a href='mes_evenements.php'>Voir mes événements</a>");
}

// Inscrire l'utilisateur
$sql = "INSERT INTO register (utilisateur_id, evenement_id) VALUES (?, ?)";
$stmt = $pdo->prepare($sql);
if ($stmt->execute([$user_id, $event_id])) {
    echo "Inscription réussie ! <a href='mes_evenements.php'>Voir mes événements</a>";
} else {
    echo "Une erreur s'est produite.";
}
?>
