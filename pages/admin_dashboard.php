<?php
session_start();
require_once "../config/db.php";
$sql = "SELECT * FROM event ORDER BY debut DESC";
$result = $pdo->query("SELECT * FROM events");
$events = $result->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">


</head>

<body>
        <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Tableau de bord Admin</a>
            <a class="btn btn-danger" href="logout.php">Déconnexion</a>
        </div>
    </nav>

    <div class="container mt-4">
        <h2 class="text-center">Gestion des Événements</h2>
        <a href="actions/add_event.php"
            class="btn btn-success rounded-circle position-fixed bottom-3 end-3 d-flex justify-content-center align-items-center"
            style="width: 50px; height: 50px; font-size: 24px; right: 20px; bottom: 20px;">
            +
        </a>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Lieu</th>
                    <th>Image</th>
                    <th>Organisateur</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($events as $row) {
                    echo "<tr>
        <td>" . htmlspecialchars($row['titre']) . "</td>
        <td>" . htmlspecialchars($row['description']) . "</td>
        <td>" . htmlspecialchars($row['date_debut']) . "</td>
        <td>" . htmlspecialchars($row['date_fin']) . "</td>
        <td>" . htmlspecialchars($row['lieu']) . "</td>
        <td><img src='../../uploads/" . htmlspecialchars($row['image']) . "' width='50'></td>
        <td>" . htmlspecialchars($row['organisateur_id']) . "</td>
        <td>
            <a href='edit_event.php?id=" . $row['id'] . "'>Modifier</a> | 
            <a href='delete_event.php?id=" . $row['id'] . "' onclick='return confirm(\"Supprimer cet événement ?\")'>Supprimer</a>
        </td>
    </tr>";

                } ?>
            </tbody>

        </table>
    </div>

</body>

</html>