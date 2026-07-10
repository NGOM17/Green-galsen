<?php
/**
 * VERIFICATION DE CONNEXION - ESPACE CLIENT
 * ------------------------------------------------------------------
 * COMPTE DE TEST (pour la correction) :
 *   Email    : client.test@greengalsen.com
 *   Mot de passe : Client@2026
 * -> Ce compte est créé/mis à jour en exécutant une seule fois, dans
 *    le navigateur, le script : /_setup/creer_comptes_test.php
 * ------------------------------------------------------------------
 */
session_start();
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Recherche du client dans la table utilisateurs
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE email = ? AND role = 'client'");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['client_logged_in'] = true;
        $_SESSION['client_id'] = $user['id_utilisateur'];
        $_SESSION['client_email'] = $user['email'];

        header('Location: acceuil_client.php');
        exit();
    } else {
        header('Location: connexion_client.php?erreur=1');
        exit();
    }
}
?>
