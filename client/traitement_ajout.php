<?php
// 1. Connexion à la base de données
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

// 2. Vérification que le formulaire a bien été envoyé en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // 3. Récupération des données (vérifie que les noms 'nom_produit' et 'prix' 
    // correspondent bien aux attributs 'name' dans ton formulaire HTML)
    $nom = $_POST['nom_produit'];
    $prix = $_POST['prix'];

    // 4. Préparation et exécution de la requête
    $stmt = $pdo->prepare("INSERT INTO produits (nom_produit, prix) VALUES (?, ?)");
    
    if ($stmt->execute([$nom, $prix])) {
        // 5. Redirection vers la liste des produits après succès
        header('Location: produits.php?message=succes_ajout');
        exit();
    } else {
        echo "Erreur lors de l'ajout.";
    }
}
?>