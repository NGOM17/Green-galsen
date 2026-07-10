<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Admin | Green Galsen</title>
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
                <span class="eyebrow"><i class="fa-solid fa-store"></i>&nbsp; Espace vendeur</span>
                <h1>Gérez votre <em>production</em> comme un pro</h1>
                <p>Suivez vos commandes, ajoutez vos produits et pilotez votre activité de vente en quelques clics depuis votre tableau de bord.</p>

                <ul class="ag-features">
                    <li><i class="fa-solid fa-boxes-stacked"></i> Gestion simple de votre catalogue</li>
                    <li><i class="fa-solid fa-chart-line"></i> Suivi en temps réel de vos ventes</li>
                    <li><i class="fa-solid fa-truck"></i> Commandes centralisées et faciles à traiter</li>
                </ul>
            </div>

            <p class="ag-footnote">&copy; <?= date('Y') ?> Green Galsen — Produits agricoles locaux</p>
        </div>

        <!-- ================= FORMULAIRE ================= -->
        <div class="auth-form-side">
            <div class="auth-card">

                <a href="../index.php" class="ag-back-home"><i class="fa-solid fa-arrow-left"></i> Retour au site</a>

                <div class="ag-icon-badge"><i class="fa-solid fa-user-tie"></i></div>
                <h2>Connexion vendeur</h2>
                <p class="ag-subtitle">Accédez à votre espace de gestion Green Galsen.</p>

                <?php if (isset($_GET['erreur'])): ?>
                    <div class="ag-alert ag-alert-error">
                        <i class="fa-solid fa-circle-exclamation"></i>
                        <span>Email ou mot de passe incorrect. Veuillez réessayer.</span>
                    </div>
                <?php endif; ?>

                <form action="verifier_connexion.php" method="POST">
                    <div class="ag-form-group">
                        <label for="email">Adresse email</label>
                        <i class="fa-solid fa-envelope ag-input-icon"></i>
                        <input type="email" id="email" name="email" placeholder="vous@exemple.com" required>
                    </div>

                    <div class="ag-form-group">
                        <label for="password">Mot de passe</label>
                        <i class="fa-solid fa-lock ag-input-icon"></i>
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-auth">
                        Se connecter <i class="fa-solid fa-arrow-right"></i>
                    </button>
                </form>

                <p class="ag-switch">Pas encore vendeur ? <a href="inscription.php">Créer un compte</a></p>

                <div class="ag-demo-hint">
                    <i class="fa-solid fa-flask"></i>&nbsp;
                    Compte de démonstration disponible dans
                    <strong>/_setup/creer_comptes_test.php</strong>
                </div>
            </div>
        </div>

    </div>

</body>
</html>
