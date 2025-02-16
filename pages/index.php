 <!-- Page d'accueil -->

 <!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Événements - Minimal Design</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #212529;
        }
        .navbar-brand {
            font-weight: bold;
            font-size: 1.4rem;
        }
        .event-card {
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            transition: 0.3s;
        }
        .event-card:hover {
            transform: scale(1.02);
        }
        .btn-custom {
            background-color: #007bff;
            color: #fff;
            border-radius: 50px;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#">Événements</a>
        <a href="login.php" class="btn btn-outline-light">Connexion</a>
    </div>
</nav>

<!-- Section événements -->
<div class="container mt-5">
    <h2 class="text-center mb-4">📅 Événements à venir</h2>
    <div class="row">
        <!-- Exemple d'événement -->
        <div class="col-md-4">
            <div class="card event-card p-3">
                <h5 class="card-title">Conférence Tech</h5>
                <p class="text-muted">📍 Paris | 📅 15/02/2025</p>
                <a href="inscription.php?id=1" class="btn btn-custom">S'inscrire</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card event-card p-3">
                <h5 class="card-title">Atelier IA</h5>
                <p class="text-muted">📍 Lyon | 📅 22/02/2025</p>
                <a href="inscription.php?id=2" class="btn btn-custom">S'inscrire</a>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card event-card p-3">
                <h5 class="card-title">Hackathon</h5>
                <p class="text-muted">📍 Marseille | 📅 10/03/2025</p>
                <a href="inscription.php?id=3" class="btn btn-custom">S'inscrire</a>
            </div>
        </div>
    </div>
</div>

<!-- Pied de page -->
<footer class="text-center mt-5 py-3 bg-light">
    <p class="mb-0">© 2025 Gestion des Événements - Tous droits réservés.</p>
</footer>

</body>
</html>
