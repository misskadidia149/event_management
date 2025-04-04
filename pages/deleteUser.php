<?php
require_once __DIR__ . "/../../../config/db.php";
session_start();

// Debug: Enregistrer la tentative de suppression
error_log("Tentative de suppression - Méthode: " . $_SERVER['REQUEST_METHOD'] . ", ID: " . ($_POST['id'] ?? 'non défini'));

header('Content-Type: application/json');

try {
    // Vérification de la méthode
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Méthode non autorisée', 405);
    }

    // Vérification de l'ID
    if (!isset($_POST['id'])) {
        throw new Exception('ID manquant', 400);
    }

    $userId = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($userId === false || $userId <= 0) {
        throw new Exception('ID invalide', 400);
    }

    // Vérification de l'existence
    $stmt = $pdo->prepare("SELECT id FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    if (!$stmt->fetch()) {
        throw new Exception('Utilisateur non trouvé', 404);
    }

    // Suppression
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$userId]);

    if ($stmt->rowCount() === 0) {
        throw new Exception('Aucun utilisateur supprimé', 500);
    }

    // Réponse succès
    echo json_encode([
        'success' => true,
        'message' => 'Utilisateur supprimé avec succès'
    ]);

} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'code' => $e->getCode()
    ]);
    error_log("Erreur suppression: " . $e->getMessage());
}