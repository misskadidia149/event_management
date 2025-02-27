<!-- page d'inscription -->
<?php

require_once "../config/db.php";
$message = "";
//verifier si le formulaire est soumi

if (isset($_POST['register'])) {
    # code...
    //recuperation des input
    $nom = trim($_POST['nom']);
    $email = trim($_POST['email']);
    $password = $_POST['mdp'];
    $cpassword = $_POST['cmdp'];

    //comparer les mdp
    if ($password !== $cpassword) {
        $message = "<div class='alert alert-danger text-center'>Les mots de passe ne correspondent pas !</div>";
    } else {

        //verifier si l'utilisateur existe deja

        $checkUser = $pdo->prepare("SELECT * FROM users WHERE email=?");
        $checkUser->execute([$email]);

        if ($checkUser->rowCount() > 0) {

            echo "<div class='alert alert-danger text-center>Cet email est déjà utilisé!</div>";
        } else {

            //hasher le password
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


            //inserer l'utilisateur
            $query = $pdo->prepare("INSERT INTO users(nom,email,mot_de_passe,role,date_inscription) VALUES(?,?,?,?,NOW())");
            $success = $query->execute([$nom, $email, $hashedPassword, 'user']);
            if ($success) {

                $message = "<div class='alert alert-success text-center'>Inscription réussie!</div>";
                header("location:index.php");

            } else {
                $message = "<div class='alert alert-danger text-center'>Cet email est déjà utilisé!</div>";
            }

        }
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
                    <h1 class="fw-semibold">Inscription</h1>
                </div>
                <form action="register.php" method="post">
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="bi bi-person"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Nom d'utilisateur" name="nom"
                            aria-label="Username" aria-describedby="basic-addon1" required>
                    </div>
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
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="bi bi-shield-check"></i>
                        </span>
                        <input type="text" class="form-control" placeholder="Confirmez votre mot de passe" name="cmdp"
                            aria-label="Username" aria-describedby="basic-addon1" required>
                    </div>
                    <div>
                        <?php
                        echo $message;
                        ?>
                    </div>
                    <button class="login-btn btn btn-primary" name="register">S'inscrire</button>
                    <a href="login.php" class="forgot-password">Vous avez déjà un compte? Connectez vous !</a>
                </form>

            </div>
        </div>
    </div>
</body>

</html>

</body>

</html>