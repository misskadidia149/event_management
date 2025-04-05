<?php
// Connexion à la base de données
require_once "../config/db.php";
session_start();
// Inclure la connexion à la base de données


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    // Récupérer l'id de l'utilisateur à supprimer
    $id = intval($_POST['id']);

    // Requête SQL pour supprimer l'utilisateur
    $sql = "DELETE FROM users WHERE id = :id";
    
    // Préparer la requête
    $stmt = $pdo->prepare($sql);
    
    // Lier l'ID à la requête
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    // Exécuter la requête
    if ($stmt->execute()) {
        // Si la suppression réussie, rediriger
        header("Location: tableUser.php?deleted=success");
        exit();
    } else {
        echo "Erreur lors de la suppression : " . $pdo->errorInfo()[2];
    }
} else {
    echo "Requête invalide.";
}

