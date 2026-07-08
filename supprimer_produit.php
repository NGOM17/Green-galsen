<?php
require_once 'config/db.php';

if (!isset($_GET['id'])) {
    header("Location: gestion_produits.php");
    exit;
}

$id_produit = $_GET['id'];
$pdo = Database::getConnexion();

// On récupère d'abord l'image pour pouvoir la supprimer du serveur
$stmt = $pdo->prepare("SELECT image_url FROM produits WHERE id_produit = ?");
$stmt->execute([$id_produit]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if ($produit) {
    // Suppression de la ligne en base
    $delete = $pdo->prepare("DELETE FROM produits WHERE id_produit = ?");
    $delete->execute([$id_produit]);

    // Suppression physique de l'image si elle existe
    if (!empty($produit['image_url']) && file_exists($produit['image_url'])) {
        unlink($produit['image_url']);
    }
}

header("Location: gestion_produits.php?succes=suppression");
exit;
?>