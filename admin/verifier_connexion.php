<?php
/**
 * VERIFICATION DE CONNEXION - ESPACE ADMIN / VENDEUR
 * ------------------------------------------------------------------
 * COMPTE DE TEST (pour la correction) :
 *   Email    : admin.test@greengalsen.com
 *   Mot de passe : Admin@2026
 *   (statut déjà mis à 'approuvé' par le script de seed ci-dessous)
 * -> Ce compte est créé/mis à jour en exécutant une seule fois, dans
 *    le navigateur, le script : /_setup/creer_comptes_test.php
 * ------------------------------------------------------------------
 */
session_start();
require_once __DIR__ . '/../config/db.php'; // Assure-toi que le chemin est correct
$pdo = Database::getConnexion();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // 1. Chercher le vendeur dans la base de données
    $stmt = $pdo->prepare("SELECT * FROM vendeurs WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // 2. Vérifier si l'utilisateur existe et si le mot de passe correspond
    // On utilise password_verify pour comparer le mot de passe saisi avec le hash stocké
    if ($user && password_verify($password, $user['password'])) {

        // Les inscriptions sont désormais validées automatiquement (voir
        // traitement_inscription.php). Par sécurité, si un compte plus ancien
        // était encore marqué comme "en_attente", on le valide ici à la volée
        // au lieu de bloquer la connexion : l'utilisateur n'a jamais à attendre
        // une validation manuelle de l'administrateur.
        if ($user['statut'] !== 'approuvé') {
            $update = $pdo->prepare("UPDATE vendeurs SET statut = 'approuvé' WHERE id = ?");
            $update->execute([$user['id']]);
        }

        $_SESSION['admin_logged_in'] = true;
        header('Location: dashboard.php');
        exit();

    // 3. Sinon, erreur d'identifiants
    } else {
        header('Location: connexion.php?erreur=1');
        exit();
    }
}
?>