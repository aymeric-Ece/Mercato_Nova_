<?php
session_start();

// CONNEXION MYSQL
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

// ID de l'utilisateur connecté (Lier à votre session, de test = 1)
$utilisateur_id = $_SESSION['utilisateur_id'] ?? null;

// Si l'utilisateur n'est pas connecté, on le redirige vers la page de connexion
if (!$utilisateur_id) {
    header("Location: connexion.html");
    exit();
}

$message = "";

// ==========================================
// TRRAITEMENT DES ACTIONS (Ajout, Modif, Suppr)
// ==========================================
if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $produit_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    // 1. AJOUTER UN PRODUIT AU PANIER
    if ($action === 'add' && $produit_id > 0) {
        // Vérifier si le produit est déjà dans le panier
        $verif = $pdo->prepare("SELECT id, quantite FROM panier WHERE utilisateur_id = ? AND produit_id = ?");
        $verif->execute([$utilisateur_id, $produit_id]);
        $existe = $verif->fetch();

        if ($existe) {
            // Si le produit existe déjà, on augmente la quantité de 1
            $nouvelle_qte = $existe['quantite'] + 1;
            $update = $pdo->prepare("UPDATE panier SET quantite = ? WHERE id = ?");
            $update->execute([$nouvelle_qte, $existe['id']]);
        } else {
            // Sinon, on l'insère avec une quantité de 1
            $insert = $pdo->prepare("INSERT INTO panier (utilisateur_id, produit_id, quantite) VALUES (?, ?, 1)");
            $insert->execute([$utilisateur_id, $produit_id]);
        }
        header("Location: panier.php");
        exit;
    }

    // 2. MODIFIER LA QUANTITÉ (+ ou -)
    if (($action === 'increase' || $action === 'decrease') && $produit_id > 0) {
        $verif = $pdo->prepare("SELECT id, quantite FROM panier WHERE utilisateur_id = ? AND produit_id = ?");
        $verif->execute([$utilisateur_id, $produit_id]);
        $item = $verif->fetch();

        if ($item) {
            if ($action === 'increase') {
                $nouvelle_qte = $item['quantite'] + 1;
            } else {
                $nouvelle_qte = $item['quantite'] - 1;
            }

            if ($nouvelle_qte > 0) {
                $update = $pdo->prepare("UPDATE panier SET quantite = ? WHERE id = ?");
                $update->execute([$nouvelle_qte, $item['id']]);
            } else {
                // Si la quantité tombe à 0, on supprime le produit du panier
                $delete = $pdo->prepare("DELETE FROM panier WHERE id = ?");
                $delete->execute([$item['id']]);
            }
        }
        header("Location: panier.php");
        exit;
    }

    // 3. RETIRER UN PRODUIT COMPLETEMENT
    if ($action === 'delete' && $produit_id > 0) {
        $delete = $pdo->prepare("DELETE FROM panier WHERE utilisateur_id = ? AND produit_id = ?");
        $delete->execute([$utilisateur_id, $produit_id]);
        header("Location: panier.php");
        exit;
    }
}

