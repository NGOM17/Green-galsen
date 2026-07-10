<?php
session_start();

// Sécurité : seul un admin connecté peut accéder à cette page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: connexion.php');
    exit();
}
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

if (isset($_GET['id_produit'])) {
    $id = intval($_GET['id_produit']);
    
    // Préparation et exécution de la suppression
    $stmt = $pdo->prepare("DELETE FROM produits WHERE id_produit = ?");
    $stmt->execute([$id]);
}

// REDIRECTION AUTOMATIQUE
header('Location: produits.php?message=supprime');
exit(); // Important pour arrêter l'exécution du script après la redirection
?>