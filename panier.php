Espace de stockage saturé depuis 69 jours … Si votre espace de stockage est plein pendant plus de deux ans, vos fichiers risquent d'être supprimés de Drive et de Photos. Profitez de 100 Go de stockage pour 1,99 € 0,49 €/mois pendant 3 mois (tarif personnalisé).
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - Mercato Nova</title>

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

        /* TITLE */

        .page-title{
            padding: 50px 60px 20px;
        }

        .page-title h1{
            font-size: 42px;
            margin-bottom: 10px;
        }

        .page-title p{
            color: #64748b;
            font-size: 18px;
        }

        /* MAIN */

        .cart-container{
            display: flex;
            gap: 40px;
            padding: 20px 60px 80px;
        }

        /* PRODUCTS */

        .cart-products{
            flex: 2;
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .cart-card{
            background-color: white;
            border-radius: 18px;
            padding: 20px;
            display: flex;
            gap: 25px;
            align-items: center;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .cart-card:hover{
            transform: translateY(-5px);
        }

        .cart-card img{
            width: 220px;
            height: 180px;
            object-fit: cover;
            border-radius: 12px;
        }

        .product-info{
            flex: 1;
        }

        .product-info h2{
            margin-bottom: 10px;
        }

        .product-info p{
            color: #64748b;
            margin-bottom: 15px;
            line-height: 1.5;
        }

        .price{
            color: #0284c7;
            font-size: 28px;
            font-weight: bold;
        }

        /* QUANTITY */

        .quantity{
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 20px;
        }

        .quantity button{
            width: 35px;
            height: 35px;
            border: none;
            border-radius: 8px;
            background-color: #0f172a;
            color: white;
            cursor: pointer;
            font-size: 18px;
        }

        .quantity span{
            font-size: 18px;
            font-weight: bold;
        }

        /* ACTIONS */

        .actions{
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .btn{
            padding: 12px 18px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
            min-width: 180px;
        }

        .btn-view{
            background-color: #38bdf8;
            color: white;
        }

        .btn-view:hover{
            background-color: #0ea5e9;
        }

        .btn-remove{
            background-color: #ef4444;
            color: white;
        }

        .btn-remove:hover{
            background-color: #dc2626;
        }

        /* SUMMARY */

        .summary{
            flex: 1;
            background-color: white;
            border-radius: 18px;
            padding: 30px;
            height: fit-content;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .summary h2{
            margin-bottom: 30px;
        }

        .summary-line{
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 18px;
        }

        .total{
            font-size: 24px;
            font-weight: bold;
            margin-top: 20px;
            border-top: 1px solid #cbd5e1;
            padding-top: 20px;
        }

        .checkout-btn{
            width: 100%;
            padding: 15px;
            margin-top: 30px;
            border: none;
            border-radius: 12px;
            background-color: #0f172a;
            color: white;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: 0.3s;
        }

        .checkout-btn:hover{
            background-color: #1e293b;
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

        @media(max-width: 1000px){

            .cart-container{
                flex-direction: column;
            }
        }

        @media(max-width: 850px){

            .cart-card{
                flex-direction: column;
                text-align: center;
            }

            .cart-card img{
                width: 100%;
                height: 250px;
            }

            .actions{
                width: 100%;
            }

            .btn{
                width: 100%;
            }

            .quantity{
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

    <!-- HEADER -->

    <nav>

        <div class="logo">
            Mercato Nova
        </div>

        <ul>
            <li><a href="accueil.html">Accueil</a></li>
            <li><a href="catalogue.html">Catalogue</a></li>
            <li><a href="encheres.html">Enchères</a></li>
			<li><a href="mes_annonces.html">Mes annonces</a></li>
            <li><a href="connexion.html">Connexion</a></li>
        </ul>

    </nav>

    <!-- TITLE -->

    <section class="page-title">

        <h1>Mon Panier 🛒</h1>

        <p>
            Consultez vos produits avant de finaliser votre commande.
        </p>

    </section>

    <!-- MAIN -->

    <section class="cart-container">

        <!-- PRODUCTS -->

        <div class="cart-products">

            <!-- PRODUCT 1 -->

            <div class="cart-card">

                <img src="https://images.unsplash.com/photo-1606813907291-d86efa9b94db?q=80&w=1170&auto=format&fit=crop" alt="PS5">

                <div class="product-info">

                    <h2>PlayStation 5</h2>

                    <p>
                        Console nouvelle génération avec SSD ultra rapide et graphismes 4K.
                    </p>

                    <div class="price">
                        499€
                    </div>

                    <div class="quantity">

                        <button>-</button>

                        <span>1</span>

                        <button>+</button>

                    </div>

                </div>

                <div class="actions">

                    <button class="btn btn-view">
                        👁 Voir le produit
                    </button>

                    <button class="btn btn-remove">
                        ❌ Retirer
                    </button>

                </div>

            </div>

            <!-- PRODUCT 2 -->

            <div class="cart-card">

                <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=1170&auto=format&fit=crop" alt="iPhone">

                <div class="product-info">

                    <h2>iPhone 15 Pro</h2>

                    <p>
                        Smartphone Apple premium avec écran ProMotion et puce ultra performante.
                    </p>

                    <div class="price">
                        1299€
                    </div>

                    <div class="quantity">

                        <button>-</button>

                        <span>1</span>

                        <button>+</button>

                    </div>

                </div>

                <div class="actions">

                    <button class="btn btn-view">
                        👁 Voir le produit
                    </button>

                    <button class="btn btn-remove">
                        ❌ Retirer
                    </button>

                </div>

            </div>

        </div>

        <!-- SUMMARY -->

        <aside class="summary">

            <h2>Résumé de la commande</h2>

            <div class="summary-line">
                <span>Sous-total</span>
                <span>1798€</span>
            </div>

            <div class="summary-line">
                <span>Livraison</span>
                <span>Gratuite</span>
            </div>

            <div class="summary-line total">
                <span>Total</span>
                <span>1798€</span>
            </div>

            <button class="checkout-btn">
                ✅ Passer au paiement
            </button>

        </aside>

    </section>

    <!-- FOOTER -->

    <footer>

        <p>
            © 2026 Mercato Nova - Tous droits réservés
        </p>

    </footer>

</body>

</html>
