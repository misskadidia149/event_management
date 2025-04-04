<?php
require_once __DIR__ . "/../../../config/db.php";
// session_start();

if (isset($_POST['submit'])) {
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $dateI = $_POST['date_inscrption'];


        

            $sql = "INSERT INTO users (nom, email, role, date_inscription) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);

            if ($stmt->execute([$nom, $email, $role, $dateI])) {
                header("Location: ../tableUser.php");
                exit();
            } else {
                echo "Erreur lors de l'ajout.";
            }
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body>
    <div class="body">
        <form action="add_event.php" method="POST" enctype="multipart/form-data">

            <div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1"
                role="dialog" id="modalSignin">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded-4 shadow">
                        <div class="modal-header p-5 pb-4 border-bottom-0">
                            <h1 class="fw-bold mb-0 fs-2">Ajouter un nouvel utilisateur</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                onclick="redirectToDashboard()"></button>
                        </div>
                        <div class="modal-body p-5 pt-0">
                            <form class="" action="traitement.php" method="POST">
                                <div class="form-floating mb-3">
                                    <input type="text" name="titre" class="form-control rounded-3" id="floatingInput"
                                        placeholder="name@example.com">
                                    <label for="nom" name="titre">Nom</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="description" class="form-control rounded-3"
                                        id="floatingInput" placeholder="name@example.com" required>
                                    <label for="nom" name="description">Email</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="text" name="lieu" class="form-control rounded-3" id="floatingInput"
                                        placeholder="name@example.com" required>
                                    <label for="prenom" name="lieu">Role</label>
                                </div>
                        
                                <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit"
                                    name="submit">Ajouter</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script>
            function redirectToDashboard() {
                setTimeout(function () {
                    window.location.href = "../tableUser.php";
                }, 300); // Petite pause pour une meilleure transition
            }
        </script>

    </div>
</body>

</html>