<?php
/**
 * ============================================================================
 *  SCRIPT DE SEED - COMPTES DE TEST POUR LA CORRECTION
 * ============================================================================
 *  A quoi ça sert ?
 *  Ce script crée (ou met à jour si ils existent déjà) deux comptes avec
 *  un mot de passe EN CLAIR connu, pour que le correcteur puisse se
 *  connecter facilement sans avoir à s'inscrire lui-même :
 *
 *      ESPACE CLIENT (client/connexion_client.php)
 *          Email        : client.test@greengalsen.com
 *          Mot de passe : Client@2026
 *
 *      ESPACE ADMIN / VENDEUR (admin/connexion.php)
 *          Email        : admin.test@greengalsen.com
 *          Mot de passe : Admin@2026
 *          (statut directement mis à 'approuvé', donc connexion immédiate)
 *
 *  Comment l'utiliser ?
 *      1. Placez ce fichier dans le dossier _setup/ à la racine du projet
 *         (déjà fait si vous avez le zip fourni).
 *      2. Ouvrez http://localhost/Green-galsen/_setup/creer_comptes_test.php
 *         dans votre navigateur UNE SEULE FOIS.
 *      3. Vous verrez un message de confirmation.
 *      4. Supprimez ce fichier (ou le dossier _setup/) avant de mettre le
 *         site en ligne / de le rendre pour de vrai : il ne doit jamais
 *         être accessible publiquement, car il permet de recréer un
 *         compte avec un mot de passe connu.
 * ============================================================================
 */

require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

$messages = [];

// ---------------------------------------------------------------------------
// 1. Compte client de test
// ---------------------------------------------------------------------------
$emailClient = 'client.test@greengalsen.com';
$passwordClient = 'Client@2026';
$hashClient = password_hash($passwordClient, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("SELECT id_utilisateur FROM utilisateurs WHERE email = ?");
$stmt->execute([$emailClient]);
$existant = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existant) {
    $pdo->prepare("UPDATE utilisateurs SET password = ?, role = 'client' WHERE id_utilisateur = ?")
        ->execute([$hashClient, $existant['id_utilisateur']]);
    $messages[] = "Compte client de test mis à jour (id {$existant['id_utilisateur']}).";
} else {
    $pdo->prepare("INSERT INTO utilisateurs (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, 'client')")
        ->execute(['Test', 'Correcteur', $emailClient, $hashClient]);
    $messages[] = "Compte client de test créé.";
}

// ---------------------------------------------------------------------------
// 2. Compte admin / vendeur de test (statut approuvé directement)
// ---------------------------------------------------------------------------
$emailAdmin = 'admin.test@greengalsen.com';
$passwordAdmin = 'Admin@2026';
$hashAdmin = password_hash($passwordAdmin, PASSWORD_DEFAULT);

$stmt = $pdo->prepare("SELECT id FROM vendeurs WHERE email = ?");
$stmt->execute([$emailAdmin]);
$existant = $stmt->fetch(PDO::FETCH_ASSOC);

if ($existant) {
    $pdo->prepare("UPDATE vendeurs SET password = ?, statut = 'approuvé' WHERE id = ?")
        ->execute([$hashAdmin, $existant['id']]);
    $messages[] = "Compte admin de test mis à jour (id {$existant['id']}).";
} else {
    $pdo->prepare("INSERT INTO vendeurs (nom, email, password, statut) VALUES (?, ?, ?, 'approuvé')")
        ->execute(['Correcteur Admin', $emailAdmin, $hashAdmin]);
    $messages[] = "Compte admin de test créé.";
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Création des comptes de test - Green Galsen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card p-4 shadow-sm">
            <h3 class="text-success mb-3">Comptes de test prêts ✅</h3>
            <ul>
                <?php foreach ($messages as $m): ?>
                    <li><?= htmlspecialchars($m) ?></li>
                <?php endforeach; ?>
            </ul>
            <hr>
            <h5>Espace client</h5>
            <p>URL : <code>client/connexion_client.php</code><br>
               Email : <code><?= htmlspecialchars($emailClient) ?></code><br>
               Mot de passe : <code><?= htmlspecialchars($passwordClient) ?></code></p>
            <h5>Espace admin</h5>
            <p>URL : <code>admin/connexion.php</code><br>
               Email : <code><?= htmlspecialchars($emailAdmin) ?></code><br>
               Mot de passe : <code><?= htmlspecialchars($passwordAdmin) ?></code></p>
            <div class="alert alert-warning mt-3 mb-0">
                ⚠️ Pensez à supprimer ce fichier (ou tout le dossier <code>_setup/</code>)
                avant de mettre le site en ligne publiquement.
            </div>
        </div>
    </div>
</body>
</html>
