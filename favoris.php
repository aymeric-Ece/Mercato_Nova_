<?php
// Démarrage de la session pour identifier l'utilisateur connecté
session_start();

// CONNEXION MYSQL
$host = "localhost";
$dbname = "mercato_nova";
$user = "root";
$password = "";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur connexion base de données.");
}

// Récupération de l'ID utilisateur connecté
$utilisateur_id = $_SESSION['utilisateur_id'] ?? null;

// Bloquer l'accès si l'utilisateur n'est pas connecté
if (!$utilisateur_id) {
    header("Location: connexion.html");
    exit();
}

$message = "";

// ==========================================
// ACTION : RETIRER DES FAVORIS
// ==========================================
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['favoris_id'])) {
    $favoris_id_a_supprimer = intval($_GET['favoris_id']);
    
    try {
        // Sécurité : On vérifie aussi l'utilisateur_id pour éviter qu'un utilisateur supprime le favori d'un autre
        $suppression = $pdo->prepare("DELETE FROM favoris WHERE id = ? AND utilisateur_id = ?");
        $suppression->execute([$favoris_id_a_supprimer, $utilisateur_id]);
        
        $message = "Produit retiré de vos favoris.";
    } catch (PDOException $e) {
        $message = "Erreur lors de la suppression du favori.";
    }
}

