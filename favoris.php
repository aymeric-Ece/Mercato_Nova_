<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favoris - MercaTech </title>

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

        <!-- boutons d'actions -->

        .buttons{
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn{
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

        footer{
            background-color: #0f172a;
            text-align: center;
            padding: 25px;
            color: white;
            border-top: 1px solid #1e293b;
        }

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

            .top-actions{
                justify-content: center;
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
        <div class="logo">
            MercaTech
        </div>

        <ul>
            <li><a href="accueil.html">Accueil</a></li>
            <li><a href="catalogue.html">Catalogue</a></li>
            <li><a href="encheres.html">Enchères</a></li>
			<li><a href="mes_annonces.html">Mes annonces</a></li>
            <li><a href="connexion.html">Connexion</a></li>
        </ul>

    </nav>
<div class="top-actions">

        <a href="#" class="cart-button">
            🛒 Voir le panier
        </a>

    </div>


    <section class="page-title">

        <h1>Mes Favoris ❤️</h1>

        <p>
            Retrouvez ici tous les produits que vous avez ajoutés à vos favoris.
        </p>

    </section>


    <section class="favorites-container">

        <!-- PRODUCT 1 -->
        <div class="favorite-card">

            <img src="https://images.unsplash.com/photo-1606813907291-d86efa9b94db?q=80&w=1170&auto=format&fit=crop" alt="PS5">

            <div class="favorite-info">

                <h2>PlayStation 5</h2>

                <p>
                    Console nouvelle génération avec graphismes ultra réalistes et SSD ultra rapide.
                </p>

                <div class="price">
                    499€
                </div>

            </div>

            <div class="buttons">

                <button class="btn btn-cart">
                    🛒 Ajouter au panier
                </button>

                <button class="btn btn-view">
                    👁 Voir le produit
                </button>

                <button class="btn btn-remove">
                    ❌ Retirer des favoris
                </button>

            </div>

        </div>

        <!-- PRODUCT 2 -->
        <div class="favorite-card">

            <img src="https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?q=80&w=1170&auto=format&fit=crop" alt="PC Gamer">

            <div class="favorite-info">

                <h2>PC Gamer RTX</h2>

                <p>
                    PC gaming haute performance parfait pour les jeux AAA et le streaming.
                </p>

                <div class="price">
                    1599€
                </div>

            </div>

            <div class="buttons">

                <button class="btn btn-cart">
                    🛒 Ajouter au panier
                </button>

                <button class="btn btn-view">
                    👁 Voir le produit
                </button>

                <button class="btn btn-remove">
                    ❌ Retirer des favoris
                </button>

            </div>

        </div>

        <!-- PRODUCT 3 -->
        <div class="favorite-card">

            <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=1170&auto=format&fit=crop" alt="iPhone">

            <div class="favorite-info">

                <h2>iPhone 15 Pro</h2>

                <p>
                    Smartphone premium Apple avec écran ProMotion et appareil photo avancé.
                </p>

                <div class="price">
                    1299€
                </div>

            </div>

            <div class="buttons">

                <button class="btn btn-cart">
                    🛒 Ajouter au panier
                </button>

                <button class="btn btn-view">
                    👁 Voir le produit
                </button>

                <button class="btn btn-remove">
                    ❌ Retirer des favoris
                </button>

            </div>

        </div>

    </section>

    <footer>
        <p>
            © 2026 MercaTech - Tous droits réservés
        </p>
    </footer>

</body>
</html>
