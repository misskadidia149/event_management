<?php
require_once "../config/db.php";
session_start();

$message = "";

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['mdp']);
    
    if (!empty($email) && !empty($password)) {
        $verifyUser = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $verifyUser->execute([$email]);
        $user = $verifyUser->fetch();

        if ($user && password_verify($password, $user['mot_de_passe'])) {
            // Stocker les informations de l'utilisateur en session avant la redirection
            $_SESSION['user_id'] = $user['id']; // ID de l'utilisateur
            $_SESSION['user_name'] = $user['nom']; // Nom de l'utilisateur
            $_SESSION['user_email'] = $user['email']; // Email de l'utilisateur
            $_SESSION['role'] = $user['role']; // Rôle de l'utilisateur (admin, etc.)

            // Rediriger selon le rôle de l'utilisateur
            if ($user['role'] === 'admin') {
                header("Location: admin_dashboard.php");
                exit();
            } else {
                header("Location: user_dashboard.php");
                exit();
            }
        } else {
            $message = "<div class='alert alert-danger text-center'>Mauvais identifiants !</div>";
        }
    } else {
        $message = "<div class='alert alert-danger text-center'>Tous les champs doivent être remplis !</div>";
    }
}
?>




<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">

    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body>
    <div class="container">
        <div class="left-section">
        </div>
        <div class="right-section">
            <div class="login-box">
                <div class="logo">
                    <h1 class="fw-semibold">Connexion</h1>
                </div>
                <form action="login.php" method="post">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="bi bi-envelope-check"></i>
                        </span>
                        <input type="email" class="form-control" placeholder="Votre adresse email" name="email"
                            aria-label="Username" aria-describedby="basic-addon1" required>
                    </div>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="bi bi-shield-check"></i>
                        </span>
                        <input type="password" class="form-control" placeholder="Votre mot de passe" name="mdp"
                            aria-label="Username" aria-describedby="basic-addon1" required>
                    </div>
                    <div>
                        <?php
                        echo $message;
                        ?>
                    </div>
                    <button class="login-btn btn btn-primary" name="login">Se connecter</button>
                    <a href="register.php" class="forgot-password">Inscrivez vous !</a>
                </form>

            </div>
        </div>
    </div>
</body>

</html>

</body>

</html>