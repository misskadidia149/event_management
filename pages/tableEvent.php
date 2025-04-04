<?php
session_start();
require_once "../config/db.php";

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
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
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
            <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
              <h6 class="text-white text-capitalize ps-3">Gestion des Événements</h6>
            </div>
          </div>
          <div class="card-body px-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Titre</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Description</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Début</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Fin</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lieu</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Image</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Organisateur</th>
                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Actions</th>
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
                        <?php 
                        $imagePath = "../../uploads/" . htmlspecialchars($row['image']);
                        if (!empty($row['image']) && file_exists(__DIR__ . "/../../uploads/" . $row['image'])): 
                        ?>
                          <img src="<?= $imagePath ?>" width="50" height="50" class="rounded" style="object-fit: cover;" alt="Image événement">
                        <?php else: ?>
                          <span class="badge bg-secondary">Aucune image</span>
                        <?php endif; ?>
                      </td>
                      <td class="text-center text-sm">
                        <?php
                        $org_stmt = $pdo->prepare("SELECT nom FROM users WHERE id = ?");
                        $org_stmt->execute([$row['organisateur_id']]);
                        $organisateur = $org_stmt->fetchColumn();
                        echo htmlspecialchars($organisateur);
                        ?>
                      </td>
                      <td class="text-center">
                        <a href="edit_event.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Modifier</a>
                        <button class="btn btn-sm btn-outline-danger delete-btn" data-event-id="<?= $row['id'] ?>">Supprimer</button>
                        <button class="btn btn-sm btn-info view-btn" data-event-id="<?= $row['id'] ?>">
                          <i class="fas fa-eye"></i> Détails
                        </button>
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

  <!-- Modal pour voir les détails -->
  <div class="modal fade" id="eventDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Détails de l'événement</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="eventDetailsContent">
          <!-- Contenu chargé dynamiquement -->
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Bouton flottant pour ajouter un événement -->
  <div class="fixed-plugin">
    <button class="btn btn-primary btn-round position-fixed bottom-0 end-0 m-4" data-bs-toggle="modal" data-bs-target="#addEventModal">
      <i class="material-symbols-rounded">add</i> Ajouter un Événement
    </button>
  </div>

  <!-- Modal pour ajouter un événement -->
  <div class="modal fade" id="addEventModal" tabindex="-1" aria-labelledby="addEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header bg-gradient-dark">
          <h5 class="modal-title text-white" id="addEventModalLabel">Ajouter un événement</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form action="actions/add/add_event.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
              <label for="titre" class="form-label">Titre</label>
              <input type="text" class="form-control" id="titre" name="titre" required>
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Description</label>
              <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
              <label for="date_debut" class="form-label">Date début</label>
              <input type="datetime-local" class="form-control" id="date_debut" name="date_debut" required>
            </div>
            <div class="mb-3">
              <label for="date_fin" class="form-label">Date de fin</label>
              <input type="datetime-local" class="form-control" id="date_fin" name="date_fin" required>
            </div>
            <div class="mb-3">
              <label for="lieu" class="form-label">Lieu</label>
              <input type="text" class="form-control" id="lieu" name="lieu" required>
            </div>
            <div class="mb-3">
              <label for="image" class="form-label">Image</label>
              <input type="file" class="form-control" id="image" name="image" accept="image/*">
            </div>
            <div class="mb-3">
              <label for="organisateur" class="form-label">Organisateur</label>
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

  <!-- Core JS Files -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <script>
    // Gestion des événements
    $(document).ready(function() {
      // Affichage des détails de l'événement
      $('.view-btn').click(function() {
        const eventId = $(this).data('event-id');
        const modal = new bootstrap.Modal(document.getElementById('eventDetailsModal'));
        
        // Afficher un loader pendant le chargement
        $('#eventDetailsContent').html(`
          <div class="text-center py-5">
            <div class="spinner-border text-primary" role="status">
              <span class="visually-hidden">Chargement...</span>
            </div>
          </div>
        `);
        
        modal.show();
        
        // Charger les détails via AJAX
        $.ajax({
          url: 'actions/event.php',
          type: 'GET',
          data: { id: eventId },
          success: function(response) {
            if (response.success) {
              const event = response.data;
              const startDate = new Date(event.date_debut).toLocaleString();
              const endDate = new Date(event.date_fin).toLocaleString();
              
              $('#eventDetailsContent').html(`
                <div class="row">
                  <div class="col-md-6">
                    <img src="../../uploads/${event.image || 'default.jpg'}" 
                         class="img-fluid rounded mb-3" 
                         style="max-height: 300px; object-fit: cover;"
                         alt="${event.titre}">
                    <div class="d-flex justify-content-center gap-2">
                      <span class="badge bg-primary">${event.categorie || 'Général'}</span>
                      <span class="badge bg-success">${event.statut || 'Actif'}</span>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <h3 class="mb-3">${event.titre}</h3>
                    <div class="mb-3">
                      <h5><i class="far fa-calendar-alt me-2"></i>Dates</h5>
                      <p><strong>Début:</strong> ${startDate}</p>
                      <p><strong>Fin:</strong> ${endDate}</p>
                    </div>
                    <div class="mb-3">
                      <h5><i class="fas fa-map-marker-alt me-2"></i>Lieu</h5>
                      <p>${event.lieu || 'Non spécifié'}</p>
                    </div>
                    <div class="mb-3">
                      <h5><i class="fas fa-user-tie me-2"></i>Organisateur</h5>
                      <p>${event.organisateur || 'Non spécifié'}</p>
                    </div>
                    <div class="mb-3">
                      <h5><i class="fas fa-info-circle me-2"></i>Description</h5>
                      <p>${event.description || 'Aucune description disponible'}</p>
                    </div>
                  </div>
                </div>
              `);
            } else {
              $('#eventDetailsContent').html(`
                <div class="alert alert-danger">
                  ${response.error || 'Erreur lors du chargement des détails'}
                </div>
              `);
            }
          },
          error: function() {
            $('#eventDetailsContent').html(`
              <div class="alert alert-danger">
                Erreur lors de la communication avec le serveur
              </div>
            `);
          }
        });
      });

      // Suppression d'un événement
      $('.delete-btn').click(function() {
        const eventId = $(this).data('event-id');
        
        if (confirm('Êtes-vous sûr de vouloir supprimer cet événement ?')) {
          $.ajax({
            url: 'actions/delete/delete_event.php',
            type: 'POST',
            data: { id: eventId },
            success: function(response) {
              if (response.success) {
                alert('Événement supprimé avec succès');
                location.reload();
              } else {
                alert(response.error || 'Erreur lors de la suppression');
              }
            },
            error: function() {
              alert('Erreur lors de la communication avec le serveur');
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
  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>