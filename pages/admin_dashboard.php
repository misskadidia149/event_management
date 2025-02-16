<!-- tableau de board -->
 <?php
 session_start();
 if(!isset($_SESSION['user_role'])|| $_SESSION['user_role'] !=='admin'){
    header("Location:login.php");
    exit;
 }
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
        <a class="btn btn-danger" href="../logout.php">Déconnexion</a>
    </div>
</nav>

<div class="container mt-4">
    <h2 class="text-center">Gestion des Événements</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nom</th>
                <th>Date</th>
                <th>Lieu</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Conférence Tech</td>
                <td>15/02/2025</td>
                <td>Paris</td>
                <td>
                    <a href="edit_event.php?id=1" class="btn btn-warning btn-sm">Modifier</a>
                    <a href="delete_event.php?id=1" class="btn btn-danger btn-sm">Supprimer</a>
                </td>
            </tr>
        </tbody>
    </table>
</div>

</body>
</html>