// ==========================================
// RECUPERATION DES PRODUITS DU PANIER
// ==========================================
try {
    $requete = $pdo->prepare("
        SELECT 
            panier.produit_id,
            panier.quantite,
            produits.nom,
            produits.description,
            produits.prix,
            produits.image
        FROM panier
        INNER JOIN produits ON panier.produit_id = produits.id
        WHERE panier.utilisateur_id = ?
    ");
    $requete->execute([$utilisateur_id]);
    $liste_panier = $requete->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération du panier : " . $e->getMessage());
}

// Calcul du sous-total global
$sous_total = 0;
foreach ($liste_panier as $item) {
    $sous_total += $item['prix'] * $item['quantite'];
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - Mercato Nova</title>
    <style>
        /* [Vos styles CSS d'origine restent identiques] */
        *{ margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, Helvetica, sans-serif; }
        body{ background-color: #f8fafc; color: #0f172a; }
        nav{ display: flex; justify-content: space-between; align-items: center; padding: 20px 60px; background-color: #0f172a; border-bottom: 1px solid #1e293b; }
        .logo{ font-size: 30px; font-weight: bold; color: #38bdf8; }
        nav ul{ display: flex; list-style: none; gap: 30px; align-items: center; }
        nav ul li a{ text-decoration: none; color: white; transition: 0.3s; font-size: 17px; }
        nav ul li a:hover{ color: #38bdf8; }
        .page-title{ padding: 50px 60px 20px; }
        .page-title h1{ font-size: 42px; margin-bottom: 10px; }
        .page-title p{ color: #64748b; font-size: 18px; }
        .cart-container{ display: flex; gap: 40px; padding: 20px 60px 80px; }
        .cart-products{ flex: 2; display: flex; flex-direction: column; gap: 25px; }
        .cart-card{ background-color: white; border-radius: 18px; padding: 20px; display: flex; gap: 25px; align-items: center; box-shadow: 0 3px 10px rgba(0,0,0,0.08); transition: 0.3s; }
        .cart-card:hover{ transform: translateY(-5px); }
        .cart-card img{ width: 220px; height: 180px; object-fit: cover; border-radius: 12px; }
        .product-info{ flex: 1; }
        .product-info h2{ margin-bottom: 10px; }
        .product-info p{ color: #64748b; margin-bottom: 15px; line-height: 1.5; }
        .price{ color: #0284c7; font-size: 28px; font-weight: bold; }
        .quantity{ display: flex; align-items: center; gap: 10px; margin-top: 20px; }
        .quantity .btn-qty{ display: flex; justify-content: center; align-items: center; text-decoration: none; width: 35px; height: 35px; border: none; border-radius: 8px; background-color: #0f172a; color: white; cursor: pointer; font-size: 18px; font-weight: bold; }
        .quantity span{ font-size: 18px; font-weight: bold; }
        .actions{ display: flex; flex-direction: column; gap: 15px; }
        .btn{ display: inline-block; text-align: center; text-decoration: none; padding: 12px 18px; border: none; border-radius: 10px; cursor: pointer; font-weight: bold; transition: 0.3s; min-width: 180px; }
        .btn-view{ background-color: #38bdf8; color: white; }
        .btn-view:hover{ background-color: #0ea5e9; }
        .btn-remove{ background-color: #ef4444; color: white; }
        .btn-remove:hover{ background-color: #dc2626; }
        .summary{ flex: 1; background-color: white; border-radius: 18px; padding: 30px; height: fit-content; box-shadow: 0 3px 10px rgba(0,0,0,0.08); }
        .summary h2{ margin-bottom: 30px; }
        .summary-line{ display: flex; justify-content: space-between; margin-bottom: 20px; font-size: 18px; }
        .total{ font-size: 24px; font-weight: bold; margin-top: 20px; border-top: 1px solid #cbd5e1; padding-top: 20px; }
        .checkout-btn{ width: 100%; padding: 15px; margin-top: 30px; border: none; border-radius: 12px; background-color: #0f172a; color: white; font-size: 18px; font-weight: bold; cursor: pointer; transition: 0.3s; }
        .checkout-btn:hover{ background-color: #1e293b; }
        .empty-cart { text-align: center; padding: 60px; background: white; border-radius: 18px; box-shadow: 0 3px 10px rgba(0,0,0,0.08); width: 100%; }
        .empty-cart a { display: inline-block; margin-top: 20px; padding: 12px 25px; background-color: #38bdf8; color: white; text-decoration: none; border-radius: 10px; font-weight: bold; }
        footer{ background-color: #0f172a; text-align: center; padding: 25px; color: white; border-top: 1px solid #1e293b; }
        @media(max-width: 1000px){ .cart-container{ flex-direction: column; } }
        @media(max-width: 850px){ .cart-card{ flex-direction: column; text-align: center; } .cart-card img{ width: 100%; height: 250px; } .actions{ width: 100%; } .btn{ width: 100%; } .quantity{ justify-content: center; } }
        @media(max-width: 768px){ nav{ flex-direction: column; gap: 20px; } nav ul{ flex-wrap: wrap; justify-content: center; } }
    </style>
</head>
<body>

    <nav>
        <div class="logo">Mercato Nova</div>
        <ul>
            <li><a href="accueil.php">Accueil</a></li>
            <li><a href="catalogue.php">Catalogue</a></li>
            <li><a href="encheres.php">Enchères</a></li>
			<li><a href="mes_annonces.php">Mes annonces</a></li>
			<li><a href="notification.php">🔔 Notifications</a></li>
            <?php if (isset($_SESSION['nom_utilisateur'])): ?>
                <li style="color: #38bdf8; font-weight: bold; font-size: 17px; display: flex; align-items: center; gap: 8px;">
                    👤 <?= htmlspecialchars($_SESSION['nom_utilisateur']); ?>
                    <a href="deconnexion.php" style="color: #ef4444; font-size: 13px; text-decoration: none;" onclick="return confirm('Voulez-vous vous déconnecter ?');">(Déconnexion)</a>
                </li>
            <?php else: ?>
                <li><a href="connexion.html">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <section class="page-title">
        <h1>Mon Panier 🛒</h1>
        <p>Consultez vos produits avant de finaliser votre commande.</p>
    </section>

    <section class="cart-container">
        <?php if (empty($liste_panier)): ?>
            <div class="empty-cart">
                <h2>Votre panier est vide 😮</h2>
                <p>Découvrez nos articles disponibles sur le catalogue pour commencer vos achats !</p>
                <a href="catalogue.php">Retourner au catalogue</a>
            </div>
        <?php else: ?>
            <div class="cart-products">
                <?php foreach ($liste_panier as $item): ?>
                    <div class="cart-card">
                        <img src="<?= htmlspecialchars($item['image'] ?? 'uploads/default.jpg') ?>" alt="<?= htmlspecialchars($item['nom']) ?>">

                        <div class="product-info">
                            <h2><?= htmlspecialchars($item['nom']) ?></h2>
                            <p><?= nl2br(htmlspecialchars($item['description'])) ?></p>
                            <div class="price"><?= number_format($item['prix'], 0, ',', ' ') ?>€</div>

                            <div class="quantity">
                                <a href="panier.php?action=decrease&id=<?= $item['produit_id'] ?>" class="btn-qty">-</a>
                                <span><?= $item['quantite'] ?></span>
                                <a href="panier.php?action=increase&id=<?= $item['produit_id'] ?>" class="btn-qty">+</a>
                            </div>
                        </div>

                        <div class="actions">
                            <a href="produit.php?id=<?= $item['produit_id'] ?>" class="btn btn-view">👁 Voir le produit</a>
                            <a href="panier.php?action=delete&id=<?= $item['produit_id'] ?>" class="btn btn-remove" onclick="return confirm('Retirer ce produit du panier ?');">❌ Retirer</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <aside class="summary">
                <h2>Résumé de la commande</h2>
                <div class="summary-line">
                    <span>Sous-total</span>
                    <span><?= number_format($sous_total, 0, ',', ' ') ?>€</span>
                </div>
                <div class="summary-line">
                    <span>Livraison</span>
                    <span>Gratuite</span>
                </div>
                <div class="summary-line total">
                    <span>Total</span>
                    <span><?= number_format($sous_total, 0, ',', ' ') ?>€</span>
                </div>
                <a href="checkout.php" class="checkout-btn" style="display: block; text-align: center; text-decoration: none;">✅ Passer au paiement</a>
            </aside>
        <?php endif; ?>
    </section>

    <footer>
        <p>© 2026 Mercato Nova - Tous droits réservés</p>
    </footer>

</body>
</html>
