<?php
session_start();

// Sécurité : seul un admin connecté peut accéder à cette page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: connexion.php');
    exit();
}
require_once __DIR__ . '/../config/db.php';

// Vérification de sécurité : le panier est-il vide ou l'utilisateur est-il connecté ?
if (empty($_SESSION['panier'])) {
header('Location: panier.php');
exit();
}

$pdo = Database::getConnexion();

$message = 'valide';

try {
$pdo->beginTransaction();

// 1. Enregistrer la commande principale
$user_id = $_SESSION['client_id'] ?? 1;
$sql = "INSERT INTO commandes (utilisateur_id, total_prix, statut, date_commande) VALUES (?, 0, 'En attente', NOW())";
$pdo->prepare($sql)->execute([$user_id]);
$commande_id = $pdo->lastInsertId();

$total_final = 0;
$sql_detail = "INSERT INTO details_commande (id_commande, id_produit, quantite, prix_unitaire) VALUES (?, ?, ?, ?)";
$stmt_detail = $pdo->prepare($sql_detail);

// 2. Traiter chaque produit (clé = id_produit, valeur = quantité)
foreach ($_SESSION['panier'] as $id_produit => $quantite) {
$req_prod = $pdo->prepare("SELECT prix FROM produits WHERE id_produit = ?");
$req_prod->execute([$id_produit]);
$produit = $req_prod->fetch(PDO::FETCH_ASSOC);

if ($produit) {
$stmt_detail->execute([$commande_id, $id_produit, $quantite, $produit['prix']]);
$total_final += $produit['prix'] * $quantite;
}
}

// 3. Mettre à jour le prix total de la commande
$pdo->prepare("UPDATE commandes SET total_prix = ? WHERE id = ?")->execute([$total_final, $commande_id]);

$pdo->commit();
unset($_SESSION['panier']);
} catch (Exception $e) {
$pdo->rollBack();
$message = 'erreur';
}
header('Location: commandes.php?message=' . $message);
exit();
?>