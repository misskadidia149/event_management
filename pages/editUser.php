<?php
require_once __DIR__ . "/../../../config/db.php";

// Vérifier si l'ID de l'utilisateur est passé en paramètre dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID d'utilisateur invalide.");
}

$user_id = intval($_GET['id']); // Sécurisation de l'ID utilisateur

// Récupérer les informations de l'utilisateur à modifier
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$user = $stmt->fetch();

if (!$user) {
    die("L'utilisateur n'existe pas.");
}

if (isset($_POST['submit'])) {
    // Récupérer les données du formulaire
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $role = trim($_POST['role']);
    $dateI = $_POST['date_inscrption'];

    // Mettre à jour les informations dans la base de données
    $sql_update = "UPDATE users SET nom = ?, email = ?, role = ?, date_inscription = ? WHERE id = ?";
    $stmt_update = $pdo->prepare($sql_update);
    
    if ($stmt_update->execute([$nom, $email, $role, $dateI, $user_id])) {
        header("Location: ../tableUser.php"); // Redirection après succès
        exit();
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier l'utilisateur</title>
    <link rel="stylesheet" href="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="body">
        <form action="editUser.php?id=<?php echo $user['id']; ?>" method="POST">
            <div class="modal modal-sheet position-static d-block bg-body-secondary p-4 py-md-5" tabindex="-1" role="dialog" id="modalSignin">
                <div class="modal-dialog" role="document">
                    <div class="modal-content rounded-4 shadow">
                        <div class="modal-header p-5 pb-4 border-bottom-0">
                            <h1 class="fw-bold mb-0 fs-2">Modifier les informations de l'utilisateur</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                onclick="redirectToDashboard()"></button>
                        </div>
                        <div class="modal-body p-5 pt-0">
                            <div class="form-floating mb-3">
                                <input type="text" name="nom" class="form-control rounded-3" id="floatingInput" placeholder="Nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
                                <label for="nom">Nom</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" name="email" class="form-control rounded-3" id="floatingInput" placeholder="Email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                                <label for="email">Email</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" name="role" class="form-control rounded-3" id="floatingInput" placeholder="Rôle" value="<?php echo htmlspecialchars($user['role']); ?>" required>
                                <label for="role">Rôle</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date" name="date_inscrption" class="form-control rounded-3" id="floatingInput" value="<?php echo htmlspecialchars($user['date_inscription']); ?>" required>
                                <label for="date_inscrption">Date d'inscription</label>
                            </div>
                            <button class="w-100 mb-2 btn btn-lg rounded-3 btn-primary" type="submit" name="submit">Mettre à jour</button>
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
