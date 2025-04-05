<?php
// Inclure la connexion à la base de données
require_once "../config/db.php";

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_id'])) {
    $eventId = intval($_POST['event_id']);

    try {
        // 1. Récupération du nom de l'image pour suppression
        $stmtImage = $pdo->prepare("SELECT image FROM events WHERE id = :id");
        $stmtImage->execute([':id' => $eventId]);
        $event = $stmtImage->fetch();

        // 2. Suppression de l'image si elle existe
        if ($event && $event['image']) {
            $imagePath = __DIR__ . "/../../../uploads/" . $event['image'];
            if (file_exists($imagePath)) {
                unlink($imagePath); // Supprimer le fichier image
            }
        }

        // 3. Suppression de l'événement dans la base de données
        $stmt = $pdo->prepare("DELETE FROM events WHERE id = :id");
        $stmt->execute([':id' => $eventId]);

        // 4. Réponse JSON pour indiquer que la suppression a réussi
        echo json_encode(["success" => true]);
    } catch (Exception $e) {
        // 5. Réponse JSON en cas d'erreur
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
}
?>
