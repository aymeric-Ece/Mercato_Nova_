<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>MercaTech</title>

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
            color: #0f172a;
        }

        .hero-content p{
            font-size: 22px;
            color: #334155;
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
            MercaTech
        </div>

        <ul>
            <li><a href="Accueil.html">Accueil</a></li>
            <li><a href="Catalogue.html">Catalogue</a></li>
            <li><a href="#">Enchères</a></li>
            <li><a href="#">Connexion</a></li>
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

                <a href="catalogue.html">
					<button class="btn btn-primary">
						Explorer
					</button>
				</a>

                <button class="btn btn-secondary">
                    Vendre un produit
                </button>

            </div>

        </div>

    </section>

    <!-- CATEGORIES -->

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

    <!-- PRODUCTS -->

    <section class="products">

        <h2>Produits populaires</h2>

        <div class="product-container">

            <!-- PRODUCT 1 -->

            <div class="product-card">

                <img src="https://images.unsplash.com/photo-1606813907291-d86efa9b94db?q=80&w=1170&auto=format&fit=crop" alt="PS5">

                <div class="product-info">

                    <h3>PlayStation 5</h3>

                    <p class="price">499€</p>

                    <button class="buy-btn">
                        Voir le produit
                    </button>

                </div>

            </div>

            <!-- PRODUCT 2 -->

            <div class="product-card">

                <img src="https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?q=80&w=1170&auto=format&fit=crop" alt="PC Gamer">

                <div class="product-info">

                    <h3>PC Gamer RTX</h3>

                    <p class="price">1599€</p>

                    <button class="buy-btn">
                        Voir le produit
                    </button>

                </div>

            </div>

            <!-- PRODUCT 3 -->

            <div class="product-card">

                <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=1170&auto=format&fit=crop" alt="iPhone">

                <div class="product-info">

                    <h3>iPhone 15 Pro</h3>

                    <p class="price">1299€</p>

                    <button class="buy-btn">
                        Voir le produit
                    </button>

                </div>

            </div>

        </div>

    </section>

    <!-- FOOTER -->

    <footer>

        <p>
            © 2026 MercaTech - Tous droits réservés
        </p>

    </footer>

</body>

</html>
