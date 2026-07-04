<?php
// On s'assure que le chemin vers le fichier est correct
require_once __DIR__ . '/config/db.php';

$message_db = "En attente...";

try {
    // Appel de la classe Database
    $pdo = Database::getConnexion();
    $message_db = "Connexion réussie à la base de données green_galsen !";
} catch (Exception $e) {
    $message_db = "Erreur de connexion : " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html>
<body>
    <h1>Bienvenue sur Green Galsén</h1>
    <p><?php echo $message_db; ?></p>
</body>
</html>s