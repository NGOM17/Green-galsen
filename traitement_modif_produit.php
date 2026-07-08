<?php
require_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_produit      = $_POST['id_produit'];
    $nom_produit     = trim($_POST['nom_produit']);
    $description     = trim($_POST['description']);
    $prix            = $_POST['prix'];
    $quantite_stock  = $_POST['quantite_stock'];
    $ancienne_image  = $_POST['ancienne_image'];

    // Validation basique côté serveur (à ne jamais faire confiance au seul JS/HTML5)
    if ($nom_produit === ''  $prix <= 0  $quantite_stock < 0) {
        die("Données invalides. <a href='javascript:history.back()'>Retour</a>");
    }

    $image_url = $ancienne_image; // par défaut, on garde l'ancienne image

    // Si une nouvelle image a été envoyée, on la traite
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $target_dir = "uploads/";
        $image_name = time() . "_" . basename($_FILES["image"]["name"]);
        $target_file = $target_dir . $image_name;

        // Vérification simple du type de fichier
        $extensions_autorisees = ['jpg', 'jpeg', 'png', 'webp'];
        $extension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        if (!in_array($extension, $extensions_autorisees)) {
            die("Format d'image non autorisé. <a href='javascript:history.back()'>Retour</a>");
        }

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // On supprime l'ancienne image du serveur pour ne pas accumuler de fichiers inutiles
            if ($ancienne_image && file_exists($ancienne_image)) {
                unlink($ancienne_image);
            }
            $image_url = $target_file;
        } else {
            die("Erreur lors de l'envoi de la nouvelle image. <a href='javascript:history.back()'>Retour</a>");
        }
    }

    $pdo = Database::getConnexion();

    $sql = "UPDATE produits 
            SET nom_produit = ?, description = ?, prix = ?, quantite_stock = ?, image_url = ? 
            WHERE id_produit = ?";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$nom_produit, $description, $prix, $quantite_stock, $image_url, $id_produit]);
        header("Location: gestion_produits.php?succes=modification");
        exit;
    } catch (Exception $e) {
        echo "Erreur lors de la mise à jour : " . $e->getMessage();
    }
}
?>