// ==========================================
// RECUPERATION DES FAVORIS DE L'UTILISATEUR
// ==========================================
try {
    // La requête récupère l'ID unique du favori ET les détails du produit associé
    $requete = $pdo->prepare("
        SELECT 
            favoris.id AS favoris_id,
            produits.id AS produit_id,
            produits.nom,
            produits.description,
            produits.prix,
            produits.image
        FROM favoris
        INNER JOIN produits ON favoris.produit_id = produits.id
        WHERE favoris.utilisateur_id = ?
        ORDER BY favoris.id DESC
    ");
    $requete->execute([$utilisateur_id]);
    $liste_favoris = $requete->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erreur lors de la récupération des favoris : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoris - Mercato Nova</title>

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

        /* PANIER TOP RIGHT */
        .top-actions{
            display: flex;
            justify-content: flex-end;
            padding: 25px 60px 0;
        }

        .cart-button{
            text-decoration: none;
            background-color: #0f172a;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            font-weight: bold;
            transition: 0.3s;
        }

        .cart-button:hover{
            background-color: #1e293b;
        }

        /* PAGE TITLE */
        .page-title{
            padding: 30px 60px 20px;
        }

        .page-title h1{
            font-size: 42px;
            color: #0f172a;
        }

        .page-title p{
            margin-top: 10px;
            color: #64748b;
            font-size: 18px;
        }

        /* ALERT MESSAGE */
        .alert {
            margin: 20px 60px 0;
            padding: 15px;
            background-color: #e0f2fe;
            color: #0369a1;
            border: 1px solid #bae6fd;
            border-radius: 10px;
            font-weight: bold;
        }

        /* NO FAVORITES EMPTY STATE */
        .empty-favorites {
            text-align: center;
            padding: 60px;
            background: white;
            border-radius: 18px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            margin: 0 60px;
        }
        .empty-favorites a {
            display: inline-block;
            margin-top: 20px;
            padding: 12px 25px;
            background-color: #38bdf8;
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: bold;
        }

        /* FAVORITES */
        .favorites-container{
            padding: 20px 60px 80px;
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        .favorite-card{
            background-color: white;
            border-radius: 18px;
            overflow: hidden;
            display: flex;
            align-items: center;
            gap: 25px;
            padding: 20px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .favorite-card:hover{
            transform: translateY(-5px);
        }

        .favorite-card img{
            width: 220px;
            height: 180px;
            object-fit: cover;
            border-radius: 12px;
        }

        .favorite-info{
            flex: 1;
        }

        .favorite-info h2{
            margin-bottom: 10px;
            color: #0f172a;
        }

        .favorite-info p{
            color: #64748b;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .price{
            font-size: 28px;
            font-weight: bold;
            color: #0284c7;
        }

        /* BUTTONS */
        .buttons{
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn{
            display: inline-block;
            text-align: center;
            text-decoration: none;
            padding: 12px 20px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
            min-width: 190px;
        }

        .btn-cart{
            background-color: #38bdf8;
            color: white;
        }

        .btn-cart:hover{
            background-color: #0ea5e9;
        }

        .btn-view{
            background-color: #0f172a;
            color: white;
        }

        .btn-view:hover{
            background-color: #1e293b;
        }

        .btn-remove{
            background-color: #ef4444;
            color: white;
        }

        .btn-remove:hover{
            background-color: #dc2626;
        }

        /* FOOTER */
        footer{
            background-color: #0f172a;
            text-align: center;
            padding: 25px;
            color: white;
            border-top: 1px solid #1e293b;
            margin-top: auto;
        }

        /* RESPONSIVE */
        @media(max-width: 900px){
            .favorite-card{
                flex-direction: column;
                text-align: center;
            }

            .buttons{
                width: 100%;
            }

            .btn{
                width: 100%;
            }

            .favorite-card img{
                width: 100%;
                height: 250px;
            }

            .top-actions, .alert, .empty-favorites{
                margin-left: 20px;
                margin-right: 20px;
            }
            .favorites-container {
                padding: 20px;
            }
        }

        @media(max-width: 768px){
            nav{
                flex-direction: column;
                gap: 20px;
            }

            nav ul{
                flex-wrap: wrap;
                justify-content: center;
            }
        }
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
                <li style="color: #38bdf8; font-weight: bold; font-size: 17px; display: flex; align-items: center; gap: 10px;">
                    👤 <?php echo htmlspecialchars($_SESSION['nom_utilisateur']); ?>
                    <a href="deconnexion.php" style="color: #ef4444; font-size: 14px; text-decoration: none;">(Déconnexion)</a>
                </li>
            <?php else: ?>
                <li><a href="connexion.html">Connexion</a></li>
            <?php endif; ?>
        </ul>
    </nav>

    <div class="top-actions">
        <a href="panier.php" class="cart-button">🛒 Voir le panier</a>
    </div>

    <section class="page-title">
        <h1>Mes Favoris ❤️</h1>
        <p>Retrouvez ici tous les produits que vous avez ajoutés à vos favoris.</p>
    </section>

    <?php if (!empty($message)): ?>
        <div class="alert">
            <?= htmlspecialchars($message) ?>
        </div>
    <?php endif; ?>

    <?php if (empty($liste_favoris)): ?>
        <div class="empty-favorites">
            <h2>Vous n'avez pas encore de favoris.</h2>
            <p>Parcourez notre catalogue pour ajouter des produits coup de cœur !</p>
            <a href="catalogue.php">Découvrir le catalogue</a>
        </div>
    <?php else: ?>
        <section class="favorites-container">
            <?php foreach ($liste_favoris as $favori): ?>
                <div class="favorite-card">
                    <img src="<?= htmlspecialchars($favori['image'] ?? 'uploads/default.jpg') ?>" alt="<?= htmlspecialchars($favori['nom']) ?>">

                    <div class="favorite-info">
                        <h2><?= htmlspecialchars($favori['nom']) ?></h2>
                        <p><?= nl2br(htmlspecialchars($favori['description'])) ?></p>
                        <div class="price"><?= number_format($favori['prix'], 0, ',', ' ') ?>€</div>
                    </div>

                    <div class="buttons">
                        <a href="panier.php?action=add&id=<?= $favori['produit_id'] ?>" class="btn btn-cart">
                            🛒 Ajouter au panier
                        </a>

                        <a href="produit.php?id=<?= $favori['produit_id'] ?>" class="btn btn-view">
                            👁 Voir le produit
                        </a>

                        <a href="favoris.php?action=delete&favoris_id=<?= $favori['favoris_id'] ?>" class="btn btn-remove" onclick="return confirm('Voulez-vous vraiment retirer ce produit de vos favoris ?');">
                            ❌ Retirer des favoris
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </section>
    <?php endif; ?>

    <footer>
        <p>© 2026 Mercato Nova - Tous droits réservés</p>
    </footer>

</body>
</html>
