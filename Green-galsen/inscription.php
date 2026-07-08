<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Inscription - Green Galsen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 500px;">
        <div class="card shadow-sm p-4 bg-white">
            <h2 class="text-success mb-4 text-center">Rejoignez Green Galsén</h2>
            <form action="inscription_traitement.php" method="POST">
                <div class="mb-3">
                    <input type="text" name="nom" class="form-control" placeholder="Nom" required>
                </div>
                <div class="mb-3">
                    <input type="text" name="prenom" class="form-control" placeholder="Prénom" required>
                </div>
                <div class="mb-3">
                    <input type="email" name="email" class="form-control" placeholder="Adresse Email" required>
                </div>
                <div class="mb-3">
                    <input type="password" name="mot_de_passe" class="form-control" placeholder="Mot de passe" required>
                </div>
                <div class="mb-3">
                    <label class="form-label text-muted">Vous êtes :</label>
                    <select name="role" class="form-select">
                        <option value="client">Client</option>
                        <option value="agriculteur">Agriculteur</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-success w-100 mt-2">S'inscrire</button>
            </form>
            <div class="text-center mt-3">
                <a href="liste_utilisateurs.php" class="text-decoration-none text-secondary small">Voir la liste des membres</a>
            </div>
        </div>
    </div>
</body>
</html>