<?php
// notification.php

require_once '../config/db.php';

// Récupération des notifications avec nom de l'utilisateur
$sql = "SELECT n.*, u.nom AS utilisateur_nom 
        FROM notifications n 
        JOIN users u ON n.utilisateur_id = u.id 
        ORDER BY date_envoi DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute();
$notifications = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>Notifications</title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" />
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="g-sidenav-show bg-gray-100">
  <?php include '../includes/sidebar.php'; ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php include '../includes/navbar.php'; ?>

    <div class="container mt-4">
        <h1 class="mb-4">Liste des Notifications</h1>
        <ul class="list-group">
            <?php foreach ($notifications as $notif): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($notif['utilisateur_nom']); ?></strong> :
                    <?= htmlspecialchars($notif['message']); ?><br>
                    <small><?= htmlspecialchars($notif['type']); ?> - <?= htmlspecialchars($notif['date_envoi']); ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
  </main>

  <!-- Bouton flottant -->
  <div class="fixed-plugin">
    <button class="btn btn-primary btn-round position-fixed bottom-0 end-0 m-4" data-bs-toggle="modal" data-bs-target="#addNotificationModal">
        <i class="material-symbols-rounded">add</i> Envoyer une notification
    </button>
  </div>

  <!-- Modal pour ajouter une notification -->
  <div class="modal fade" id="addNotificationModal" tabindex="-1" aria-labelledby="addNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-dark">
                <h5 class="modal-title text-white" id="addNotificationModalLabel">Ajouter une notification</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="send_notification.php" method="POST">
    <div class="mb-3">
        <label for="utilisateur" class="form-label">Destinataire</label>
        <select name="utilisateur_id" class="form-select" required>
            <option value="">-- Choisir un utilisateur --</option>
            <?php
            $utilisateurs = $pdo->query("SELECT id, nom FROM users")->fetchAll();
            foreach ($utilisateurs as $u) {
                echo "<option value='{$u['id']}'>{$u['nom']}</option>";
            }
            ?>
        </select>
    </div>
    <div class="mb-3">
        <label for="message" class="form-label">Message</label>
        <textarea name="message" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label for="type" class="form-label">Type</label>
        <select name="type" class="form-select" required>
            <option value="info">Info</option>
            <option value="alerte">Alerte</option>
            <option value="autre">Autre</option>
        </select>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Envoyer</button>
    </div>
</form>

            </div>
        </div>
    </div>
  </div>

  <!-- Scripts -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
    }
  </script>
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
