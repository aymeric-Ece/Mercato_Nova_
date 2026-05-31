<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produit - MercaTech</title>

    <style>

        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
            font-family:Arial, Helvetica, sans-serif;
        }

        body{
            background:#f8fafc;
            color:#0f172a;
        }

        /* HEADER */

        nav{
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:20px 60px;
            background:#0f172a;
        }

        .logo{
            font-size:30px;
            font-weight:bold;
            color:#38bdf8;
        }

        nav ul{
            display:flex;
            list-style:none;
            gap:30px;
        }

        nav ul li a{
            text-decoration:none;
            color:white;
            transition:0.3s;
            font-size:17px;
        }

        nav ul li a:hover{
            color:#38bdf8;
        }

        .product-page{
            display:flex;
            gap:50px;
            padding:60px;
        }

        /* IMAGE */

        .product-image{
            flex:1;
        }

        .product-image img{
            width:100%;
            border-radius:20px;
            box-shadow:0 5px 15px rgba(0,0,0,0.1);
        }

        .product-details{
            flex:1;
            background:white;
            padding:40px;
            border-radius:20px;
            box-shadow:0 5px 15px rgba(0,0,0,0.08);
        }

        .product-details h1{
            font-size:45px;
            margin-bottom:20px;
        }

        .price{
            color:#0284c7;
            font-size:40px;
            font-weight:bold;
            margin-bottom:25px;
        }

        .description{
            color:#475569;
            line-height:1.8;
            margin-bottom:30px;
            font-size:17px;
        }

        .product-info{
            margin-bottom:30px;
        }

        .product-info p{
            margin-bottom:12px;
            font-size:16px;
        }

        .seller{
            background:#f1f5f9;
            padding:20px;
            border-radius:15px;
            margin-bottom:30px;
        }

        .seller h3{
            margin-bottom:10px;
        }

        /* BUTTONS */

        .buttons{
            display:flex;
            gap:15px;
            flex-wrap:wrap;
        }

        .btn{
            flex:1;
            min-width:180px;
            padding:16px;
            border:none;
            border-radius:12px;
            font-size:16px;
            font-weight:bold;
            cursor:pointer;
            transition:0.3s;
        }

        .btn-cart{
            background:#38bdf8;
            color:white;
        }

        .btn-cart:hover{
            background:#0ea5e9;
        }

        .btn-fav{
            background:#e2e8f0;
        }

        .btn-fav:hover{
            background:#cbd5e1;
        }

        .btn-buy{
            background:#0f172a;
            color:white;
        }

        .btn-buy:hover{
            background:#1e293b;
        }


        footer{
            background:#0f172a;
            color:white;
            text-align:center;
            padding:25px;
            margin-top:50px;
        }


        @media(max-width:950px){

            .product-page{
                flex-direction:column;
            }
        }

        @media(max-width:768px){

            nav{
                flex-direction:column;
                gap:20px;
            }

            nav ul{
                flex-wrap:wrap;
                justify-content:center;
            }

            .product-page{
                padding:25px;
            }

            .product-details{
                padding:25px;
            }

            .product-details h1{
                font-size:35px;
            }

            .price{
                font-size:32px;
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
            <li><a href="Acceuil_MT.html">Accueil</a></li>
            <li><a href="Catalogue.html">Catalogue</a></li>
            <li><a href="encheres.html">Enchères</a></li>
            <li><a href="mes_annonces.html">Mes annonces</a></li>
            <li><a href="connexion.html">Connexion</a></li>
        </ul>

    </nav>

    <section class="product-page">

        <div class="product-image">

            <img src="https://images.unsplash.com/photo-1606813907291-d86efa9b94db?q=80&w=1170&auto=format&fit=crop" alt="PS5">

        </div>

        <div class="product-details">

            <h1>PlayStation 5</h1>

            <div class="price">
                499€
            </div>

            <p class="description">
                Découvrez la PlayStation 5 avec ses performances nouvelle génération,
                son SSD ultra rapide, ses graphismes 4K et sa manette DualSense immersive.
                Une console idéale pour profiter des derniers jeux AAA.
            </p>

            <div class="product-info">

                <p><strong>Catégorie :</strong> Gaming</p>

                <p><strong>État :</strong> Neuf</p>

                <p><strong>Type de vente :</strong> Achat immédiat</p>

                <p><strong>Livraison :</strong> Disponible partout en France</p>

            </div>

            <div class="seller">

                <h3>Vendeur</h3>

                <p>NovaGaming75 ⭐ 4.9/5</p>

            </div>

            <div class="buttons">

                <button class="btn btn-cart">
                    🛒 Ajouter au panier
                </button>

                <button class="btn btn-fav">
                    ❤️ Ajouter aux favoris
                </button>

                <button class="btn btn-buy">
                    Acheter maintenant
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
