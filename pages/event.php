<?php
require_once __DIR__ . "/../../config/db.php";
header('Content-Type: application/json');

try {
    $eventId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
    if (!$eventId) {
        throw new Exception('ID invalide');
    }

    $stmt = $pdo->prepare("
        SELECT e.*, u.nom AS organisateur 
        FROM events e
        LEFT JOIN users u ON e.organisateur_id = u.id
        WHERE e.id = ?
    ");
    $stmt->execute([$eventId]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        throw new Exception('Événement non trouvé');
    }

    echo json_encode([
        'success' => true,
        'data' => $event
    ]);

} catch (Exception $e) {
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}