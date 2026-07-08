<?php
require_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom_produit = $_POST['nom_produit'];
    $description = $_POST['description'];
    $prix = $_POST['prix'];
    $quantite_stock = $_POST['quantite_stock'];
    
    // Dossier où seront stockées les images
    $target_dir = "uploads/";
    
    // On ajoute un timestamp devant le nom du fichier pour éviter les doublons
    $image_name = time() . "_" . basename($_FILES["image"]["name"]);
    $target_file = $target_dir . $image_name;
    
    // Déplacement de l'image du dossier temporaire vers le dossier 'uploads'
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $pdo = Database::getConnexion();
        
        // Note pour l'équipe : Pour les tests actuels, on force l'id_agriculteur à 1.
        // Dès que le système de connexion (session) sera prêt, on utilisera $_SESSION['id_agriculteur'].
        $id_agriculteur = 1; 

        $sql = "INSERT INTO produits (id_agriculteur, nom_produit, description, prix, quantite_stock, image_url) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        
        try {
            $stmt->execute([$id_agriculteur, $nom_produit, $description, $prix, $quantite_stock, $target_file]);
            echo "<div style='font-family: sans-serif; padding: 20px;'>";
            echo "<h2>Félicitations ! Le produit a été mis en ligne avec succès.</h2>";
            echo "<a href='ajouter_produit.php'>Ajouter un autre produit</a>";
            echo "</div>";
        } catch (Exception $e) {
            echo "Erreur d'enregistrement en base de données : " . $e->getMessage();
        }
    } else {
        echo "Erreur critique : Impossible de télécharger l'image. Vérifie que le dossier 'uploads' existe bien.";
    }
}
?>