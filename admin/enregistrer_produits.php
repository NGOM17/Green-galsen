<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: connexion.php');
    exit();
}
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    $nom = $_POST['nom_produit'];
    $prix = $_POST['prix'];

    if ($action === 'ajouter') {
        $stmt = $pdo->prepare("INSERT INTO produits (nom_produit, prix) VALUES (?, ?)");
        $stmt->execute([$nom, $prix]);
    } 
    elseif ($action === 'modifier') {
        $id = $_POST['id_produit'];
        $stmt = $pdo->prepare("UPDATE produits SET nom_produit = ?, prix = ? WHERE id_produit = ?");
        $stmt->execute([$nom, $prix, $id]);
    }

    header('Location: produits.php?message=EEnregistrer avec succes');
    exit();
}
?>