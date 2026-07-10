<?php
// suppression_commande.php
session_start();

// Sécurité : seul un admin connecté peut accéder à cette page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: connexion.php');
    exit();
}
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Requête de suppression
    $stmt = $pdo->prepare("DELETE FROM commandes WHERE id = ?");
    $stmt->execute([$id]);
}

// Redirection vers la liste
header('Location: commandes.php');
exit();
?>