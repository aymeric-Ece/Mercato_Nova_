<?php
// Démarrage de la session pour l'utilisateur connecté
session_start();

// CONNEXION MYSQL
$host = "localhost";
$dbname = "mercato_nova";
$user = "root";
$password = "";

try{
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die("Erreur connexion base de données.");
}

// RECUPERATION ID PRODUIT
if(!isset($_GET["id"])){
    die("Produit introuvable.");
}

$id_produit = intval($_GET["id"]);

// ID de l'utilisateur connecté (null s'il est visiteur anonyme)
$utilisateur_id = $_SESSION['utilisateur_id'] ?? null;

// ==========================================
// LOGIQUE D'AJOUT AUX FAVORIS (CORRIGÉE)
// ==========================================
if (isset($_GET['action']) && $_GET['action'] === 'add_favoris') {
    // 1. Vérification stricte de la connexion utilisateur
    if (!$utilisateur_id) {
        header("Location: connexion.html"); // Redirection immédiate si non connecté
        exit();
    }

    // 2. Si connecté, exécution de la logique d'ajout aux favoris
    $verif = $pdo->prepare("SELECT id FROM favoris WHERE utilisateur_id = ? AND produit_id = ?");
    $verif->execute([$utilisateur_id, $id_produit]);
    
    if ($verif->rowCount() == 0) {
        $insert = $pdo->prepare("INSERT INTO favoris (utilisateur_id, produit_id) VALUES (?, ?)");
        $insert->execute([$utilisateur_id, $id_produit]);
    }
    
    // 3. RESOLUTION DU RETOUR EN ARRIERE : Redirection propre vers la page du produit nettoyée de l'action
    header("Location: produit.php?id=" . $id_produit);
    exit();
}

