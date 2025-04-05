<?php
require_once "../config/db.php";
session_start();

// Vérifier si l'ID de l'événement est présent dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID d'événement invalide.");
}

$event_id = intval($_GET['id']);

// Récupérer les informations de l'événement
$sql = "SELECT * FROM events WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$event_id]);
$event = $stmt->fetch();

if (!$event) {
    die("L'événement n'existe pas.");
}

// Mise à jour des informations si le formulaire est soumis
if (isset($_POST['submit'])) {
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $debut = $_POST['date_debut'];
    $fin = $_POST['date_fin'];
    $lieu = trim($_POST['lieu']);
    $organisateur = trim($_POST['organisateur']);
    $new_image_name = $event['image']; // Conserver l'image existante

    // Vérifier si une nouvelle image a été ajoutée
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($image_ext, $allowed_ext)) {
            echo "Format d'image non autorisé !";
            exit();
        }

        $new_image_name = uniqid("event_", true) . "." . $image_ext;
        $upload_dir = "../../../uploads/";
        $upload_path = $upload_dir . $new_image_name;

        if (!move_uploaded_file($image_tmp, $upload_path)) {
            echo "Erreur lors du téléchargement de l'image.";
            exit();
        }
    }

    // Mettre à jour l'événement
    $sql = "UPDATE events SET titre = ?, description = ?, date_debut = ?, date_fin = ?, lieu = ?, image = ?, organisateur_id = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute([$titre, $description, $debut, $fin, $lieu, $new_image_name, $organisateur, $event_id])) {
        // Rediriger vers la page de l'événement ou une autre page après la mise à jour
        header("Location: event_details.php?id=" . $event_id);
        exit();
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier un événement</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h2 class="text-center">Modifier l'événement</h2>
        <form action="edit_event.php?id=<?= $event_id ?>" method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label for="titre" class="form-label">Titre</label>
                <input type="text" name="titre" class="form-control" value="<?= htmlspecialchars($event['titre']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" required><?= htmlspecialchars($event['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="lieu" class="form-label">Lieu</label>
                <input type="text" name="lieu" class="form-control" value="<?= htmlspecialchars($event['lieu']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="date_debut" class="form-label">Date de début</label>
                <!-- Assurez-vous que la date est au format YYYY-MM-DD -->
                <input type="date" name="date_debut" class="form-control" value="<?= date('Y-m-d', strtotime($event['date_debut'])) ?>" required>
            </div>

            <div class="mb-3">
                <label for="date_fin" class="form-label">Date de fin</label>
                <!-- Assurez-vous que la date est au format YYYY-MM-DD -->
                <input type="date" name="date_fin" class="form-control" value="<?= date('Y-m-d', strtotime($event['date_fin'])) ?>" required>
            </div>

            <div class="mb-3">
                <label for="organisateur" class="form-label">Organisateur</label>
                <input type="text" name="organisateur" class="form-control" value="<?= htmlspecialchars($event['organisateur_id']) ?>" required>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Image actuelle</label><br>
                <img src="../../uploads/<?= $event['image'] ?>" alt="Image de l'événement" width="200">
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Changer l'image</label>
                <input type="file" name="image" class="form-control">
            </div>

            <button type="submit" name="submit" class="btn btn-primary w-100">Mettre à jour</button>
        </form>
    </div>
</body>

</html>
