<?php
require_once "../../config/db.php";
session_start();

if (isset($_POST['submit'])) {
    $titre = trim($_POST['titre']);
    $description = trim($_POST['description']);
    $debut = $_POST['date_debut'];
    $fin = $_POST['date_fin'];
    $lieu = trim($_POST['lieu']);
    $organisateur = trim($_POST['organisateur']);

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_ext = strtolower(pathinfo($image_name, PATHINFO_EXTENSION));

        // Vérifier si l'extension est une image autorisée
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($image_ext, $allowed_ext)) {
            echo "Format d'image non autorisé !";
            exit();
        }

        $new_image_name = uniqid("event_", true) . "." . $image_ext;
        $upload_dir = "../../uploads/"; // Assure-toi que ce dossier existe !
        $upload_path = $upload_dir . $new_image_name;

        if (move_uploaded_file($image_tmp, $upload_path)) {
            $sql = "INSERT INTO events (titre, description, date_debut, date_fin, lieu, image, organisateur_id) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute([$titre, $description, $debut, $fin, $lieu, $new_image_name, $organisateur])) {
                header("Location: ../admin_dashboard.php");
                exit();
            } else {
                echo "Erreur lors de l'ajout.";
            }
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }
    } else {
        echo "Veuillez ajouter une image.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
body {
    background-image: linear-gradient(rgba(0, 0, 255, 0.5), rgba(255, 255, 0, 0.5)),
                      url("../../assets/img/nezuko.jpg");
    background-size: cover;  /* Pour couvrir toute la page */
    background-position: center;  /* Centre l'image */
    background-repeat: no-repeat;  /* Évite la répétition */
    height: 100vh;  /* Assure que le fond couvre toute la hauteur de l'écran */
    margin: 0; /* Supprime les marges par défaut */
    padding: 0;
}
    </style>
</head>
<body>
    <div class="body">
<form action="add_event.php" method="POST" enctype="multipart/form-data">
            
    <div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog"
            id="modalSignin">
            <div class="modal-dialog" role="document">
                <div class="modal-content rounded-4 shadow">
                    <div class="modal-header p-5 pb-4 border-bottom-0">
                        <h1 class="fw-bold mb-0 fs-2">Vos informations</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-5 pt-0">
                        <form class="" action="traitement.php" method="POST">
                        <div class="form-floating mb-3">
                                <input type="text" name="titre" class="form-control rounded-3" id="floatingInput"
                                    placeholder="name@example.com">
                                <label for="nom" name="titre">Titre</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="description" class="form-control rounded-3" id="floatingInput"
                                    placeholder="name@example.com" required>
                                <label for="nom" name="description">Description</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="lieu" class="form-control rounded-3" id="floatingInput"
                                    placeholder="name@example.com" required>
                                <label for="prenom" name="lieu">Lieu</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="date_debut" class="form-control rounded-3" id="floatingInput"
                                    placeholder="name@example.com">
                                <label for="date_debut" name="date_debut">Début</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="date_fin" class="form-control rounded-3" id="floatingInput"
                                    placeholder="name@example.com">
                                <label for="age" name="date_fin">Fin</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="organisateur" class="form-control rounded-3" id="floatingInput"
                                    placeholder="name@example.com">
                                <label for="age" name="organisateur">Organisateur</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="file" name="image" class="form-control rounded-3" id="floatingInput"
                                    placeholder="name@example.com">
                                <label for="age" name="image">Image</label>
                            </div>
                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="submit">Ajouter Événement</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
</form>
</div>
</body>
</html>