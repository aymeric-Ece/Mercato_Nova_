<?php
// Démarrage de la session pour suivre l'utilisateur connecté
session_start();

// CONNEXION À LA BASE DE DONNÉES MYSQL
$host = "localhost";
$dbname = "mercato_nova";
$user = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}

// Récupération des 3 produits avec l'ID le plus bas
try {
    $stmt = $pdo->query("SELECT id, nom, prix, image FROM produits ORDER BY id ASC LIMIT 3");
    $produits_populaires = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $produits_populaires = []; // En cas d'erreur (ex: table non encore créée)
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Mercato Nova</title>

    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }

        body{
            background-color: #f1f5f9;
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

        /* HERO */

        .hero{
            height: 85vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 20px;

            background:
            url('https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=2070&auto=format&fit=crop');

            background-size: cover;
            background-position: center;
        }

        .hero-content{
            max-width: 900px;
        }

        .hero-content h1{
            font-size: 65px;
            margin-bottom: 25px;
            color: white;
        }

        .hero-content p{
            font-size: 22px;
            color: white;
            margin-bottom: 40px;
        }

        .buttons{
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .btn{
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
            font-weight: bold;
        }

        .btn-primary{
            background-color: #38bdf8;
            color: white;
        }

        .btn-primary:hover{
            background-color: #0ea5e9;
        }

        .btn-secondary{
            background-color: white;
            color: #0f172a;
            border: 2px solid #38bdf8;
        }

        .btn-secondary:hover{
            background-color: #38bdf8;
            color: white;
        }

        /* CATEGORIES */

        .categories{
            padding: 80px 60px;
        }

        .categories h2{
            text-align: center;
            font-size: 42px;
            margin-bottom: 50px;
            color: #0f172a;
        }

        .category-container{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px,1fr));
            gap: 25px;
        }

        .category-card{
            background-color: white;
            border-radius: 15px;
            padding: 40px 20px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: 0.3s;
            cursor: pointer;
        }

        .category-card:hover{
            transform: translateY(-8px);
            background-color: #e0f2fe;
        }

        .category-icon{
            font-size: 50px;
            margin-bottom: 15px;
        }

        .category-card h3{
            font-size: 24px;
            color: #0f172a;
        }

        /* PRODUCTS */

        .products{
            padding: 20px 60px 80px;
        }

        .products h2{
            text-align: center;
            font-size: 42px;
            margin-bottom: 50px;
            color: #0f172a;
        }

        .product-container{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px,1fr));
            gap: 30px;
        }

        .product-card{
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .product-card:hover{
            transform: scale(1.03);
        }

        .product-card img{
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .product-info{
            padding: 20px;
        }

        .product-info h3{
            margin-bottom: 10px;
            color: #0f172a;
        }

        .price{
            color: #0284c7;
            font-size: 22px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .buy-btn{
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #38bdf8;
            color: white;
            font-weight: bold;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .buy-btn:hover{
            background-color: #0ea5e9;
        }

        /* FOOTER */

        footer{
            background-color: #0f172a;
            text-align: center;
            padding: 25px;
            color: white;
            border-top: 1px solid #1e293b;
        }

        /* RESPONSIVE */

        @media(max-width: 768px){

            nav{
                flex-direction: column;
                gap: 20px;
            }

            nav ul{
                flex-wrap: wrap;
                justify-content: center;
            }

            .hero-content h1{
                font-size: 42px;
            }

            .hero-content p{
                font-size: 18px;
            }

            .buttons{
                flex-direction: column;
                align-items: center;
            }
        }

    </style>

</head>

<body>

    <!-- HEADER -->

    <nav>

        <div class="logo">
            Mercato Nova
        </div>

        <ul>
            <li><a href="accueil.php">Accueil</a></li>
            <li><a href="Catalogue.php">Catalogue</a></li>
            <li><a href="encheres.php">Enchères</a></li>
            <li><a href="mes_annonces.php">Mes annonces</a></li>
            
            <?php if (isset($_SESSION['nom_utilisateur'])): ?>
                <!-- Affiche le nom de l'utilisateur connecté et un lien de déconnexion -->
                <li style="color: #38bdf8; font-weight: bold; font-size: 17px; display: flex; align-items: center; gap: 8px;">
                    👤 <?= htmlspecialchars($_SESSION['nom_utilisateur']); ?>
                    <a href="deconnexion.php" style="color: #ef4444; font-size: 13px; text-decoration: none;" onclick="return confirm('Voulez-vous vous déconnecter ?');">(Déconnexion)</a>
                </li>
            <?php else: ?>
                <!-- Lien classique si visiteur anonyme -->
                <li><a href="connexion.html">Connexion</a></li>
            <?php endif; ?>
        </ul>

    </nav>

    <!-- HERO -->

    <section class="hero">

        <div class="hero-content">

            <h1>
                Achetez, Négociez et Enchérissez
            </h1>

            <p>
                Découvrez une nouvelle façon moderne d’acheter et vendre vos produits tech et gaming.
            </p>

            <div class="buttons">

                <!-- Redirection vers Catalogue.php -->
                <a href="Catalogue.php">
                    <button class="btn btn-primary">
                        Explorer
                    </button>
                </a>
                
                <!-- Si l'utilisateur est connecté, il accède directement à la création d'annonce, sinon redirigé vers la connexion -->
                <?php if (isset($_SESSION['utilisateur_id'])): ?>
                    <a href="mes_annonces.php">
                <?php else: ?>
                    <a href="connexion.html">
                <?php endif; ?>
                    <button class="btn btn-secondary">
                        Vendre un produit
                    </button>
                </a>
            </div>

        </div>

    </section>

    <!-- CATEGORIES COMPLÈTES CONSERVÉES -->

    <section class="categories">

        <h2>Catégories populaires</h2>

        <div class="category-container">

            <div class="category-card">
                <div class="category-icon">🎮</div>
                <h3>Gaming</h3>
            </div>

            <div class="category-card">
                <div class="category-icon">📱</div>
                <h3>Smartphones</h3>
            </div>

            <div class="category-card">
                <div class="category-icon">💻</div>
                <h3>PC & Ordinateurs</h3>
            </div>

            <div class="category-card">
                <div class="category-icon">🎧</div>
                <h3>Audio</h3>
            </div>

        </div>

    </section>

    <!-- PRODUCTS DYNAMIQUES -->

    <section class="products">

        <h2>Produits populaires</h2>

        <div class="product-container">

            <?php if (!empty($produits_populaires)): ?>
                <?php foreach ($produits_populaires as $produit): ?>
                    <div class="product-card">
                        <!-- Affichage de l'image de la BDD ou d'une image par défaut si vide -->
                        <img src="<?= htmlspecialchars($produit['image'] ?? 'uploads/default.jpg') ?>" alt="<?= htmlspecialchars($produit['nom']) ?>">
                        
                        <div class="product-info">
                            <h3><?= htmlspecialchars($produit['nom']) ?></h3>
                            <p class="price"><?= number_format($produit['prix'], 0, ',', ' ') ?>€</p>
                            
                            <!-- Lien personnalisé pointant vers l'ID unique de l'article -->
                            <a href="produit.php?id=<?= $produit['id'] ?>">
                                <button class="buy-btn">
                                    Voir le produit
                                </button>
                            </a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Message de secours si la base est vide -->
                <p style="grid-column: 1 / -1; text-align: center; color: #64748b; font-style: italic; font-size: 18px;">
                    Aucun produit disponible pour le moment.
                </p>
            <?php endif; ?>

        </div>

    </section>

    <!-- FOOTER -->

    <footer>
        <p>
            © 2026 Mercato Nova - Tous droits réservés
        </p>
    </footer>

</body>

</html>
