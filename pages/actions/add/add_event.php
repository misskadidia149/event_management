<?php
require_once __DIR__ . "/../../../config/db.php";
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit'])) {
    try {
        // Validation des données
        $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
        $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
        $debut = filter_input(INPUT_POST, 'date_debut', FILTER_SANITIZE_STRING);
        $fin = filter_input(INPUT_POST, 'date_fin', FILTER_SANITIZE_STRING);
        $lieu = filter_input(INPUT_POST, 'lieu', FILTER_SANITIZE_STRING);
        $organisateur = filter_input(INPUT_POST, 'organisateur', FILTER_SANITIZE_NUMBER_INT);

        // Vérification des champs obligatoires
        if (empty($titre) || empty($description) || empty($debut)) {
            throw new Exception("Titre, description et date de début sont obligatoires");
        }

        // Traitement de l'image
        $image_name = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $image_info = getimagesize($_FILES['image']['tmp_name']);
            if ($image_info === false) {
                throw new Exception("Le fichier n'est pas une image valide");
            }

            $allowed_types = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_GIF];
            if (!in_array($image_info[2], $allowed_types)) {
                throw new Exception("Seuls les formats JPG, PNG et GIF sont autorisés");
            }

            $image_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $new_image_name = uniqid("event_", true) . '.' . $image_ext;
            $upload_dir = __DIR__ . '/../../../uploads/';
            
            // Créer le dossier s'il n'existe pas
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }

            $upload_path = $upload_dir . $new_image_name;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                throw new Exception("Erreur lors de l'enregistrement de l'image");
            }
            
            $image_name = $new_image_name;
        }

        // Insertion en base de données
        $sql = "INSERT INTO events (titre, description, date_debut, date_fin, lieu, image, organisateur_id) 
                VALUES (:titre, :description, :date_debut, :date_fin, :lieu, :image, :organisateur_id)";
        
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':titre' => $titre,
            ':description' => $description,
            ':date_debut' => $debut,
            ':date_fin' => $fin,
            ':lieu' => $lieu,
            ':image' => $image_name,
            ':organisateur_id' => $organisateur
        ]);

        $_SESSION['success'] = "Événement ajouté avec succès";
        // header("Location: ../tableEvent.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>


