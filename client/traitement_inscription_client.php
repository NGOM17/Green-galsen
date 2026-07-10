<?php
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $email = htmlspecialchars($_POST['email']);
    
    // HACHAGE DU MOT DE PASSE (indispensable pour la sécurité)
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Insertion dans la table utilisateurs
    $sql = "INSERT INTO utilisateurs (nom, prenom, email, password, role) VALUES (?, ?, ?, ?, 'client')";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$nom, $prenom, $email, $password])) {
        echo "Inscription réussie ! <a href='connexion_client.php'>Connectez-vous ici</a>";
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>