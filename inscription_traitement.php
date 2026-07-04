<?php
// On inclut le fichier de connexion en remontant vers le dossier config
require_once 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    // On sécurise le mot de passe
    $pass = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    // On utilise la classe Database définie dans db.php
    $pdo = Database::getConnexion();

    $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$nom, $prenom, $email, $pass, $role])) {
        echo "Inscription réussie ! <a href='index.php'>Retour à l'accueil</a>";
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
// ... après l'exécution de la requête $stmt->execute(...)
if ($role == 'agriculteur') {
    echo "Inscription réussie ! Vous êtes enregistré comme agriculteur. <a href='espace_agriculteur.php'>Accéder à mon espace</a>";
} else {
    echo "Inscription réussie ! Vous êtes enregistré comme client. <a href='index.php'>Retour à l'accueil</a>";
}
?>