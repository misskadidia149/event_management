<?php
session_start();
require_once "../config/db.php";
$sql = "SELECT * FROM users ORDER BY date_inscription DESC";
$result = $pdo->query($sql);
$users = $result->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <title>
    Gestion Utilisateurs
  </title>
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
              <div class=" shadow-dark border-radius-lg pt-4 pb-3" style="background-color: #9B2335;">
                <h6 class="text-white text-capitalize ps-3">Gestion des Utilisateurs</h6>
              </div>
            </div>
            <div class="card-body px-0 pb-2">
              <div class="table-responsive p-0">
                <table class="table align-items-center mb-0">
                  <thead>
                    <tr>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                      <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Nom</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Email</th>
                      <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Date d'inscription</th>
                      <th class="text-secondary opacity-7">Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php foreach ($users as $row): ?>
              <tr>
      <td><?=htmlspecialchars($row['id']) ?></td>


      <td><?= htmlspecialchars($row['nom'])  ?></td>
      <td><?= htmlspecialchars($row['email']) ?></td>
      <td><?=htmlspecialchars($row['date_inscription']) ?></td>
      <td>
      
      <td>
  <a href='actions/edit/edit_event.php?id=<?= $row['id'] ?>' class='btn btn-sm btn-outline-primary'>Modifier</a>
  <form action="deleteUser.php" method="POST" style="display:inline;" onsubmit="return confirm('Supprimer cet événement ?');">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <button type="submit" class="btn btn-sm btn-outline-danger">Supprimer</button>
</form>


  <button 
    class="btn btn-sm btn-outline-info view-details-btn" 
    data-bs-toggle="modal" 
    data-bs-target="#userDetailsModal"
    data-id="<?= $row['id'] ?>"
    data-nom="<?= htmlspecialchars($row['nom']) ?>"
    data-email="<?= htmlspecialchars($row['email']) ?>"
    data-date="<?= htmlspecialchars($row['date_inscription']) ?>"
    data-role="<?= htmlspecialchars($row['role']) ?>"
  >
    Détails
  </button>
</td>

</td>

  </tr>
              <?php endforeach ;?>
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
                <h5 class="modal-title text-white" id="addUserModalLabel">Ajouter un Utilisateur</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="actions/add/addUser.php" method="POST">
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom complet</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Rôle</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="">Sélectionner un rôle</option>
                            <option value="admin">Administrateur</option>
                            <option value="user">Utilisateur</option>
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
<!-- Modal Détails Utilisateur -->
<div class="modal fade" id="userDetailsModal" tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-gradient-info text-white">
        <h5 class="modal-title" id="userDetailsModalLabel">Détails de l'utilisateur</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Fermer"></button>
      </div>
      <div class="modal-body">
        <p><strong>ID :</strong> <span id="detail-id"></span></p>
        <p><strong>Nom :</strong> <span id="detail-nom"></span></p>
        <p><strong>Email :</strong> <span id="detail-email"></span></p>
        <p><strong>Rôle :</strong> <span id="detail-role"></span></p>
        <p><strong>Date d'inscription :</strong> <span id="detail-date"></span></p>
      </div>
      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
      </div>
    </div>
  </div>
</div>

<script>
  // Gérer l’ouverture du modal et remplir les infos
  document.querySelectorAll('.view-details-btn').forEach(button => {
    button.addEventListener('click', () => {
      document.getElementById('detail-id').textContent = button.dataset.id;
      document.getElementById('detail-nom').textContent = button.dataset.nom;
      document.getElementById('detail-email').textContent = button.dataset.email;
      document.getElementById('detail-date').textContent = button.dataset.date;
      document.getElementById('detail-role').textContent = button.dataset.role || "Non spécifié";
    });
  });
</script>

  <!-- Core JS Files -->
  <script src="../assets/js/core/popper.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="../assets/js/plugins/smooth-scrollbar.min.js"></script>
  <!-- Bootstrap Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>
  <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.delete-btn').forEach(btn => {
        btn.addEventListener('click', async function() {
            const userId = this.dataset.userId;
            const deleteUrl = this.dataset.deleteUrl;
            
            if (!confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
                return;
            }

            try {
                const response = await fetch(deleteUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `id=${userId}`
                });

                if (!response.ok) {
                    throw new Error(`Erreur HTTP: ${response.status}`);
                }

                const data = await response.json();
                
                if (data.success) {
                    // Suppression visuelle de la ligne
                    this.closest('tr').remove();
                    showToast('success', 'Suppression réussie');
                } else {
                    throw new Error(data.error || 'Erreur lors de la suppression');
                }
            } catch (error) {
                console.error('Erreur:', error);
                showToast('danger', `Échec de la suppression: ${error.message}`);
            }
        });
    });
    <div id="toast-container" class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999;"></div>
    // Fonction pour afficher le toast
    function showToast(type, message) {
        // Votre implémentation existante...
        const toast = document.createElement('div');
  toast.className = `toast align-items-center text-white bg-${type} border-0 show`;
  toast.role = 'alert';
  toast.ariaLive = 'assertive';
  toast.ariaAtomic = 'true';
  toast.innerHTML = `
    <div class="d-flex">
      <div class="toast-body">${message}</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  `;
  document.getElementById('toast-container').appendChild(toast);
  setTimeout(() => {
    toast.remove();
  }, 3000);
}
    }
);
</script>

  
  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>
  <!-- Control Center for Material Dashboard -->
  <script src="../assets/js/material-dashboard.min.js?v=3.2.0"></script>
</body>
</html>