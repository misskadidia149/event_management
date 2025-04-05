<?php
session_start();
require_once "../config/db.php";

// Correction de la requête SQL (cohérence entre la requête déclarée et exécutée)
$result = $pdo->query("SELECT * FROM events ORDER BY date_debut DESC");
$events = $result->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>Gestion Événements</title>
  <!-- Fonts and icons -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
  <!-- Nucleo Icons -->
  <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
  <!-- CSS Files -->
  <link id="pagestyle" href="../assets/css/material-dashboard.css?v=3.2.0" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="g-sidenav-show bg-gray-100">
  <?php include '../includes/sidebar.php'; ?>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <?php include '../includes/navbar.php'; ?>

    <div class="row">
      <div class="col-12">
        <div class="card my-4">
          <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
            <div class="shadow-dark border-radius-lg pt-4 pb-3" style="background-color: #0F4C81;">
              <h6 class="text-white text-capitalize ps-3">Gestion des Événements</h6>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Titre</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description
                    </th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Début
                    </th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fin</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lieu
                    </th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image
                    </th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                      Organisateur</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions
                    </th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($events as $row): ?>
                    <tr>
                      <td class="text-sm"><?= htmlspecialchars($row['titre']) ?></td>
                      <td class="text-sm"><?= htmlspecialchars(substr($row['description'], 0, 50)) ?>...</td>
                      <td class="text-center text-sm"><?= htmlspecialchars($row['date_debut']) ?></td>
                      <td class="text-center text-sm"><?= htmlspecialchars($row['date_fin']) ?></td>
                      <td class="text-center text-sm"><?= htmlspecialchars($row['lieu']) ?></td>
                      <td class="text-center">
                      <td class="text-center">
    <?php 
    // Chemin relatif pour l'affichage HTML (depuis tableEvent.php)
    $imageRelativePath = "../../uploads/" . htmlspecialchars($row['image']);
    
    // Chemin absolu pour la vérification PHP
    $imageAbsolutePath = __DIR__ . "/../../uploads/" . $row['image'];
    
    // Debug: Afficher les chemins pour vérification (à supprimer après test)
    echo "<!-- Debug: " . $imageAbsolutePath . " -->";
    
    if (!empty($row['image']) && file_exists($imageAbsolutePath)): 
    ?>
        <img src="<?= $imageRelativePath ?>" width="50" height="50" class="rounded" 
             style="object-fit: cover;" alt="Image événement">
    <?php else: ?>
        <span class="badge bg-secondary">Aucune image</span>
        <?php if (!empty($row['image'])): ?>
            <small class="text-danger d-block">(Fichier manquant: <?= htmlspecialchars($row['image']) ?>)</small>
        <?php endif; ?>
    <?php endif; ?>
</td>
                      <td class="text-center text-sm">
                        <?php
                        // Récupération du nom de l'organisateur
                        $org_stmt = $pdo->prepare("SELECT nom FROM users WHERE id = ?");
                        $org_stmt->execute([$row['organisateur_id']]);
                        $organisateur = $org_stmt->fetchColumn();
                        echo htmlspecialchars($organisateur);
                        ?>
                      </td>
                      <td class="text-center">
    <a href="edit_event.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
    
    <!-- Formulaire de suppression -->
    <form action="delete_event.php" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cet événement ?');">
        <input type="hidden" name="event_id" value="<?= $row['id'] ?>">
        <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
    </form>
    <a href="#" class="btn btn-sm btn-info" 
   data-bs-toggle="modal" 
   data-bs-target="#eventDetailModal" 
   data-id="<?= $row['id'] ?>"
   data-titre="<?= htmlspecialchars($row['titre']) ?>"
   data-description="<?= htmlspecialchars($row['description']) ?>"
   data-date="<?= $row['date_debut'] ?>"
    data-datefin="<?= $row['date_fin'] ?>"
   data-image="<?= $row['image'] ?>">
   Détails
</a>

