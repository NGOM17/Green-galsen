<?php
session_start();

// Sécurité : seul un admin connecté peut accéder à cette page
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: connexion.php');
    exit();
}
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

$resultats = [];
// 2. Traitement de la recherche
if (isset($_GET['q']) && !empty($_GET['q'])) {
    $q = $_GET['q'];
    // Recherche par ID de commande ou ID client
    $stmt = $pdo->prepare("SELECT * FROM commandes WHERE id = ? OR utilisateur_id = ?");
    $stmt->execute([$q, $q]);
    $resultats = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Recherche de Commande</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <a href="commandes.php" class="btn btn-secondary mb-3">Retour aux commandes</a>
        <div class="card p-4">
            <h3>Rechercher une commande</h3>
            <form method="GET" class="d-flex mb-4">
                <input type="text" name="q" class="form-control me-2" placeholder="ID commande ou ID client" required>
                <button type="submit" class="btn btn-primary">Rechercher</button>
            </form>

            <?php if (isset($_GET['q'])): ?>
                <h5>Résultats pour : "<?= htmlspecialchars($_GET['q']) ?>"</h5>
                <?php if ($resultats): ?>
                    <table class="table">
                        <thead><tr><th>ID</th><th>Client</th><th>Total</th><th>Statut</th></tr></thead>
                        <tbody>
                            <?php foreach ($resultats as $c): ?>
                            <tr>
                                <td><?= $c['id'] ?></td>
                                <td><?= $c['utilisateur_id'] ?></td>
                                <td><?= $c['total_prix'] ?> FCFA</td>
                                <td><?= $c['statut'] ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>Aucune commande trouvée.</p>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>