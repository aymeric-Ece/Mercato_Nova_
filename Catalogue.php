<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catalogue - MercaTech</title>

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

        /* SEARCH BAR */

        .top-bar{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px 60px;
            background-color: white;
            border-bottom: 1px solid #e2e8f0;
        }

        .search-box{
            width: 65%;
            display: flex;
            gap: 10px;
        }

        .search-box input{
            width: 100%;
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            font-size: 16px;
        }

        .search-btn{
            padding: 15px 25px;
            background-color: #0f172a;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        .search-btn:hover{
            background-color: #1e293b;
        }

        .icons{
            display: flex;
            gap: 20px;
            font-size: 28px;
            cursor: pointer;
        }
		.icon-link{
			text-decoration: none;
			color: #0f172a;
			font-size: 18px;
			font-weight: bold;
			transition: 0.3s;
		}

		.icon-link:hover{
			color: #0284c7;
		}

        /* MAIN */

        .catalogue-container{
            display: flex;
            padding: 40px 60px;
            gap: 40px;
        }

        /* FILTERS */

        .filters{
            width: 260px;
            background-color: white;
            padding: 25px;
            border-radius: 15px;
            height: fit-content;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
        }

        .filters h2{
            margin-bottom: 25px;
            color: #0f172a;
        }

        .filter-group{
            margin-bottom: 30px;
        }

        .filter-group h3{
            margin-bottom: 15px;
            color: #334155;
        }

        .filter-group label{
            display: block;
            margin-bottom: 10px;
            cursor: pointer;
        }
		.filter-section{
			margin-top: 35px;
			margin-bottom: 50px;
		}

		.filter-section h3{
			margin-bottom: 15px;
			color: #0f172a;
			font-size: 20px;
		}

		.price-filter{
			display: flex;
			flex-direction: column;
			gap: 12px;
		}

		.price-filter input{
			padding: 12px;
			border: 1px solid #cbd5e1;
			border-radius: 10px;
			font-size: 15px;
		}

		.price-btn{
			padding: 12px;
			border: none;
			border-radius: 10px;
			background-color: #0f172a;
			color: white;
			font-weight: bold;
			cursor: pointer;
			transition: 0.3s;
		}

		.price-btn:hover{
			background-color: #1e293b;
		}

        /* PRODUCTS */

        .products{
            flex: 1;
        }

        .products-title{
            margin-bottom: 30px;
            font-size: 35px;
            color: #0f172a;
        }

        .product-grid{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px,1fr));
            gap: 30px;
        }

        .product-card{
            background-color: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .product-card:hover{
            transform: translateY(-5px);
        }

        .product-card img{
            width: 100%;
            height: 220px;
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

        .product-buttons{
			display: flex;
			gap: 10px;
		}
		.product-buttons a{
			flex: 1;
		}

        .btn{
            padding:12px;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-view{
            background-color: #38bdf8;
            color: white;
        }

        .btn-view:hover{
            background-color: #0ea5e9;
        }

        .btn-fav{
            background-color: #e2e8f0;
			color: red;
        }
		.btn-view{
			width: 100%;
			height: 55px;
			background-color: #38bdf8;
			color: white;
		}

		.btn-fav{
			width: 90px;
			background-color: #e2e8f0;
			color: red;
			font-size: 18px;
		}

        .btn-fav:hover{
            background-color: #cbd5e1;
        }

        /* FOOTER */

        footer{
            background-color: #0f172a;
            text-align: center;
            padding: 25px;
            color: white;
            margin-top: 50px;
            border-top: 1px solid #1e293b;
        }

        /* RESPONSIVE */

        @media(max-width: 900px){

            .catalogue-container{
                flex-direction: column;
            }

            .filters{
                width: 100%;
            }

            .top-bar{
                flex-direction: column;
                gap: 20px;
            }

            .search-box{
                width: 100%;
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
            MercaTech
        </div>

        <ul>
            <li><a href="Accueil.html">Accueil</a></li>
            <li><a href="Catalogue.html">Catalogue</a></li>
            <li><a href="encheres.html">Enchères</a></li>
			<li><a href="mes_annonces.html">Mes annonces</a></li>
            <li><a href="connexion.html">Connexion</a></li>
        </ul>

    </nav>

    <!-- SEARCH BAR -->

    <section class="top-bar">

        <div class="search-box">

            <input type="text" placeholder="Rechercher un produit...">

            <button class="search-btn">
                Rechercher
            </button>

        </div>

        <div class="icons">

			<a href="favoris.html" class="icon-link">
			❤  Favoris
			</a>

			<a href="panier.html" class="icon-link">
			🛒 Panier
			</a>

			<a href="vendre.html" class="icon-link">
			➕ Vendre
			</a>

		</div>

    </section>

    <!-- MAIN CONTENT -->

    <section class="catalogue-container">

        <!-- FILTERS -->

        <aside class="filters">

            <h2>Filtres</h2>

            <div class="filter-group">

                <h3>Catégories</h3>

                <label><input type="checkbox"> Gaming</label>
                <label><input type="checkbox"> Smartphones</label>
                <label><input type="checkbox"> Informatique</label>
                <label><input type="checkbox"> Audio</label>

            </div>

            <div class="filter-group">

                <h3>Prix</h3>

                <label><input type="checkbox"> Moins de 100€</label>
                <label><input type="checkbox"> 100€ - 500€</label>
                <label><input type="checkbox"> 500€ - 1000€</label>
                <label><input type="checkbox"> Plus de 1000€</label>

            </div>
			<div class="filter-section">

				<h3>Prix personnalisé</h3>

				<div class="price-filter">

					<input type="number" placeholder="Min €">

					<input type="number" placeholder="Max €">

					<button class="price-btn">
						Appliquer
					</button>

				</div>

			</div>
            <div class="filter-group">

                <h3>Type de vente</h3>

                <label><input type="checkbox"> Achat immédiat</label>
                <label><input type="checkbox"> Enchères</label>
                <label><input type="checkbox"> Négociation</label>

            </div>

        </aside>

        <!-- PRODUCTS -->

        <div class="products">

            <h1 class="products-title">
                Catalogue des produits
            </h1>

            <div class="product-grid">

                <!-- PRODUCT 1 -->

                <div class="product-card">

                    <img src="https://images.unsplash.com/photo-1606813907291-d86efa9b94db?q=80&w=1170&auto=format&fit=crop" alt="PS5">

                    <div class="product-info">

                        <h3>PlayStation 5</h3>

                        <p class="price">499€</p>

                        <div class="product-buttons">

                            <a href="produit.html">
								<button class="btn btn-view">
									Voir
								</button>
							</a>

                            <button class="btn btn-fav">
                                ❤️
                            </button>

                        </div>

                    </div>

                </div>

                <!-- PRODUCT 2 -->

                <div class="product-card">

                    <img src="https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?q=80&w=1170&auto=format&fit=crop" alt="PC Gamer">

                    <div class="product-info">

                        <h3>PC Gamer RTX</h3>

                        <p class="price">1599€</p>

                        <div class="product-buttons">

                            <a href="produit.html">
								<button class="btn btn-view">
									Voir
								</button>
							</a>

                            <button class="btn btn-fav">
                                ❤️
                            </button>

                        </div>

                    </div>

                </div>

                <!-- PRODUCT 3 -->

                <div class="product-card">

                    <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=1170&auto=format&fit=crop" alt="iPhone">

                    <div class="product-info">

                        <h3>iPhone 15 Pro</h3>

                        <p class="price">1299€</p>

                        <div class="product-buttons">

                            <a href="produit.html">
								<button class="btn btn-view">
									Voir
								</button>
							</a>

                            <button class="btn btn-fav">
                                ❤️
                            </button>

                        </div>

                    </div>

                </div>

                <!-- PRODUCT 4 -->

                <div class="product-card">

                    <img src="https://images.unsplash.com/photo-1546435770-a3e426bf472b?q=80&w=1170&auto=format&fit=crop" alt="Casque Audio">

                    <div class="product-info">

                        <h3>Casque Gaming</h3>

                        <p class="price">149€</p>

                        <div class="product-buttons">

                            <a href="produit.html">
								<button class="btn btn-view">
									Voir
								</button>
							</a>

                            <button class="btn btn-fav">
                                ❤️
                            </button>

                        </div>

                    </div>

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
