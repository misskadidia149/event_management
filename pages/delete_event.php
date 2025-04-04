<?php
// require_once __DIR__ . "/../../../config/db.php";
require_once "../config/db.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $eventId = intval($_POST['event_id']);

    try {
        // Récupération du nom de l'image pour suppression
        $stmtImage = $pdo->prepare("SELECT image FROM events WHERE id = :id");
        $stmtImage->execute([':id' => $eventId]);
        $event = $stmtImage->fetch();

        if ($event && $event['image']) {
            $imagePath = __DIR__ . "/../../../uploads/" . $event['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath); // Supprimer le fichier image
            }
        }

        // Suppression de l'événement
        $stmt = $pdo->prepare("DELETE FROM events WHERE id = :id");
        $stmt->execute([':id' => $eventId]);

        // Réponse JSON pour indiquer que la suppression a réussi
        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        // Réponse JSON en cas d'erreur
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}
?>
