<?php
session_start();

// Sécurité : seul un admin connecté peut accéder à cette page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: connexion.php');
    exit();
}
// 2. Connexion à la BDD
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

// 3. Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération des données du formulaire
    $utilisateur_id = $_POST['utilisateur_id'];
    $total_prix = $_POST['total_prix'];
    $statut = $_POST['statut'] ?? 'En attente'; // Défaut à 'En attente' si non spécifié

    // Validation simple
    if (!empty($utilisateur_id) && !empty($total_prix)) {
        
        // Insertion sécurisée
        $sql = "INSERT INTO commandes (utilisateur_id, total_prix, statut, date_commande) VALUES (?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$utilisateur_id, $total_prix, $statut]);
        
        // Redirection après succès
        header('Location: commandes.php?succes=1');
        exit();
    } else {
        $erreur = "Veuillez remplir tous les champs.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Enregistrer une commande</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 col-md-6 mx-auto">
            <h3>Nouvelle Commande</h3>
            <?php if (isset($erreur)): ?><div class="alert alert-danger"><?= $erreur ?></div><?php endif; ?>
            
            <form method="POST">
                <div class="mb-3">
                    <label>ID Utilisateur</label>
                    <input type="number" name="utilisateur_id" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Total Prix</label>
                    <input type="number" name="total_prix" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label>Statut</label>
                    <select name="statut" class="form-control">
                        <option value="En attente">En attente</option>
                        <option value="Livrée">Livrée</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success">Enregistrer</button>
                <a href="commandes.php" class="btn btn-link">Annuler</a>
            </form>
        </div>
    </div>
</body>
</html>