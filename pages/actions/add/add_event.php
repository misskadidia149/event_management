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
        header("Location: ../admin_dashboard.php");
        exit();

    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
?>


    <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addEventModalLabel">Ajouter un Nouvel Événement</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="add_event.php" method="POST" enctype="multipart/form-data">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="titre" name="titre" required>
                                    <label for="titre">Titre de l'événement</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="lieu" name="lieu" required>
                                    <label for="lieu">Lieu</label>
                                </div>
                            </div>
                        </div>

                        <div class="form-floating mb-3">
                            <textarea class="form-control" id="description" name="description" style="height: 100px" required></textarea>
                            <label for="description">Description</label>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="datetime-local" class="form-control" id="date_debut" name="date_debut" required>
                                    <label for="date_debut">Date et heure de début</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <input type="datetime-local" class="form-control" id="date_fin" name="date_fin">
                                    <label for="date_fin">Date et heure de fin</label>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <div class="form-floating mb-3">
                                    <select class="form-select" id="organisateur" name="organisateur" required>
                                        <option value="">Sélectionner un organisateur</option>
                                        <!-- Options des organisateurs dynamiques -->
                                        <?php
                                        $organisateurs = $pdo->query("SELECT id, nom FROM organisateurs")->fetchAll();
                                        foreach ($organisateurs as $org) {
                                            echo "<option value='{$org['id']}'>{$org['nom']}</option>";
                                        }
                                        ?>
                                    </select>
                                    <label for="organisateur">Organisateur</label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="image" class="form-label">Image de l'événement</label>
                                    <input class="form-control" type="file" id="image" name="image" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                            <button type="submit" name="submit" class="btn btn-primary">Ajouter l'événement</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
