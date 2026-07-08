<?php
// On démarre la session obligatoirement avant toute chose
session_start();

// Si le panier n'existe pas encore dans la session, on le crée sous forme de tableau vide
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Vérification de la réception de l'ID du produit
if (isset($_POST['id_produit'])) {
    $id_produit = $_POST['id_produit'];
    
    // Si le produit est déjà dans le panier, on augmente juste la quantité
    if (isset($_SESSION['panier'][$id_produit])) {
        $_SESSION['panier'][$id_produit] += 1;
    } else {
        // Sinon, on ajoute le produit avec une quantité initiale de 1
        $_SESSION['panier'][$id_produit] = 1;
    }
}

// Une fois le traitement terminé, on redirige vers le catalogue de façon transparente
     header("Location: panier.php");
exit;
?>