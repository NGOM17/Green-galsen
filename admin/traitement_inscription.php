<?php
require_once __DIR__ . '/../config/db.php';
$pdo = Database::getConnexion();

$success = false;
$errorMsg = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nom = htmlspecialchars($_POST['nom']);
    $email = htmlspecialchars($_POST['email']);
    // HACHAGE DU MOT DE PASSE (indispensable)
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Le compte est directement approuvé : le vendeur peut se connecter
    // immédiatement après son inscription, sans validation manuelle.
    $sql = "INSERT INTO vendeurs (nom, email, password, statut) VALUES (?, ?, ?, 'approuvé')";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$nom, $email, $password])) {
        $success = true;
    } else {
        $errorMsg = "Une erreur est survenue lors de l'inscription. Veuillez réessayer.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $success ? "Inscription réussie" : "Inscription" ?> | Green Galsen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../CSS/auth.css">
</head>
<body class="auth-body">

    <div class="status-page">
        <div class="status-card">
            <?php if ($success): ?>
                <div class="status-icon success"><i class="fa-solid fa-check"></i></div>
                <h2>Bienvenue chez Green Galsen !</h2>
                <p>Votre compte vendeur a été créé et activé avec succès. Vous pouvez dès maintenant vous connecter à votre espace de gestion.</p>
                <a href="connexion.php" class="btn-auth">Se connecter <i class="fa-solid fa-arrow-right"></i></a>
            <?php else: ?>
                <div class="status-icon error"><i class="fa-solid fa-triangle-exclamation"></i></div>
                <h2>Inscription impossible</h2>
                <p><?= htmlspecialchars($errorMsg ?: "Cet email est peut-être déjà utilisé, ou une erreur technique est survenue.") ?></p>
                <a href="inscription.php" class="btn-auth">Réessayer <i class="fa-solid fa-arrow-rotate-right"></i></a>
            <?php endif; ?>

            <a href="../index.php" class="status-link"><i class="fa-solid fa-arrow-left"></i> Retour au site</a>
        </div>
    </div>

</body>
</html>
