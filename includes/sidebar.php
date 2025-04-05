
<style>
.nav-link-text {
    font-size: 1.0rem; /* Agrandit la taille de la police des liens */
}

.nav-link {
    font-size: 0.9rem;
    transition: all 0.3s ease;
  }

.sidenav-footer .btn {
    font-size: 0.5rem; /* Agrandit la taille du texte dans le bouton */
}
.nav-item {
    margin-bottom: 10px; /* Espace entre les éléments de la barre de navigation */
}

.nav-link {
    margin: 10px 0;
    border-radius: 0.5rem;
    padding: 0.75rem 1rem;
  }

.navbar-nav > .nav-item {
    margin-bottom: 15px; /* Espacement entre les liens de navigation */
}

.navbar-nav .nav-item.mt-3 {
    margin-top: 20px; /* Espace avant la section "Account pages" */
}

.sidenav-footer .mx-3 {
    margin-top: 20px; /* Espace avant le bouton de déconnexion */
}
  /* Styles pour les liens actifs */
  .nav-link.active {
    font-weight: 600;
    box-shadow: 0 4px 20px -12px rgba(0, 0, 0, 0.3);
  }
  .nav-link.active i {
    opacity: 1 !important;
    color: white !important;
  }

  .nav-link:hover:not(.active) {
    background-color: rgba(0, 0, 0, 0.05);
  }
  .user-info {
    display: flex;
    align-items: center;
    padding: 10px;
}

.avatar-circle {
    width: 50px; /* Taille du cercle */
    height: 50px;
    background-color: #007bff; /* Couleur du fond */
    color: #fff; /* Couleur de l'icône */
    border-radius: 50%; /* Cercle parfait */
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 20px; /* Taille de l'icône */
    margin-right: 10px; /* Espace entre l'avatar et les informations */
}

.user-details {
    color: #333;
}

.user-name {
    font-weight: bold;
    font-size: 14px;
    margin-bottom: 5px;
}

.user-email {
    font-size: 12px;
    color: #555;
}

</style>
<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2  bg-white my-2" id="sidenav-main">

  
<?php
// session_start(); // Démarre la session
if (isset($_SESSION['user_name']) && isset($_SESSION['user_email'])) {
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];
} else {
    $user_name = 'Nom Inconnu';  // Valeur par défaut si non défini
    $user_email = 'Email Inconnu';
}
?>

<div class="sidenav-header">    
    <!-- Affichage des infos utilisateur -->
    <div class="user-info d-flex align-items-center mt-4">
        <!-- Cercle avec icône utilisateur -->
        <div class="avatar-circle d-flex justify-content-center align-items-center" style="width: 50px; height: 50px; border-radius: 50%; background-color: #007bff; color: white; font-size: 24px;">
            <img src="../assets/img/admin.png" alt=""style="width: 50px; height: 50px;" class="rounded-circle">
        </div>
        <div class="user-details ms-3">
            <h6 class="user-name" style="font-size: 14px; font-weight: bold;"><?php echo htmlspecialchars($user_name); ?></h6>
            <p class="user-email" style="font-size: 12px;"><?php echo htmlspecialchars($user_email); ?></p>
        </div>
    </div>
</div>



    <hr class="horizontal dark mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'admin_dashboard.php' ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="admin_dashboard.php">            <i class="material-symbols-rounded opacity-5">dashboard</i>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'tableUser.php' ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="tableUser.php">            <i class="material-symbols-rounded opacity-5">table_view</i>
            <span class="nav-link-text ms-1">Utilisateurs</span>
          </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'tableEvent.php' ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="tableEvent.php">            <i class="material-symbols-rounded opacity-5">receipt_long</i>
            <span class="nav-link-text ms-1">Evenements</span>
          </a>
        </li>
        <li class="nav-item">
        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'notification.php' ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="notification.php">            <i class="material-symbols-rounded opacity-5">notifications</i>
            <span class="nav-link-text ms-1">Notifications</span>
          </a>
        </li>

        <!-- <li class="nav-item">
        <a class="nav-link <?= basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active bg-gradient-dark text-white' : 'text-dark' ?>" href="profile.php">            <i class="material-symbols-rounded opacity-5">person</i>
            <span class="nav-link-text ms-1">Profile</span>
          </a>
        </li> -->
      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0">
  <div class="mx-3">
    <a class="btn bg-danger text-white mt-4 w-100 fs-6 py-2" href="logout.php" type="button">
      <i class="fas fa-sign-out-alt me-2"></i> Déconnexion
    </a>
  </div>
</div>
  </aside>