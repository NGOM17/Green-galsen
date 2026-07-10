<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Green Galsen</title>
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
                <span class="eyebrow"><i class="fa-solid fa-basket-shopping"></i>&nbsp; Nouveau chez nous ?</span>
                <h1>Rejoignez la communauté <em>Green Galsen</em></h1>
                <p>Créez votre compte pour commander des fruits, légumes, plantes et greffons frais directement auprès des producteurs locaux.</p>

                <ul class="ag-features">
                    <li><i class="fa-solid fa-leaf"></i> Des produits frais et locaux</li>
                    <li><i class="fa-solid fa-truck-fast"></i> Livraison suivie de bout en bout</li>
                    <li><i class="fa-solid fa-lock"></i> Vos données protégées et sécurisées</li>
                </ul>
            </div>

            <p class="ag-footnote">&copy; <?= date('Y') ?> Green Galsen — Produits agricoles locaux</p>
        </div>

        <!-- ================= FORMULAIRE ================= -->
        <div class="auth-form-side">
            <div class="auth-card">

                <a href="../index.php" class="ag-back-home"><i class="fa-solid fa-arrow-left"></i> Retour au site</a>

                <div class="ag-icon-badge"><i class="fa-solid fa-user-plus"></i></div>
                <h2>Créer un compte</h2>
                <p class="ag-subtitle">Quelques informations et vous y êtes.</p>

                <form action="traitement_inscription_client.php" method="POST">
                    <div class="ag-two-cols">
                        <div class="ag-form-group">
                            <label for="nom">Nom</label>
                            <i class="fa-solid fa-user ag-input-icon"></i>
                            <input type="text" id="nom" name="nom" placeholder="Votre nom" required>
                        </div>

                        <div class="ag-form-group">
                            <label for="prenom">Prénom</label>
                            <i class="fa-solid fa-user ag-input-icon"></i>
                            <input type="text" id="prenom" name="prenom" placeholder="Votre prénom" required>
                        </div>
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
                        S'inscrire <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>

                <p class="ag-switch">Déjà inscrit ? <a href="connexion_client.php">Se connecter</a></p>
            </div>
        </div>

    </div>

</body>
</html>