</td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

   <!-- Bouton flottant pour ajouter un utilisateur -->
   <div class="fixed-plugin">
    <button class="btn btn-primary btn-round position-fixed bottom-0 end-0 m-4" data-bs-toggle="modal" data-bs-target="#addUserModal">
        <i class="material-symbols-rounded">add</i> Ajouter un Utilisateur
    </button>
  </div>

  <!-- Modal pour ajouter un utilisateur -->
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-gradient-dark">
                <h5 class="modal-title text-white" id="addUserModalLabel">Ajouter un evenement</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/add/add_event.php" method="POST">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Titre</label>
                        <input type="text" class="form-control" id="nom" name="titre" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Description</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Date debut</label>
                        <input type="text" class="form-control" id="debut" name="date_debut" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Date de fin</label>
                        <input type="text" class="form-control" id="fin" name="date_fin" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Lieu</label>
                        <input type="text" class="form-control" id="lieu" name="lieu" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Image</label>
                        <input type="file" class="form-control" id="email" name="image" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Organisateur</label>
                        <select class="form-select" id="organisateur" name="organisateur" required>
                            <option value="">Sélectionner un organisateur</option>
                            <?php
                            $organisateurs = $pdo->query("SELECT id, nom FROM users")->fetchAll();
                            foreach ($organisateurs as $org) {
                                echo "<option value='{$org['id']}'>{$org['nom']}</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" name="submit" class="btn btn-primary">Ajouter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
  </div>
<!-- Modal Détails Événement -->
<div class="modal fade" id="eventDetailModal" tabindex="-1" aria-labelledby="eventDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="eventDetailModalLabel">Détails de l'Événement</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <h4 id="modalEventTitle"></h4>
        <p><strong>Date  et heure de debut:</strong> <span id="modalEventDate"></span></p>
        <p><strong>Date  et heure de fin:</strong> <span id="modalEventDateFin"></span></p>
        <p id="modalEventDescription"></p>
        <img id="modalEventImage" src="" alt="Image événement" class="img-fluid mt-3 rounded" style="max-height: 300px;">
      </div>
    </div>
  </div>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  var eventDetailModal = document.getElementById('eventDetailModal');

  eventDetailModal.addEventListener('show.bs.modal', function (event) {
    var button = event.relatedTarget;

    // Récupérer les data-attributes
    var titre = button.getAttribute('data-titre');
    var description = button.getAttribute('data-description');
    var date = button.getAttribute('data-date');
    var dateFin = button.getAttribute('data-datefin');

    var image = button.getAttribute('data-image');

    // Injecter dans le modal
    document.getElementById('modalEventTitle').textContent = titre;
    document.getElementById('modalEventDescription').textContent = description;
    document.getElementById('modalEventDate').textContent = date;
    document.getElementById('modalEventDateFin').textContent = dateFin;

    // Charger l’image s’il y en a une
    const imageElement = document.getElementById('modalEventImage');
    if (image) {
      imageElement.src = '../../../uploads/' + image;
      imageElement.style.display = 'block';
    } else {
      imageElement.style.display = 'none';
    }
  });
});
</script>

  <!-- Core JS Files -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = { damping: '0.5' }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- Script pour charger les données -->

<script>
    $(document).ready(function() {
        // Lorsque le bouton de suppression est cliqué
        $(".delete-btn").click(function() {
            var eventId = $(this).data("event-id"); // Récupérer l'ID de l'événement

            // Demander confirmation avant de supprimer
            if (confirm("Êtes-vous sûr de vouloir supprimer cet événement ?")) {
                // Envoyer une requête AJAX pour supprimer l'événement
                $.ajax({
                    url: "delete_event.php", // URL de la page PHP de suppression
                    type: "POST",
                    data: { event_id: eventId }, // Envoi de l'ID de l'événement à supprimer
                    success: function(response) {
                        // Si la suppression est réussie, supprimer la ligne de l'événement
                        alert("Événement supprimé avec succès");
                        location.reload(); // Recharger la page pour voir les changements
                    },
                    error: function(xhr, status, error) {
                        alert("Une erreur est survenue lors de la suppression. Veuillez réessayer.");
                    }
                });
            }
        });
    });
</script>

  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
  <!-- Bootstrap Bundle JS (une seule inclusion) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
</body>

</html>