<?php
require_once 'config/db.php';

// On récupère la connexion
$pdo = Database::getConnexion();

// On récupère tous les utilisateurs
$query = $pdo->query("SELECT * FROM utilisateurs ORDER BY id_utilisateur DESC");
$utilisateurs = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des utilisateurs - Green Galsen</title>
    <style>
        table { width: 80%; border-collapse: collapse; margin: 20px 0; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h1>Utilisateurs inscrits sur Green Galsen</h1>
    <table>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Rôle</th>
        </tr>
        <?php foreach ($utilisateurs as $user): ?>
        <tr>
            <td><?php echo htmlspecialchars($user['id_utilisateur']); ?></td>
            <td><?php echo htmlspecialchars($user['nom']); ?></td>
            <td><?php echo htmlspecialchars($user['prenom']); ?></td>
            <td><?php echo htmlspecialchars($user['email']); ?></td>
            <td><?php echo htmlspecialchars($user['role']); ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="inscription.php">Ajouter un utilisateur</a>
</body>
</html>