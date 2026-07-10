<?php
session_start();

// Sécurité : seul un admin connecté peut accéder à cette page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: connexion.php');
    exit();
}
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

// Vérifier si l'ID et l'action sont bien présents dans l'URL
if (isset($_GET['id']) && isset($_GET['action'])) {
    $id = intval($_GET['id']);
    $action = $_GET['action'];

    if ($action === 'supprimer') {
        // Suppression
        $stmt = $pdo->prepare("DELETE FROM commandes WHERE id = ?");
        $stmt->execute([$id]);
    } 
    elseif ($action === 'valider') {
        // Passage au statut 'Livrée'
        $stmt = $pdo->prepare("UPDATE commandes SET statut = 'Livrée' WHERE id = ?");
        $stmt->execute([$id]);
    }
}

// Redirection propre vers la liste
header('Location: commandes.php');
exit();
?>