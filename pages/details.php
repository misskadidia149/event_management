<!-- details d'un evenement -->
<?php
require_once __DIR__ . "/../../../config/db.php";

$eventId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$eventId) {
    http_response_code(400);
    die(json_encode(['error' => 'ID invalide']));
}

try {
    $stmt = $pdo->prepare("
        SELECT e.*, u.nom AS organisateur_nom 
        FROM events e
        LEFT JOIN users u ON e.organisateur_id = u.id
        WHERE e.id = ?
    ");
    $stmt->execute([$eventId]);
    $event = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$event) {
        http_response_code(404);
        die(json_encode(['error' => 'Événement non trouvé']));
    }

    header('Content-Type: application/json');
    echo json_encode($event);
    
} catch (PDOException $e) {
    http_response_code(500);
    die(json_encode(['error' => 'Erreur de base de données']));
}
