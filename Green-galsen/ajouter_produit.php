<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un Produit - Green Galsén</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow-sm p-4 bg-white">
            <h2 class="text-success mb-4 text-center">Ajouter une récolte</h2>
            
            <!-- L'attribut enctype est OBLIGATOIRE pour pouvoir envoyer une image -->
            <form action="traitement_produit.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Nom du produit</label>
                    <input type="text" name="nom_produit" class="form-control" placeholder="Ex: Tomates cerises" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Description courte</label>
                    <textarea name="description" class="form-control" rows="3" placeholder="Détails du produit..." required></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Prix unitaire (FCFA)</label>
                        <input type="number" step="0.01" name="prix" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Quantité en stock (Kg)</label>
                        <input type="number" name="quantite_stock" class="form-control" required>
                    </div>
                </div>
                
                <div class="mb-4">
                    <label class="form-label">Photo du produit</label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>
                
                <button type="submit" class="btn btn-success w-100">Mettre en vente</button>
            </form>
        </div>
    </div>
</body>
</html>