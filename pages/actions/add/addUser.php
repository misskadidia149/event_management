<?php
require_once __DIR__ . "/../../../config/db.php";
session_start();

if (isset($_POST['submit'])) {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $dateI = date('Y-m-d H:i:s'); // Génération automatique de la date actuelle

    $sql = "INSERT INTO users (nom, email, role, date_inscription) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nom, $email, $role, $dateI])) {
        $_SESSION['success_message'] = "Utilisateur ajouté avec succès";
        header("Location: ../tableUser.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Erreur lors de l'ajout de l'utilisateur";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Utilisateur</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .modal-content {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
        }
        .form-floating>label {
            padding: 1rem 0.75rem;
        }
    </style>
</head>

<body>
    <!-- Modal -->
    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="addUserModalLabel">Ajouter un nouvel utilisateur</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="addUser.php" method="POST">
                        <div class="form-floating mb-3">
                            <input type="text" name="nom" class="form-control" id="floatingNom" placeholder="Nom" required>
                            <label for="floatingNom">Nom complet</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="Email" required>
                            <label for="floatingEmail">Adresse email</label>
                        </div>
                        <div class="form-floating mb-3">
                            <select name="role" class="form-select" id="floatingRole" required>
                                <option value="">Sélectionner un rôle</option>
                                <option value="admin">Administrateur</option>
                                <option value="user">Utilisateur</option>
                                <option value="editor">Éditeur</option>
                            </select>
                            <label for="floatingRole">Rôle</label>
                        </div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-lg" type="submit" name="submit">Ajouter l'utilisateur</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Initialisation du modal
        var myModal = new bootstrap.Modal(document.getElementById('addUserModal'));
        myModal.show();

        // Redirection lorsque le modal est fermé
        document.getElementById('addUserModal').addEventListener('hidden.bs.modal', function () {
            window.location.href = "../tableUser.php";
        });
    </script>
</body>
</html>