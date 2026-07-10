<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: connexion.php');
    exit();
}
// 1. Connexion à la base de données
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

// 2. Vérification que le formulaire a bien été envoyé en POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 3. Récupération des données du formulaire (voir ajouter_produit.php)
    $nom = $_POST['nom_produit'];
    $description = $_POST['description'] ?? '';
    $prix = $_POST['prix'];
    $stock = $_POST['quantite_stock'] ?? 0;
    $image_url = null;

    // 3bis. Traitement de l'upload de la photo (si un fichier valide a été envoyé)
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $extensions_autorisees = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'avif'];
        $extension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (in_array($extension, $extensions_autorisees, true)) {
            $dossier_upload = __DIR__ . '/../IMAGE/produits/';
            if (!is_dir($dossier_upload)) {
                mkdir($dossier_upload, 0755, true);
            }

            $nom_fichier = uniqid('produit_', true) . '.' . $extension;
            $chemin_destination = $dossier_upload . $nom_fichier;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $chemin_destination)) {
                // Chemin relatif stocké en base, utilisable depuis catalogue.php
                $image_url = 'IMAGE/produits/' . $nom_fichier;
            }
        }
    }

    // 4. Préparation et exécution de la requête
    $stmt = $pdo->prepare("INSERT INTO produits (nom_produit, description, prix, image_url, stock) VALUES (?, ?, ?, ?, ?)");

    if ($stmt->execute([$nom, $description, $prix, $image_url, $stock])) {
        // 5. Redirection vers la liste des produits après succès
        header('Location: produits.php?message=succes_ajout');
        exit();
    } else {
        echo "Erreur lors de l'ajout.";
    }
}
?>
