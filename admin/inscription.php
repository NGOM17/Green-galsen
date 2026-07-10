<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devenir vendeur | Green Galsen</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../CSS/auth.css">
</head>
<body class="auth-body">

    <div class="auth-wrapper">

        <!-- ================= PANNEAU VISUEL ================= -->
        <div class="auth-visual">
            <div class="leaf-pattern"></div>
            <span class="blob blob-1"></span>
            <span class="blob blob-2"></span>
            <span class="blob blob-3"></span>

            <div class="ag-brand">
                <i class="fa-solid fa-seedling"></i>
                Green <span>Galsen</span>
            </div>

            <div class="ag-hero">
                <span class="eyebrow"><i class="fa-solid fa-handshake"></i>&nbsp; Rejoignez nos producteurs</span>
                <h1>Vendez vos récoltes à <em>plus de clients</em></h1>
                <p>Créez votre compte vendeur et proposez fruits, légumes, plantes et greffons directement aux consommateurs de votre région.</p>

                <ul class="ag-features">
                    <li><i class="fa-solid fa-users"></i> Une communauté de clients fidèles</li>
                    <li><i class="fa-solid fa-shield-heart"></i> Un espace vendeur validé et sécurisé</li>
                    <li><i class="fa-solid fa-coins"></i> Des ventes gérées simplement, sans intermédiaire</li>
                </ul>
            </div>

            <p class="ag-footnote">&copy; <?= date('Y') ?> Green Galsen — Produits agricoles locaux</p>
        </div>

        <!-- ================= FORMULAIRE ================= -->
        <div class="auth-form-side">
            <div class="auth-card">

                <a href="../index.php" class="ag-back-home"><i class="fa-solid fa-arrow-left"></i> Retour au site</a>

                <div class="ag-icon-badge"><i class="fa-solid fa-store"></i></div>
                <h2>Devenir vendeur</h2>
                <p class="ag-subtitle">Renseignez vos informations pour créer votre boutique.</p>

                <form action="traitement_inscription.php" method="POST">
                    <div class="ag-form-group">
                        <label for="nom">Nom complet</label>
                        <i class="fa-solid fa-user ag-input-icon"></i>
                        <input type="text" id="nom" name="nom" placeholder="Votre nom complet" required>
                    </div>

                    <div class="ag-form-group">
                        <label for="email">Adresse email</label>
                        <i class="fa-solid fa-envelope ag-input-icon"></i>
                        <input type="email" id="email" name="email" placeholder="vous@exemple.com" required>
                    </div>

                    <div class="ag-form-group">
                        <label for="password">Mot de passe</label>
                        <i class="fa-solid fa-lock ag-input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Choisissez un mot de passe" required>
                    </div>

                    <button type="submit" class="btn-auth">
                        Créer mon compte <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>

                <p class="ag-switch">Déjà vendeur ? <a href="connexion.php">Se connecter</a></p>

                <div class="ag-demo-hint">
                    <i class="fa-solid fa-circle-info"></i>&nbsp;
                    Votre compte devra être approuvé avant la première connexion.
                </div>
            </div>
        </div>

    </div>

</body>
</html>
