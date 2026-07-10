<?php
// 1. Démarrer la session pour pouvoir y accéder
session_start();

// 2. Supprimer toutes les variables de session
$_SESSION = array();

// 3. Détruire la session sur le serveur
session_destroy();

// 4. Rediriger l'utilisateur vers la page de connexion
header('Location: connexion.php');
exit();
?>