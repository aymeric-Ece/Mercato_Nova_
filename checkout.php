<?php
session_start();

$host = "localhost";
$dbname = "mercato_nova";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur connexion base de données.");
}

$utilisateur_id = $_SESSION['utilisateur_id'] ?? 1;

// 1. Récupération des éléments du panier pour affichage et calculs
$requete = $pdo->prepare("
    SELECT panier.quantite, produits.id AS produit_id, produits.nom, produits.prix, produits.image 
    FROM panier 
    INNER JOIN produits ON panier.produit_id = produits.id 
    WHERE panier.utilisateur_id = ?
");
$requete->execute([$utilisateur_id]);
$liste_panier = $requete->fetchAll(PDO::FETCH_ASSOC);

// Si le panier est vide, impossible de payer
if (empty($liste_panier)) {
    header("Location: panier.php");
    exit;
}

$total = 0;
foreach ($liste_panier as $item) {
    $total += $item['prix'] * $item['quantite'];
}

// 2. Traitement du formulaire de paiement
$erreur = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // On simule une validation de carte (toutes les données fictives fonctionnent)
    $nom = trim($_POST['nom_carte'] ?? '');
    $numero = trim($_POST['num_carte'] ?? '');
    
    if (empty($nom) || empty($numero)) {
        $erreur = "Veuillez remplir les informations de carte bancaire.";
    } else {
        try {
            // Début d'une transaction pour s'assurer que tout s'exécute correctement
            $pdo->beginTransaction();

            // A. Insertion dans la table 'commandes'
            $stmtCommande = $pdo->prepare("INSERT INTO commandes (utilisateur_id, total, statut, date_commande) VALUES (?, ?, ?, NOW())");
            // Statut par défaut : 'Payée'
            $stmtCommande->execute([$utilisateur_id, $total, 'Payée']);
            
            // Récupération de l'ID de la commande venant d'être créée
            $commande_id = $pdo->lastInsertId();

            // B. Insertion des articles dans 'details_commandes'
            $stmtDetails = $pdo->prepare("INSERT INTO details_commandes (commande_id, produit_id, quantite, prix) VALUES (?, ?, ?, ?)");
            foreach ($liste_panier as $item) {
                $stmtDetails->execute([
                    $commande_id,
                    $item['produit_id'],
                    $item['quantite'],
                    $item['prix']
                ]);
            }

            // C. Nettoyage du panier de l'utilisateur
            $stmtViderPanier = $pdo->prepare("DELETE FROM panier WHERE utilisateur_id = ?");
            $stmtViderPanier->execute([$utilisateur_id]);

            // Validation définitive de la transaction
            $pdo->commit();

            // Redirection vers la page de succès avec l'ID de commande
            $_SESSION['derniere_commande'] = $commande_id;
            header("Location: confirmation.php");
            exit;

        } catch (Exception $e) {
            // En cas de problème de base de données, on annule les modifications
            $pdo->rollBack();
            $erreur = "Une erreur est survenue lors de la validation de la commande : " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paiement Sécurisé - Mercato Nova</title>
    <style>
        * { 
		margin: 0; 
		padding: 0; 
		box-sizing: 
		border-box; 
		font-family: Arial, sans-serif; }
        body { 
		background-color: #f8fafc; 
		color: #0f172a; 
		}
        
        nav { 
		display: flex; 
		justify-content: space-between; 
		align-items: center; 
		padding: 20px 60px; 
		background-color: #0f172a; 
		border-bottom: 1px solid #1e293b; 
		}
        .logo { 
		font-size: 30px; 
		font-weight: bold; 
		color: #38bdf8; 
		text-decoration: none; 
		}

        .checkout-container { 
		display: flex; 
		max-width: 1200px; 
		margin: 40px auto; 
		gap: 40px; 
		padding: 0 20px; 
		}
        
        /* Formulaire de gauche */
        .payment-form { 
		flex: 1.4; 
		background: white; 
		padding: 40px; 
		border-radius: 18px; 
		box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
		}
        .payment-form h1 { 
		font-size: 28px; 
		margin-bottom: 25px; 
		display: flex; 
		align-items: center; 
		gap: 10px; 
		}
        .form-section { 
		margin-bottom: 30px; 
		}
        .form-section h3 { 
		font-size: 18px; 
		margin-bottom: 15px; 
		color: #334155; 
		border-bottom: 2px solid #f1f5f9; 
		padding-bottom: 8px; 
		}
        
        .form-group { 
		margin-bottom: 15px; 
		}
        .form-row { 
		display: flex; gap: 15px; 
		}
        .form-row .form-group { 
		flex: 1; 
		}
        
        label { 
		display: block; 
		font-size: 14px; 
		font-weight: bold; 
		margin-bottom: 6px; 
		color: #475569; 
		}
        input[type="text"], input[type="email"] { 
		width: 100%; 
		padding: 12px; 
		border: 1px solid #cbd5e1; 
		border-radius: 8px; 
		font-size: 15px; 
		transition: 0.3s; 
		}
        input:focus { 
		outline: none; 
		border-color: #38bdf8; 
		box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.2); 
		}
        
        .alert-error { 
		background-color: #fef2f2; 
		color: #ef4444; 
		padding: 12px; 
		border-radius: 8px; 
		margin-bottom: 20px; 
		font-weight: bold; 
		border-left: 4px solid #ef4444; 
		}
        
        .pay-btn { 
		width: 100%; 
		background-color: #0f172a; 
		color: white; 
		padding: 16px; 
		border: none; 
		border-radius: 12px; 
		font-size: 18px; 
		font-weight: bold; 
		cursor: pointer; 
		transition: 0.3s; 
		margin-top: 10px; 
		}
        .pay-btn:hover { 
		background-color: #1e293b; 
		}

        /* Récapitulatif de droite */
        .order-summary { 
		flex: 1; 
		background: white; 
		padding: 30px; 
		border-radius: 18px; 
		height: fit-content; 
		box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
		position: sticky; 
		top: 20px; 
		}
        .order-summary h2 { 
		font-size: 20px; 
		margin-bottom: 20px; 
		color: #0f172a; 
		}
        
        .summary-item { 
		display: flex; 
		align-items: center; 
		gap: 15px; 
		padding: 15px 0; 
		border-bottom: 1px solid #f1f5f9; 
		}
        .summary-item img { 
		width: 60px; 
		height: 60px; 
		object-fit: cover; 
		border-radius: 8px; 
		}
        .item-details { 
		flex: 1; 
		}
        .item-details h4 { 
		font-size: 15px; 
		color: #1e293b; 
		margin-bottom: 4px; 
		}
        .item-details p { 
		font-size: 13px; 
		color: #64748b; 
		}
        .item-price { 
		font-weight: bold; 
		color: #0f172a; 
		}
        
        .price-line { 
		display: flex; 
		justify-content: space-between; 
		margin-top: 15px; 
		font-size: 16px; 
		color: #475569; 
		}
        .price-line.total { 
		border-top: 2px dashed #e2e8f0; 
		padding-top: 15px; 
		font-size: 22px; 
		font-weight: bold; 
		color: #0284c7; 
		}
        
        footer { 
		background-color: #0f172a; 
		text-align: center; 
		padding: 25px; 
		color: white; 
		margin-top: 80px; 
		}
        
        @media (max-width: 900px) { 
			.checkout-container { 
			flex-direction: column-reverse; 
			} 
			.order-summary { 
			position: static; 
			} 
		}
    </style>
</head>
<body>

    <nav>
        <a href="accueil.php" class="logo">Mercato Nova</a>
    </nav>

    <div class="checkout-container">
        <main class="payment-form">
            <h1>🔒 Paiement Sécurisé</h1>
            <p style="color: #64748b; margin-bottom: 25px;">Complétez votre commande en toute sécurité. Les données de test sont acceptées.</p>

            <?php if (!empty($erreur)): ?>
                <div class="alert-error"><?= htmlspecialchars($erreur) ?></div>
            <?php endif; ?>

            <form method="POST" action="checkout.php">
                <div class="form-section">
                    <h3>1. Adresse de livraison</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Prénom</label>
                            <input type="text" name="prenom" placeholder="Jean" required>
                        </div>
                        <div class="form-group">
                            <label>Nom</label>
                            <input type="text" name="nom" placeholder="Dupond" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Adresse postale</label>
                        <input type="text" name="adresse" placeholder="12 Rue de la Paix" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Code Postal</label>
                            <input type="text" name="cp" placeholder="75002" required>
                        </div>
                        <div class="form-group">
                            <label>Ville</label>
                            <input type="text" name="ville" placeholder="Paris" required>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3>2. Mode de paiement (Carte Bancaire)</h3>
                    <div class="form-group">
                        <label>Nom sur la carte</label>
                        <input type="text" name="nom_carte" placeholder="Jean Dupond" required>
                    </div>
                    <div class="form-group">
                        <label>Numéro de carte</label>
                        <input type="text" name="num_carte" placeholder="4970 1234 5678 9000" maxlength="19" required>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label>Date d'expiration</label>
                            <input type="text" name="exp" placeholder="MM/YY" maxlength="5" required>
                        </div>
                        <div class="form-group">
                            <label>Code de sécurité (CVV)</label>
                            <input type="text" name="cvv" placeholder="123" maxlength="3" required>
                        </div>
                    </div>
                </div>

                <button type="submit" class="pay-btn">Confirmer et Payer <?= number_format($total, 0, ',', ' ') ?>€</button>
            </form>
        </main>

        <aside class="order-summary">
            <h2>Résumé de la commande</h2>
            
            <?php foreach ($liste_panier as $item): ?>
                <div class="summary-item">
                    <img src="<?= htmlspecialchars($item['image'] ?? 'uploads/default.jpg') ?>" alt="<?= htmlspecialchars($item['nom']) ?>">
                    <div class="item-details">
                        <h4><?= htmlspecialchars($item['nom']) ?></h4>
                        <p>Qté: <?= $item['quantite'] ?></p>
                    </div>
                    <div class="item-price"><?= number_format($item['prix'] * $item['quantite'], 0, ',', ' ') ?>€</div>
                </div>
            <?php endforeach; ?>

            <div class="price-line">
                <span>Sous-total</span>
                <span><?= number_format($total, 0, ',', ' ') ?>€</span>
            </div>
            <div class="price-line">
                <span>Livraison</span>
                <span style="color: #22c55e; font-weight: bold;">Gratuite</span>
            </div>
            <div class="price-line total">
                <span>Total à payer</span>
                <span><?= number_format($total, 0, ',', ' ') ?>€</span>
            </div>
        </aside>
    </div>

    <footer>
        <p>© 2026 Mercato Nova - Tunnel de paiement de démonstration</p>
    </footer>

</body>
</html>