// RECUPERATION DES DETAILS DU PRODUIT
$requete = $pdo->prepare("
    SELECT p.*, u.nom_utilisateur 
    FROM produits p
    LEFT JOIN utilisateurs u ON p.utilisateur_id = u.id
    WHERE p.id = ?
");
$requete->execute([$id_produit]);
$produit = $requete->fetch(PDO::FETCH_ASSOC);

if(!$produit){
    die("Le produit demandé n'existe pas.");
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($produit["nom"] ?? 'Produit'); ?> - Mercato Nova</title>

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            background-color: #f8fafc;
            color: #0f172a;
        }

        /* HEADER */
        nav{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 60px;
            background-color: #0f172a;
            border-bottom: 1px solid #1e293b;
        }

        .logo{
            font-size: 30px;
            font-weight: bold;
            color: #38bdf8;
        }

        nav ul{
            display: flex;
            list-style: none;
            gap: 30px;
            align-items: center;
        }

        nav ul li a{
            text-decoration: none;
            color: white;
            transition: 0.3s;
            font-size: 17px;
        }

        nav ul li a:hover{
            color: #38bdf8;
        }

        /* PRODUCT DETAILS */
        .container{
            max-width: 1200px;
            margin: 50px auto;
            padding: 20px;
            display: flex;
            gap: 50px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }

        .product-image{
            flex: 1;
        }

        .product-image img{
            width: 100%;
            height: 500px;
            object-fit: cover;
            border-radius: 15px;
        }

        .product-details{
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        h1{
            font-size: 36px;
            margin-bottom: 15px;
            color: #0f172a;
        }

        .price{
            font-size: 30px;
            font-weight: bold;
            color: #0284c7;
            margin-bottom: 25px;
        }

        .description{
            font-size: 18px;
            color: #475569;
            line-height: 1.6;
            margin-bottom: 30px;
        }

        .product-info{
            background-color: #f1f5f9;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }

        .product-info p{
            margin-bottom: 10px;
            font-size: 16px;
        }

        .product-info p:last-child{
            margin-bottom: 0;
        }

        .seller{
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #cbd5e1;
        }

        .seller h3{
            margin-bottom: 5px;
        }

        .seller p{
            color: #64748b;
        }

        .buttons{
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn{
            padding: 15px 30px;
            border-radius: 10px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
            border: none;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }
		.back-btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 20px;
            text-decoration: none;
            color: #000000;             
            background-color: #e2e8f0;   
            padding: 8px 16px;          
            border-radius: 8px;         
            font-weight: bold;
            font-size: 14px;
            transition: 0.3s;
			align-self: flex-start;
        }
        .back-btn:hover {
            background-color: #cbd5e1;   
            color: #000000;
        }

        .btn-cart{
            background-color: #0f172a;
            color: white;
            flex: 1;
        }

        .btn-cart:hover{
            background-color: #1e293b;
        }

        .btn-fav{
            background-color: #ef4444;
            color: white;
        }

        .btn-fav:hover{
            background-color: #dc2626;
        }

        .btn-buy{
            background-color: #38bdf8;
            color: white;
            width: 100%;
            margin-top: 15px;
        }
		.btn-negotiate {
    background-color: #10b981;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 10px;
    font-weight: bold;
    cursor: pointer;
    transition: 0.3s;
}

.btn-negotiate:hover {
    background-color: #059669;
}

        .btn-buy:hover{
            background-color: #0ea5e9;
        }

        footer{
            background-color: #0f172a;
            color: white;
            text-align: center;
            padding: 25px;
            margin-top: 50px;
        }
    </style>
</head>

<body>

    <nav>
        <div class="logo">Mercato Nova</div>
        <ul>
            <li><a href="accueil.php">Accueil</a></li>
            <li><a href="Catalogue.php">Catalogue</a></li>
            <li><a href="encheres.php">Enchères</a></li>
            <li><a href="mes_annonces.php">Mes annonces</a></li>
            <?php if (isset($_SESSION['nom_utilisateur'])): ?>
                <li style="color: #38bdf8; font-weight: bold; font-size: 17px; display: flex; align-items: center; gap: 8px;">
                    👤 <?= htmlspecialchars($_SESSION['nom_utilisateur']); ?>
                    <a href="deconnexion.php" style="color: #ef4444; font-size: 13px; text-decoration: none;" onclick="return confirm('Voulez-vous vous déconnecter ?');">(Déconnexion)</a>
                </li>
            <?php else: ?>
                <li><a href="seconnecter.php">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <section class="container">
		<a href="javascript:history.back()" class="back-btn">⬅ Retour</a>
        <div class="product-image">
            <img src="<?php echo htmlspecialchars($produit["image"] ?? 'uploads/default.jpg'); ?>" alt="<?php echo htmlspecialchars($produit["nom"] ?? 'Produit'); ?>">
        </div>

        <div class="product-details">
            <h1><?php echo htmlspecialchars($produit["nom"] ?? 'Produit sans nom'); ?></h1>
            <div class="price"><?php echo number_format($produit["prix"], 0, ',', ' '); ?>€</div>
            <p class="description"><?php echo nl2br(htmlspecialchars($produit["description"] ?? '')); ?></p>

            <div class="product-info">
                <p><strong>Catégorie :</strong> <?php echo htmlspecialchars($produit["categorie"] ?? 'Non renseignée'); ?></p>
                <p><strong>État :</strong> <?php echo htmlspecialchars($produit["etat"] ?? "Non renseigné"); ?></p>
                <p><strong>Type de vente :</strong> <?php echo htmlspecialchars($produit["type_vente"] ?? 'Non renseigné'); ?></p>
                <p><strong>Statut :</strong> <?php echo htmlspecialchars($produit["statut"] ?? 'Disponible'); ?></p>
            </div>

            <div class="seller">
                <h3>Vendeur</h3>
                <p><?php echo htmlspecialchars($produit["nom_utilisateur"] ?? "Utilisateur inconnu"); ?> ⭐ 4.9/5</p>
            </div>

            <div class="buttons" style="display: flex; flex-direction: column; gap: 15px; width: 100%;">

    <?php
    // Calcul ou récupération du prix d'affichage (standard ou négocié si accepté)
    $prix_affichage = $produit["prix"] ?? 0;
    if ($utilisateur_id) {
        $check_nego = $pdo->prepare("SELECT montant_propose, statut FROM negotiations WHERE produit_id = ? AND acheteur_id = ? ORDER BY id DESC LIMIT 1");
        $check_nego->execute([$id_produit, $utilisateur_id]);
        $nego_existante = $check_nego->fetch(PDO::FETCH_ASSOC);

        if ($nego_existante && $nego_existante['statut'] === 'accepte') {
            $prix_affichage = $nego_existante['montant_propose'];
        }
    }
    ?>

    <form action="checkout.php" method="GET" style="width: 100%; margin: 0;">
        <input type="hidden" name="unique_produit_id" value="<?= $id_produit ?>">
        <input type="hidden" name="prix_negocie" value="<?= $prix_affichage ?>">
        <button type="submit" class="btn btn-buy" style="width: 100%; margin: 0;">
            🛍️ Acheter maintenant (<?= number_format($prix_affichage, 0, ',', ' ') ?>€)
        </button>
    </form>

    <a href="panier.php?action=add&id=<?= $id_produit ?>" class="btn btn-cart" style="width: 100%;">
        🛒 Ajouter au panier
    </a>

    <div style="background: #f1f5f9; padding: 15px; border-radius: 10px; width: 100%; box-sizing: border-box; border: 1px solid #cbd5e1; margin-top: 5px;">
        <h4 style="margin-bottom: 10px; color: #0f172a; font-size: 15px;">🤝 Négocier le prix</h4>
        
        <form action="soumettre_negociation.php" method="POST" style="display: flex; gap: 10px; align-items: center; margin: 0;">
            <input type="hidden" name="produit_id" value="<?= $id_produit ?>">
            
            <div style="position: relative; flex: 1;">
                <input type="number" 
                       name="prix_propose" 
                       max="<?= ($produit['prix'] ?? 1) - 1 ?>" 
                       step="0.01" 
                       placeholder="Prix inférieur..." 
                       required 
                       style="width: 100%; padding: 10px; border-radius: 8px; border: 1px solid #cbd5e1; font-size: 14px; margin: 0; box-sizing: border-box;">
            </div>
            
            <button type="submit" style="background: #10b981; color: white; border: none; padding: 10px 15px; border-radius: 8px; font-weight: bold; cursor: pointer; white-space: nowrap; font-size: 14px;">
                Soumettre
            </button>
        </form>
        
        <?php if (isset($_GET['nego']) && $_GET['nego'] === 'success'): ?>
            <p style="color: #10b981; font-size: 13px; margin-top: 8px; font-weight: bold; text-align: center;">✅ Proposition envoyée au vendeur !</p>
        <?php endif; ?>
    </div>

    <a href="produit.php?id=<?= $id_produit ?>&action=add_favoris" class="btn btn-fav" style="width: 100%;">
        ❤️ Ajouter aux favoris
    </a>
    
</div>
        </div>
    </section>

    <footer>
        <p>© 2026 Mercato Nova - Tous droits réservés</p>
    </footer>

</body>
</html>
