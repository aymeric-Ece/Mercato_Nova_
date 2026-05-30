<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enchères - MercaTech</title>

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

        .hero{
            background: linear-gradient(to right, #0f172a, #1e3a8a);
            color: white;
            padding: 70px 60px;
            text-align: center;
        }

        .hero h1{
            font-size: 55px;
            margin-bottom: 20px;
        }

        .hero p{
            font-size: 22px;
            color: #cbd5e1;
        }

        .top-bar{
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 30px 60px;
            background-color: white;
            border-bottom: 1px solid #e2e8f0;
        }

        .search-box{
            width: 70%;
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

        .auction-info{
            font-weight: bold;
            color: #0284c7;
            font-size: 18px;
        }

        .auctions-section{
            padding: 60px;
        }

        .auctions-title{
            font-size: 40px;
            margin-bottom: 40px;
        }

        .auction-grid{
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px,1fr));
            gap: 30px;
        }

        .auction-card{
            background-color: white;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .auction-card:hover{
            transform: translateY(-5px);
        }

        .auction-card img{
            width: 100%;
            height: 250px;
            object-fit: cover;
        }

        .auction-content{
            padding: 25px;
        }

        .auction-content h2{
            margin-bottom: 15px;
            color: #0f172a;
        }

        .auction-content p{
            color: #64748b;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .auction-details{
            margin-bottom: 20px;
        }

        .current-price{
            font-size: 28px;
            font-weight: bold;
            color: #0284c7;
            margin-bottom: 10px;
        }

        .timer{
            color: #ef4444;
            font-weight: bold;
            font-size: 18px;
        }

        .bid-section{
            display: flex;
            gap: 10px;
            margin-top: 20px;
        }

        .bid-section input{
			height: 55px;
            flex: 1;
            padding: 12px;
            border-radius: 10px;
            border: 1px solid #cbd5e1;
            font-size: 16px;
        }

        .bid-btn{
            height: 55px;
			padding: 0 20px;
            border: none;
            border-radius: 10px;
            background-color: #0f172a;
            color: white;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }

        .bid-btn:hover{
            background-color: #1e293b;
        }
		.view-btn{
			height: 55px;
			padding: 0 20px;
			border: none;
			border-radius: 10px;
			background-color: #38bdf8;
			color: white;
			cursor: pointer;
			font-weight: bold;
			transition: 0.3s;
		}

		.view-btn:hover{
			background-color: #0ea5e9;
		}

        footer{
            background-color: #0f172a;
            text-align: center;
            padding: 25px;
            color: white;
            margin-top: 60px;
            border-top: 1px solid #1e293b;
        }

        @media(max-width: 900px){

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

            .hero h1{
                font-size: 40px;
            }

            .hero p{
                font-size: 18px;
            }

            .bid-section{
                flex-direction: column;
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
            <li><a href="Accueil.html">Accueil</a></li>
            <li><a href="catalogue.html">Catalogue</a></li>
            <li><a href="encheres.html">Enchères</a></li>
			<li><a href="mes_annonces.html">Mes annonces</a></li>
            <li><a href="connexion.html">Connexion</a></li>
        </ul>

    </nav>

    <section class="hero">

        <h1>Enchères en direct 🔥</h1>

        <p>
            Participez aux meilleures enchères tech et gaming du moment.
        </p>

    </section>

    <section class="top-bar">

        <div class="search-box">

            <input type="text" placeholder="Rechercher une enchère...">

            <button class="search-btn">
                Rechercher
            </button>

        </div>

        <div class="auction-info">
            ⏳ 24 enchères actives
        </div>

    </section>


    <section class="auctions-section">

        <h2 class="auctions-title">
            Enchères populaires
        </h2>

        <div class="auction-grid">

            <!-- AUCTION 1 -->
            <div class="auction-card">

                <img src="https://images.unsplash.com/photo-1606813907291-d86efa9b94db?q=80&w=1170&auto=format&fit=crop" alt="PS5">

                <div class="auction-content">

                    <h2>PlayStation 5</h2>

                    <p>
                        Console nouvelle génération avec SSD ultra rapide et graphismes 4K.
                    </p>

                    <div class="auction-details">

                        <div class="current-price">
                            Mise actuelle : 520€
                        </div>

                        <div class="timer">
                            ⏳ Fin dans 02h 15min
                        </div>

                    </div>

                    <div class="bid-section">

						<input type="number" placeholder="Votre enchère">

						<button class="bid-btn">
							Enchérir
						</button>

						<a href="produit.html">

							<button class="view-btn">
								Voir
							</button>

						</a>

					</div>

                </div>

            </div>

            <!-- AUCTION 2 -->
            <div class="auction-card">

                <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?q=80&w=1170&auto=format&fit=crop" alt="iPhone">

                <div class="auction-content">

                    <h2>iPhone 15 Pro</h2>

                    <p>
                        Smartphone Apple premium avec écran ProMotion et appareil photo avancé.
                    </p>

                    <div class="auction-details">

                        <div class="current-price">
                            Mise actuelle : 1350€
                        </div>

                        <div class="timer">
                            ⏳ Fin dans 05h 42min
                        </div>

                    </div>

                    <div class="bid-section">

						<input type="number" placeholder="Votre enchère">

						<button class="bid-btn">
							Enchérir
						</button>

						<a href="produit.html">

							<button class="view-btn">
								Voir
							</button>

						</a>

					</div>

                </div>

            </div>

            <!-- AUCTION 3 -->
            <div class="auction-card">

                <img src="https://images.unsplash.com/photo-1593642702821-c8da6771f0c6?q=80&w=1170&auto=format&fit=crop" alt="PC Gamer">

                <div class="auction-content">

                    <h2>PC Gamer RTX</h2>

                    <p>
                        Configuration gaming ultra performante idéale pour le streaming et les jeux AAA.
                    </p>

                    <div class="auction-details">

                        <div class="current-price">
                            Mise actuelle : 1720€
                        </div>

                        <div class="timer">
                            ⏳ Fin dans 01j 03h
                        </div>

                    </div>

                    <div class="bid-section">

						<input type="number" placeholder="Votre enchère">

						<button class="bid-btn">
							Enchérir
						</button>

						<a href="produit.html">

							<button class="view-btn">
								Voir
							</button>

						</a>

					</div>

                </div>

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
